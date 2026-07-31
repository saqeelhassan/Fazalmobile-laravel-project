@extends('admin.layout')
@section('title', 'Add Stock')
@section('page-title', 'Add Stock (Purchase)')

@section('content')
<div style="margin-bottom:18px">
    <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Back to Inventory
    </a>
</div>

<div style="max-width:900px">
    <div class="form-card">
        <h3 style="font-size:14px;font-weight:700;margin-bottom:18px;color:#1f2937">
            <i class="fas fa-boxes" style="color:#10b981"></i> Stock Purchase Entry
        </h3>

        <form method="POST" action="{{ route('admin.inventory.store') }}" id="stockForm">
            @csrf

            <div class="form-grid" style="margin-bottom:16px">
                <div class="form-group">
                    <label>Transaction Type <span class="req">*</span></label>
                    <select name="type" class="{{ $errors->has('type') ? 'is-invalid':'' }}">
                        <option value="purchase" {{ old('type','purchase')==='purchase' ? 'selected':'' }}>Purchase (Stock In)</option>
                        <option value="adjustment" {{ old('type')==='adjustment' ? 'selected':'' }}>Adjustment</option>
                        <option value="return" {{ old('type')==='return' ? 'selected':'' }}>Customer Return</option>
                    </select>
                    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Reference / Invoice No.</label>
                    <input type="text" name="reference_number" value="{{ old('reference_number') }}"
                        placeholder="e.g. INV-001">
                </div>
            </div>

            <label style="display:block;margin-bottom:8px;font-weight:600;font-size:13px;color:#374151">Products <span class="req">*</span></label>
            <table style="width:100%;border-collapse:collapse;margin-bottom:10px" id="itemsTable">
                <thead>
                    <tr>
                        <th style="text-align:left;font-size:11px;color:#6b7280;text-transform:uppercase;padding:8px 6px">Product</th>
                        <th style="text-align:left;font-size:11px;color:#6b7280;text-transform:uppercase;padding:8px 6px;width:110px">Quantity</th>
                        <th style="text-align:left;font-size:11px;color:#6b7280;text-transform:uppercase;padding:8px 6px;width:160px">Unit Cost (Rs.)</th>
                        <th style="width:40px"></th>
                    </tr>
                </thead>
                <tbody id="itemsBody"></tbody>
            </table>
            @error('items')<div class="invalid-feedback" style="margin-bottom:10px">{{ $message }}</div>@enderror

            <button type="button" class="btn btn-secondary btn-sm" id="addRowBtn" style="margin-bottom:24px">
                <i class="fas fa-plus"></i> Add Another Product
            </button>

            <div class="form-group" style="margin-bottom:24px">
                <label>Notes</label>
                <textarea name="notes" rows="3" placeholder="Any notes about this purchase...">{{ old('notes') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Add Stock
            </button>
        </form>
    </div>
</div>

@php
    $productsJs = $products->map(fn($p) => ['id' => $p->id, 'name' => $p->name, 'stock' => $p->stock, 'cost' => $p->cost_price]);
    $oldItemsJs = old('items', [['product_id' => '', 'quantity' => 1, 'unit_cost' => '']]);
@endphp
@push('scripts')
<script>
const products = @json($productsJs);
const oldItems = @json($oldItemsJs);

let rowIndex = 0;

function productOptions(selectedId) {
    let html = '<option value="">— Select Product —</option>';
    products.forEach(p => {
        const selected = String(p.id) === String(selectedId) ? 'selected' : '';
        html += `<option value="${p.id}" data-cost="${p.cost}" ${selected}>${p.name} (Stock: ${p.stock})</option>`;
    });
    return html;
}

function addRow(data = {}) {
    const i = rowIndex++;
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td style="padding:6px"><select name="items[${i}][product_id]" class="row-product" onchange="fillCost(this)">${productOptions(data.product_id)}</select></td>
        <td style="padding:6px"><input type="number" name="items[${i}][quantity]" min="1" value="${data.quantity ?? 1}"></td>
        <td style="padding:6px"><input type="number" name="items[${i}][unit_cost]" min="0" step="1" class="row-cost" value="${data.unit_cost ?? ''}" placeholder="Cost price"></td>
        <td style="padding:6px;text-align:center"><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)" title="Remove"><i class="fas fa-times"></i></button></td>
    `;
    document.getElementById('itemsBody').appendChild(tr);
}

function removeRow(btn) {
    const tbody = document.getElementById('itemsBody');
    if (tbody.rows.length > 1) {
        btn.closest('tr').remove();
    }
}

function fillCost(sel) {
    const opt = sel.options[sel.selectedIndex];
    const costInput = sel.closest('tr').querySelector('.row-cost');
    if (opt && opt.dataset.cost > 0 && !costInput.value) {
        costInput.value = opt.dataset.cost;
    }
}

document.getElementById('addRowBtn').addEventListener('click', () => addRow());

oldItems.forEach(item => addRow(item));
</script>
@endpush
@endsection
