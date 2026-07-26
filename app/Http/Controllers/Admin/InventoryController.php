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
            'product_id'       => ['required', 'exists:products,id'],
            'type'             => ['required', 'in:purchase,adjustment,return'],
            'quantity'         => ['required', 'integer', 'min:1'],
            'unit_cost'        => ['nullable', 'numeric', 'min:0'],
            'reference_number' => ['nullable', 'string', 'max:100'],
            'notes'            => ['nullable', 'string', 'max:500'],
        ]);

        $validated['created_by'] = Auth::guard('admin')->id();
        $validated['unit_cost']  = $validated['unit_cost'] ?? 0;
        $validated['unit_price'] = 0;

        DB::transaction(function () use ($validated) {
            InventoryTransaction::create($validated);
            // Increase stock for purchases/returns
            Product::where('id', $validated['product_id'])
                ->increment('stock', $validated['quantity']);

            // Update cost_price if provided
            if ($validated['unit_cost'] > 0) {
                Product::where('id', $validated['product_id'])
                    ->update(['cost_price' => $validated['unit_cost']]);
            }
        });

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Stock added successfully.');
    }
}
