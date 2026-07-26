@extends('admin.layout')
@section('title', 'Add Stock')
@section('page-title', 'Add Stock (Purchase)')

@section('content')
<div style="margin-bottom:18px">
    <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Back to Inventory
    </a>
</div>

<div style="max-width:640px">
    <div class="form-card">
        <h3 style="font-size:14px;font-weight:700;margin-bottom:18px;color:#1f2937">
            <i class="fas fa-boxes" style="color:#10b981"></i> Stock Purchase Entry
        </h3>

        <form method="POST" action="{{ route('admin.inventory.store') }}">
            @csrf

            <div class="form-group" style="margin-bottom:16px">
                <label>Product <span class="req">*</span></label>
                <select name="product_id" class="{{ $errors->has('product_id') ? 'is-invalid':'' }}" onchange="fillCost(this)">
                    <option value="">— Select Product —</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}"
                            data-cost="{{ $p->cost_price }}"
                            data-stock="{{ $p->stock }}"
                            {{ old('product_id')==$p->id ? 'selected':'' }}>
                            {{ $p->name }} (Stock: {{ $p->stock }})
                        </option>
                    @endforeach
                </select>
                @error('product_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-grid">
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
                    <label>Quantity <span class="req">*</span></label>
                    <input type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1"
                        class="{{ $errors->has('quantity') ? 'is-invalid':'' }}">
                    @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Purchase Price per Unit (Rs.)</label>
                    <input type="number" name="unit_cost" id="unitCost" value="{{ old('unit_cost') }}"
                        placeholder="Cost price in PKR" min="0" step="1">
                    <small style="color:#9ca3af;font-size:11px">Updates product's cost price for profit calculation</small>
                    @error('unit_cost')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Reference / Invoice No.</label>
                    <input type="text" name="reference_number" value="{{ old('reference_number') }}"
                        placeholder="e.g. INV-001">
                </div>
            </div>

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

@push('scripts')
<script>
function fillCost(sel) {
    const opt = sel.options[sel.selectedIndex];
    if (opt && opt.dataset.cost > 0) {
        document.getElementById('unitCost').value = opt.dataset.cost;
    }
}
</script>
@endpush
@endsection
