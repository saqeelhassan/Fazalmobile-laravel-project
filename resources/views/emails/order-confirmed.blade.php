<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Confirmed</title>
</head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:'Segoe UI',Arial,sans-serif;color:#1f2937">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f3f4f6;padding:32px 0">
    <tr>
        <td align="center">
            <table role="presentation" width="580" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:14px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.06)">

                {{-- Header --}}
                <tr>
                    <td style="background:linear-gradient(135deg,#c26af5,#54f0ff);padding:36px 40px;text-align:center">
                        <div style="width:56px;height:56px;border-radius:50%;background:rgba(255,255,255,.25);display:inline-block;line-height:56px;font-size:26px;color:#fff;margin-bottom:14px">&#10003;</div>
                        <h1 style="margin:0;color:#fff;font-size:21px;font-weight:700">Order Confirmed</h1>
                        <p style="margin:8px 0 0;color:rgba(255,255,255,.9);font-size:13.5px">Order {{ $order->order_number }}</p>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="padding:36px 40px 8px">
                        <p style="font-size:14.5px;line-height:1.7;color:#374151;margin:0 0 8px">Hi {{ $order->customer_name }},</p>
                        <p style="font-size:14.5px;line-height:1.7;color:#374151;margin:0 0 24px">
                            Great news — your order has been reviewed and <strong style="color:#16a34a">confirmed</strong>.
                            It's now being prepared for delivery.
                        </p>
                    </td>
                </tr>

                {{-- Order items --}}
                <tr>
                    <td style="padding:0 40px">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e7eb;border-radius:10px;overflow:hidden">
                            <tr style="background:#f9fafb">
                                <td style="padding:12px 16px;font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.4px">Item</td>
                                <td style="padding:12px 16px;font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.4px;text-align:center">Qty</td>
                                <td style="padding:12px 16px;font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.4px;text-align:right">Subtotal</td>
                            </tr>
                            @foreach($order->items as $item)
                            <tr>
                                <td style="padding:12px 16px;border-top:1px solid #f3f4f6;font-size:13.5px;color:#1f2937">{{ $item->product_name }}</td>
                                <td style="padding:12px 16px;border-top:1px solid #f3f4f6;font-size:13.5px;color:#1f2937;text-align:center">{{ $item->quantity }}</td>
                                <td style="padding:12px 16px;border-top:1px solid #f3f4f6;font-size:13.5px;color:#1f2937;text-align:right">Rs. {{ number_format($item->subtotal, 0) }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="2" style="padding:14px 16px;border-top:2px solid #e5e7eb;font-size:14px;font-weight:700;text-align:right">Total</td>
                                <td style="padding:14px 16px;border-top:2px solid #e5e7eb;font-size:15px;font-weight:700;color:#6c63ff;text-align:right">Rs. {{ number_format($order->total_amount, 0) }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- Delivery details --}}
                <tr>
                    <td style="padding:24px 40px 0">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f9fafb;border-radius:10px;padding:18px 20px">
                            <tr><td style="font-size:12px;color:#9ca3af;padding-bottom:4px">Delivery Address</td></tr>
                            <tr><td style="font-size:13.5px;color:#374151;padding-bottom:12px">{{ $order->customer_address }}</td></tr>
                            <tr><td style="font-size:12px;color:#9ca3af;padding-bottom:4px">Payment Method</td></tr>
                            <tr><td style="font-size:13.5px;color:#374151">{{ ucwords(str_replace('_',' ', $order->payment_method)) }}</td></tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding:28px 40px 36px">
                        <p style="font-size:13px;line-height:1.7;color:#6b7280;margin:0">
                            Questions about your order? Just reply to this email and our team will be happy to help.
                        </p>
                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="background:#f9fafb;padding:20px 40px;text-align:center;border-top:1px solid #f3f4f6">
                        <p style="margin:0;font-size:12px;color:#9ca3af">{{ config('app.name') }} &middot; Thank you for shopping with us</p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>
