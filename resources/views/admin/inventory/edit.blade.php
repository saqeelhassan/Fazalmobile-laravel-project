@extends('admin.layout')
@section('title', 'Edit Stock Transaction')
@section('page-title', 'Edit Stock Transaction')

@section('content')
<div style="margin-bottom:18px">
    <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Back to Inventory
    </a>
</div>

<div style="max-width:600px">
    <div class="form-card">
        <h3 style="font-size:14px;font-weight:700;margin-bottom:18px;color:#1f2937">
            <i class="fas fa-boxes" style="color:#10b981"></i> Edit Stock Transaction
        </h3>

        <form method="POST" action="{{ route('admin.inventory.update', $transaction) }}">
            @csrf
            @method('PUT')

            <div class="form-grid" style="margin-bottom:16px">
                <div class="form-group">
                    <label>Transaction Type <span class="req">*</span></label>
                    <select name="type" class="{{ $errors->has('type') ? 'is-invalid':'' }}">
                        <option value="purchase"   {{ old('type', $transaction->type) === 'purchase'   ? 'selected':'' }}>Purchase (Stock In)</option>
                        <option value="adjustment" {{ old('type', $transaction->type) === 'adjustment' ? 'selected':'' }}>Adjustment</option>
                        <option value="return"     {{ old('type', $transaction->type) === 'return'     ? 'selected':'' }}>Customer Return</option>
                    </select>
                    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Product <span class="req">*</span></label>
                    <select name="product_id" class="{{ $errors->has('product_id') ? 'is-invalid':'' }}">
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ old('product_id', $transaction->product_id) == $p->id ? 'selected':'' }}>{{ $p->name }} (Stock: {{ $p->stock }})</option>
                        @endforeach
                    </select>
                    @error('product_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Quantity <span class="req">*</span></label>
                    <input type="number" name="quantity" min="1" value="{{ old('quantity', $transaction->quantity) }}"
                        class="{{ $errors->has('quantity') ? 'is-invalid':'' }}">
                    @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Unit Cost (Rs.)</label>
                    <input type="number" name="unit_cost" min="0" step="1" value="{{ old('unit_cost', $transaction->unit_cost) }}">
                </div>

                <div class="form-group">
                    <label>Reference / Invoice No.</label>
                    <input type="text" name="reference_number" value="{{ old('reference_number', $transaction->reference_number) }}"
                        placeholder="e.g. INV-001">
                </div>
            </div>

            <div class="form-group" style="margin-bottom:24px">
                <label>Notes</label>
                <textarea name="notes" rows="3">{{ old('notes', $transaction->notes) }}</textarea>
            </div>

            <div style="display:flex;gap:10px">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
