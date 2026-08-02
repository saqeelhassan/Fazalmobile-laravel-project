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

    public function edit(InventoryTransaction $transaction)
    {
        abort_if($transaction->type === 'sale', 403, 'Sale transactions are tied to an order and cannot be edited.');

        $products = Product::orderBy('name')->get();
        return view('admin.inventory.edit', compact('transaction', 'products'));
    }

    public function update(Request $request, InventoryTransaction $transaction)
    {
        abort_if($transaction->type === 'sale', 403, 'Sale transactions are tied to an order and cannot be edited.');

        $validated = $request->validate([
            'type'             => ['required', 'in:purchase,adjustment,return'],
            'product_id'       => ['required', 'exists:products,id'],
            'quantity'         => ['required', 'integer', 'min:1'],
            'unit_cost'        => ['nullable', 'numeric', 'min:0'],
            'reference_number' => ['nullable', 'string', 'max:100'],
            'notes'            => ['nullable', 'string', 'max:500'],
        ]);

        DB::transaction(function () use ($validated, $transaction) {
            // Reverse this transaction's original effect on stock, then apply
            // the new effect — handles quantity changes and moving the
            // transaction to a different product.
            Product::where('id', $transaction->product_id)->decrement('stock', $transaction->quantity);
            Product::where('id', $transaction->product_id)->where('stock', '<', 0)->update(['stock' => 0]);

            $transaction->update([
                'type'             => $validated['type'],
                'product_id'       => $validated['product_id'],
                'quantity'         => $validated['quantity'],
                'unit_cost'        => $validated['unit_cost'] ?? 0,
                'reference_number' => $validated['reference_number'] ?? null,
                'notes'            => $validated['notes'] ?? null,
            ]);

            Product::where('id', $validated['product_id'])->increment('stock', $validated['quantity']);
        });

        return redirect()->route('admin.inventory.index')->with('success', 'Stock transaction updated.');
    }

    public function destroy(InventoryTransaction $transaction)
    {
        abort_if($transaction->type === 'sale', 403, 'Sale transactions are tied to an order and cannot be deleted.');

        DB::transaction(function () use ($transaction) {
            Product::where('id', $transaction->product_id)->decrement('stock', $transaction->quantity);
            Product::where('id', $transaction->product_id)->where('stock', '<', 0)->update(['stock' => 0]);
            $transaction->delete();
        });

        return redirect()->route('admin.inventory.index')->with('success', 'Stock transaction deleted.');
    }
}
