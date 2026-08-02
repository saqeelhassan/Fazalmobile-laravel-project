@extends('admin.layout')
@section('title', 'New Order')
@section('page-title', 'Create New Order')

@section('content')
<div style="margin-bottom:18px">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Back to Orders
    </a>
</div>

@if($errors->any())
<div style="background:#fee2e2;border:1px solid #fca5a5;border-radius:8px;padding:12px 16px;margin-bottom:18px;color:#991b1b">
    <strong><i class="fas fa-exclamation-circle"></i> Please fix the errors below:</strong>
    <ul style="margin:6px 0 0 16px;font-size:13px">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('admin.orders.store') }}" id="orderForm">
    @csrf

    <div style="display:grid;grid-template-columns:1fr 320px;gap:20px">

        {{-- Left --}}
        <div style="display:flex;flex-direction:column;gap:20px">

            {{-- Customer --}}
            <div class="form-card">
                <h3 style="font-size:14px;font-weight:700;margin-bottom:18px;color:#1f2937">
                    <i class="fas fa-user" style="color:#6c63ff"></i> Customer Information
                </h3>
                <div class="form-grid">
                    <div class="form-group full">
                        <label>Customer Name <span class="req">*</span></label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}"
                            placeholder="Full name" class="{{ $errors->has('customer_name') ? 'is-invalid':'' }}">
                        @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" placeholder="e.g. 0300-1234567">
                    </div>
                    <div class="form-group full">
                        <label>Delivery Address</label>
                        <textarea name="customer_address" rows="2" placeholder="Full delivery address...">{{ old('customer_address') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Products --}}
            <div class="form-card">
                <h3 style="font-size:14px;font-weight:700;margin-bottom:18px;color:#1f2937">
                    <i class="fas fa-shopping-cart" style="color:#f59e0b"></i> Order Items
                </h3>

                <div id="itemsContainer">
                    <div class="order-item" style="border:1px solid #e5e7eb;border-radius:8px;padding:14px;margin-bottom:12px;position:relative">
                        <div style="display:grid;grid-template-columns:1fr 100px 140px auto;gap:10px;align-items:end">
                            <div class="form-group" style="margin-bottom:0">
                                <label style="font-size:12px">Product <span class="req">*</span></label>
                                <select name="items[0][product_id]" class="product-select" onchange="fillPrice(this,0)">
                                    <option value="">— Select Product —</option>
                                    @foreach($products as $p)
                                        <option value="{{ $p->id }}" data-price="{{ $p->price }}" data-name="{{ $p->name }}" data-stock="{{ $p->stock }}">
                                            {{ $p->name }} (Stock: {{ $p->stock }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" style="margin-bottom:0">
                                <label style="font-size:12px">Qty <span class="req">*</span></label>
                                <input type="number" name="items[0][quantity]" class="item-qty" value="1" min="1" onchange="clampQty(this)">
                            </div>
                            <div class="form-group" style="margin-bottom:0">
                                <label style="font-size:12px">Unit Price (Rs.) <span class="req">*</span></label>
                                <input type="number" name="items[0][unit_price]" class="item-price" value="" min="0" step="1" onchange="calcTotal()" placeholder="Selling price">
                            </div>
                            <button type="button" onclick="removeItem(this)" style="background:#fee2e2;border:none;color:#dc2626;padding:8px 10px;border-radius:6px;cursor:pointer;font-size:14px;height:38px;margin-bottom:0">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <div class="item-subtotal" style="font-size:12px;color:#6b7280;margin-top:6px;text-align:right">Subtotal: <strong>Rs. 0</strong></div>
                    </div>
                </div>

                <button type="button" onclick="addItem()" class="btn btn-secondary btn-sm" style="width:100%;justify-content:center;margin-top:4px">
                    <i class="fas fa-plus"></i> Add Another Product
                </button>

                <div class="form-grid" style="margin-top:16px">
                    <div class="form-group">
                        <label>Delivery Charge (Rs.)</label>
                        <input type="number" name="delivery_charge" id="deliveryCharge" min="0" step="1"
                            value="{{ old('delivery_charge', 0) }}" onchange="calcTotal()">
                    </div>
                    <div class="form-group">
                        <label>Discount (Rs.)</label>
                        <input type="number" name="discount_amount" id="discountAmount" min="0" step="1"
                            value="{{ old('discount_amount', 0) }}" onchange="calcTotal()">
                    </div>
                </div>

                <div style="margin-top:4px;padding:14px;background:#f9fafb;border-radius:8px">
                    <div style="display:flex;justify-content:space-between;font-size:13px;color:#6b7280;margin-bottom:6px">
                        <span>Items Subtotal</span>
                        <span id="itemsSubtotal">Rs. 0</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:13px;color:#6b7280;margin-bottom:6px">
                        <span>Delivery Charge</span>
                        <span id="summaryDelivery">Rs. 0</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:13px;color:#6b7280;margin-bottom:10px">
                        <span>Discount</span>
                        <span id="summaryDiscount">- Rs. 0</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding-top:10px;border-top:1px solid #e5e7eb">
                        <span style="font-size:14px;font-weight:600">Order Total:</span>
                        <span id="orderTotal" style="font-size:20px;font-weight:700;color:#6c63ff">Rs. 0</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- Right --}}
        <div style="display:flex;flex-direction:column;gap:20px">
            <div class="form-card">
                <h3 style="font-size:14px;font-weight:700;margin-bottom:18px;color:#1f2937">
                    <i class="fas fa-credit-card" style="color:#10b981"></i> Payment
                </h3>
                <div class="form-group" style="margin-bottom:14px">
                    <label>Payment Method <span class="req">*</span></label>
                    <select name="payment_method">
                        <option value="cash"          {{ old('payment_method','cash')==='cash'          ? 'selected':'' }}>Cash</option>
                        <option value="bank_transfer"  {{ old('payment_method')==='bank_transfer'        ? 'selected':'' }}>Bank Transfer</option>
                        <option value="card"           {{ old('payment_method')==='card'                 ? 'selected':'' }}>Card</option>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom:14px">
                    <label>Payment Status <span class="req">*</span></label>
                    <select name="payment_status">
                        <option value="paid"   {{ old('payment_status','paid')==='paid'   ? 'selected':'' }}>Paid</option>
                        <option value="unpaid" {{ old('payment_status')==='unpaid' ? 'selected':'' }}>Unpaid / COD</option>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom:20px">
                    <label>Notes</label>
                    <textarea name="notes" rows="3" placeholder="Any order notes...">{{ old('notes') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                    <i class="fas fa-check"></i> Confirm Order
                </button>
            </div>
        </div>
    </div>
</form>

<script>
const products = @json($products->keyBy('id'));
let itemCount = 1;

function fillPrice(sel, idx) {
    const opt = sel.options[sel.selectedIndex];
    const row = sel.closest('.order-item');
    const qtyInput = row.querySelector('.item-qty');
    if (opt.value) {
        row.querySelector('.item-price').value = opt.dataset.price;
        const stock = parseInt(opt.dataset.stock, 10) || 0;
        qtyInput.max = stock;
        if (parseInt(qtyInput.value, 10) > stock) {
            qtyInput.value = stock;
        }
    } else {
        qtyInput.removeAttribute('max');
    }
    calcTotal();
}

function clampQty(input) {
    const max = parseInt(input.max, 10);
    if (max && parseInt(input.value, 10) > max) {
        input.value = max;
    }
    calcTotal();
}

function calcTotal() {
    let subtotal = 0;
    document.querySelectorAll('.order-item').forEach(row => {
        const qty   = parseFloat(row.querySelector('.item-qty').value) || 0;
        const price = parseFloat(row.querySelector('.item-price').value) || 0;
        const sub   = qty * price;
        subtotal += sub;
        row.querySelector('.item-subtotal strong').textContent = 'Rs. ' + sub.toLocaleString('en-PK');
    });

    const delivery = parseFloat(document.getElementById('deliveryCharge').value) || 0;
    let discount   = parseFloat(document.getElementById('discountAmount').value) || 0;
    discount = Math.min(discount, subtotal);

    const total = subtotal + delivery - discount;

    document.getElementById('itemsSubtotal').textContent   = 'Rs. ' + subtotal.toLocaleString('en-PK');
    document.getElementById('summaryDelivery').textContent = 'Rs. ' + delivery.toLocaleString('en-PK');
    document.getElementById('summaryDiscount').textContent = '- Rs. ' + discount.toLocaleString('en-PK');
    document.getElementById('orderTotal').textContent      = 'Rs. ' + total.toLocaleString('en-PK');
}

function addItem() {
    const idx = itemCount++;
    const productsOptions = Object.values(products).map(p =>
        `<option value="${p.id}" data-price="${p.price}" data-stock="${p.stock}">${p.name} (Stock: ${p.stock})</option>`
    ).join('');

    const html = `<div class="order-item" style="border:1px solid #e5e7eb;border-radius:8px;padding:14px;margin-bottom:12px;position:relative">
        <div style="display:grid;grid-template-columns:1fr 100px 140px auto;gap:10px;align-items:end">
            <div class="form-group" style="margin-bottom:0">
                <label style="font-size:12px">Product <span class="req">*</span></label>
                <select name="items[${idx}][product_id]" class="product-select" onchange="fillPrice(this,${idx})">
                    <option value="">— Select Product —</option>${productsOptions}
                </select>
            </div>
            <div class="form-group" style="margin-bottom:0">
                <label style="font-size:12px">Qty <span class="req">*</span></label>
                <input type="number" name="items[${idx}][quantity]" class="item-qty" value="1" min="1" onchange="clampQty(this)">
            </div>
            <div class="form-group" style="margin-bottom:0">
                <label style="font-size:12px">Unit Price (Rs.) <span class="req">*</span></label>
                <input type="number" name="items[${idx}][unit_price]" class="item-price" value="" min="0" step="1" onchange="calcTotal()" placeholder="Selling price">
            </div>
            <button type="button" onclick="removeItem(this)" style="background:#fee2e2;border:none;color:#dc2626;padding:8px 10px;border-radius:6px;cursor:pointer;font-size:14px;height:38px">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="item-subtotal" style="font-size:12px;color:#6b7280;margin-top:6px;text-align:right">Subtotal: <strong>Rs. 0</strong></div>
    </div>`;
    document.getElementById('itemsContainer').insertAdjacentHTML('beforeend', html);
}

function removeItem(btn) {
    const items = document.querySelectorAll('.order-item');
    if (items.length <= 1) { alert('Order must have at least one item.'); return; }
    btn.closest('.order-item').remove();
    calcTotal();
}
</script>
@endsection
