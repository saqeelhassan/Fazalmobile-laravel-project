<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmedMail;
use App\Models\InventoryTransaction;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items')->latest();

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%$search%")
                  ->orWhere('customer_name', 'like', "%$search%")
                  ->orWhere('customer_phone', 'like', "%$search%");
            });
        }

        $orders = $query->paginate(15)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::where('status', 'active')->where('stock', '>', 0)->orderBy('name')->get();
        return view('admin.orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name'    => ['required', 'string', 'max:200'],
            'customer_phone'   => ['nullable', 'string', 'max:30'],
            'customer_address' => ['nullable', 'string', 'max:500'],
            'payment_method'   => ['required', 'in:cash,bank_transfer,card'],
            'payment_status'   => ['required', 'in:unpaid,paid'],
            'notes'            => ['nullable', 'string', 'max:1000'],
            'items'            => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity'   => ['required', 'integer', 'min:1'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($request) {
            $totalAmount = 0;
            $totalCost   = 0;
            $orderItems  = [];

            foreach ($request->items as $item) {
                $product  = Product::findOrFail($item['product_id']);
                $qty      = (int) $item['quantity'];
                $price    = (float) $item['unit_price'];
                $cost     = (float) ($product->cost_price ?? 0);
                $subtotal = $price * $qty;

                if ($product->stock < $qty) {
                    abort(422, "Insufficient stock for {$product->name}. Available: {$product->stock}");
                }

                $totalAmount += $subtotal;
                $totalCost   += $cost * $qty;

                $orderItems[] = [
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'quantity'     => $qty,
                    'unit_price'   => $price,
                    'unit_cost'    => $cost,
                    'subtotal'     => $subtotal,
                ];

                // Deduct stock
                $product->decrement('stock', $qty);
                if ($product->stock <= 0) {
                    $product->update(['status' => 'out_of_stock']);
                }

                // Log inventory transaction
                InventoryTransaction::create([
                    'product_id'  => $product->id,
                    'type'        => 'sale',
                    'quantity'    => -$qty,
                    'unit_cost'   => $cost,
                    'unit_price'  => $price,
                    'created_by'  => Auth::guard('admin')->id(),
                ]);
            }

            $order = Order::create([
                'order_number'   => Order::generateOrderNumber(),
                'customer_name'  => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'total_amount'   => $totalAmount,
                'total_cost'     => $totalCost,
                'profit'         => $totalAmount - $totalCost,
                'status'         => 'confirmed',
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
                'stock_deducted' => true,
                'notes'          => $request->notes,
                'created_by'     => Auth::guard('admin')->id(),
            ]);

            foreach ($orderItems as $item) {
                $item['order_id'] = $order->id;
                OrderItem::create($item);
            }
        });

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => ['required', 'in:pending,confirmed,delivered,cancelled,returned']]);

        $newStatus       = $request->status;
        $justConfirmed   = $newStatus === 'confirmed' && $order->status !== 'confirmed';

        if ($justConfirmed && !$order->stock_deducted) {
            $order->load('items.product');

            foreach ($order->items as $item) {
                $product = $item->product;
                if (!$product) continue;

                if ($product->stock < $item->quantity) {
                    return back()->with('error', "Cannot confirm: insufficient stock for \"{$product->name}\". Available: {$product->stock}, needed: {$item->quantity}.");
                }
            }

            DB::transaction(function () use ($order) {
                foreach ($order->items as $item) {
                    $product = $item->product;
                    if (!$product) continue;

                    $product->decrement('stock', $item->quantity);
                    if ($product->stock <= 0) {
                        $product->update(['status' => 'out_of_stock']);
                    }

                    InventoryTransaction::create([
                        'product_id'  => $product->id,
                        'type'        => 'sale',
                        'quantity'    => -$item->quantity,
                        'unit_cost'   => $item->unit_cost,
                        'unit_price'  => $item->unit_price,
                        'created_by'  => Auth::guard('admin')->id(),
                    ]);
                }

                $order->update(['stock_deducted' => true]);
            });
        }

        $order->update(['status' => $newStatus]);

        if ($justConfirmed) {
            $recipient = $order->customer_email ?: $order->user?->email;
            if ($recipient) {
                Mail::to($recipient)->send(new OrderConfirmedMail($order));
            }
        }

        return back()->with('success', 'Order status updated.');
    }
}
