<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'customer_name'    => ['required', 'string', 'max:200'],
            'customer_email'   => ['required', 'email', 'max:200'],
            'customer_phone'   => ['required', 'string', 'max:30'],
            'customer_address' => ['required', 'string', 'max:500'],
            'payment_method'   => ['required', 'in:cash,bank_transfer,card'],
            'notes'            => ['nullable', 'string', 'max:1000'],
            'cart'             => ['required', 'string'],
        ]);

        $cart = json_decode($request->input('cart'), true);
        if (!is_array($cart) || empty($cart)) {
            return back()->withInput()->with('error', 'Your cart is empty.');
        }

        $order = DB::transaction(function () use ($request, $cart) {
            $totalAmount = 0;
            $totalCost   = 0;
            $orderItems  = [];

            foreach ($cart as $line) {
                $productId = $line['id'] ?? null;
                $qty       = max(1, (int) ($line['qty'] ?? 1));
                if (!$productId) continue;

                $product = Product::where('id', $productId)->where('status', 'active')->first();
                if (!$product) continue;

                if ($product->stock < $qty) {
                    abort(422, "Insufficient stock for {$product->name}. Available: {$product->stock}");
                }

                $price    = (float) ($product->sale_price ?: $product->price);
                $cost     = (float) ($product->cost_price ?? 0);
                $subtotal = $price * $qty;

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
            }

            if (empty($orderItems)) {
                abort(422, 'None of the items in your cart are currently available.');
            }

            $order = Order::create([
                'user_id'          => Auth::id(),
                'order_number'     => Order::generateOrderNumber(),
                'customer_name'    => $request->customer_name,
                'customer_email'   => $request->customer_email,
                'customer_phone'   => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'total_amount'     => $totalAmount,
                'total_cost'       => $totalCost,
                'profit'           => $totalAmount - $totalCost,
                'status'           => 'pending',
                'payment_method'   => $request->payment_method,
                'payment_status'   => 'unpaid',
                'stock_deducted'   => false,
                'notes'            => $request->notes,
            ]);

            foreach ($orderItems as $item) {
                $item['order_id'] = $order->id;
                OrderItem::create($item);
            }

            return $order;
        });

        return redirect()->route('checkout.success', $order->order_number);
    }

    public function success(string $orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();

        return view('checkout-success', compact('order'));
    }
}
