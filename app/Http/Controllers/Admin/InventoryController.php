<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryTransaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = InventoryTransaction::with('product')->latest();

        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }
        if ($product_id = $request->get('product_id')) {
            $query->where('product_id', $product_id);
        }

        $transactions = $query->paginate(20)->withQueryString();
        $products     = Product::orderBy('name')->get();

        return view('admin.inventory.index', compact('transactions', 'products'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('admin.inventory.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'                    => ['required', 'in:purchase,adjustment,return'],
            'reference_number'        => ['nullable', 'string', 'max:100'],
            'notes'                   => ['nullable', 'string', 'max:500'],
            'items'                   => ['required', 'array', 'min:1'],
            'items.*.product_id'      => ['required', 'exists:products,id'],
            'items.*.quantity'        => ['required', 'integer', 'min:1'],
            'items.*.unit_cost'       => ['nullable', 'numeric', 'min:0'],
        ]);

        $createdBy = Auth::guard('admin')->id();

        DB::transaction(function () use ($validated, $createdBy) {
            foreach ($validated['items'] as $item) {
                $unitCost = $item['unit_cost'] ?? 0;

                InventoryTransaction::create([
                    'product_id'       => $item['product_id'],
                    'type'             => $validated['type'],
                    'quantity'         => $item['quantity'],
                    'unit_cost'        => $unitCost,
                    'unit_price'       => 0,
                    'reference_number' => $validated['reference_number'] ?? null,
                    'notes'            => $validated['notes'] ?? null,
                    'created_by'       => $createdBy,
                ]);

                // Increase stock for purchases/returns
                Product::where('id', $item['product_id'])
                    ->increment('stock', $item['quantity']);

                // Update cost_price if provided
                if ($unitCost > 0) {
                    Product::where('id', $item['product_id'])
                        ->update(['cost_price' => $unitCost]);
                }
            }
        });

        $count = count($validated['items']);
        return redirect()->route('admin.inventory.index')
            ->with('success', $count > 1 ? "Stock added for {$count} products." : 'Stock added successfully.');
    }
}
