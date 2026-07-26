{{-- Address add/edit form fields. Requires: $action (route url), $address (Address model or null) --}}
@php
    $provinces = ['Punjab', 'Sindh', 'Khyber Pakhtunkhwa', 'Balochistan', 'Gilgit-Baltistan', 'Azad Kashmir', 'Islamabad Capital Territory'];
@endphp
<form method="post" action="{{ $action }}">
    @csrf
    <div class="row" style="margin:0 -10px">
        <div class="col-sm-6" style="padding:0 10px">
            <div class="form-group" style="margin-bottom:18px">
                <label style="display:block;margin-bottom:8px">Full Name</label>
                <input type="text" class="form-control bdr" name="full_name" value="{{ optional($address)->full_name }}" style="width:100%;box-sizing:border-box;margin-bottom:0">
            </div>
            <div class="form-group" style="margin-bottom:18px">
                <label style="display:block;margin-bottom:8px">Phone Number</label>
                <input type="text" class="form-control bdr" name="phone" value="{{ optional($address)->phone }}" style="width:100%;box-sizing:border-box;margin-bottom:0">
            </div>
            <div class="form-group" style="margin-bottom:18px">
                <label style="display:block;margin-bottom:8px">Landmark (Optional)</label>
                <input type="text" class="form-control bdr" name="landmark" value="{{ optional($address)->landmark }}" style="width:100%;box-sizing:border-box;margin-bottom:0">
            </div>
        </div>
        <div class="col-sm-6" style="padding:0 10px">
            <div class="form-group" style="margin-bottom:18px">
                <label style="display:block;margin-bottom:8px">Province / Region</label>
                <select name="province" class="form-control bdr" style="width:100%;box-sizing:border-box;height:44px;border-radius:8px;border:1px solid #eaeaea;padding:0 12px">
                    <option value="">Select province</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province }}" @selected(optional($address)->province === $province)>{{ $province }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="margin-bottom:18px">
                <label style="display:block;margin-bottom:8px">City</label>
                <input type="text" class="form-control bdr" name="city" value="{{ optional($address)->city }}" style="width:100%;box-sizing:border-box;margin-bottom:0">
            </div>
            <div class="form-group" style="margin-bottom:18px">
                <label style="display:block;margin-bottom:8px">Zone</label>
                <input type="text" class="form-control bdr" name="zone" value="{{ optional($address)->zone }}" style="width:100%;box-sizing:border-box;margin-bottom:0">
            </div>
        </div>
    </div>

    <div class="form-group" style="margin-bottom:20px">
        <label style="display:block;margin-bottom:8px">Address</label>
        <input type="text" class="form-control bdr" name="address_line" value="{{ optional($address)->address_line }}" style="width:100%;box-sizing:border-box;margin-bottom:0">
    </div>

    <div class="form-group" style="margin-bottom:24px">
        <label style="display:block;margin-bottom:10px">Select a label for effective delivery:</label>
        <div style="display:flex;gap:10px;max-width:280px">
            @foreach(['Office', 'Home'] as $labelOption)
            <label class="address-label-option" style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:8px 14px;border:1px solid #eaeaea;border-radius:20px;cursor:pointer;font-weight:600;font-size:12px;color:#666">
                <input type="radio" name="label" value="{{ $labelOption }}" @checked((optional($address)->label ?? 'Home') === $labelOption) style="display:none" onchange="this.closest('form').querySelectorAll('.address-label-option').forEach(function(el){el.style.borderColor='#eaeaea';el.style.color='#666';el.style.background='#fff';}); this.closest('.address-label-option').style.borderColor='#7c3aed'; this.closest('.address-label-option').style.color='#7c3aed'; this.closest('.address-label-option').style.background='#faf5ff';">
                {{ strtoupper($labelOption) }}
            </label>
            @endforeach
        </div>
    </div>

    <div style="display:flex;gap:12px;justify-content:flex-end">
        <button type="button" data-dismiss="modal" style="padding:11px 26px;border-radius:30px;border:1px solid #e5e5e5;background:#f3f4f6;color:#374151;font-weight:600;cursor:pointer">Cancel</button>
        <button type="submit" class="btn btn-submit btn-gradient" style="width:auto;height:auto;line-height:normal;padding:13px 34px;display:flex;align-items:center;justify-content:center;text-align:center">Save</button>
    </div>
</form>

<script>
    document.querySelectorAll('.address-label-option input[type=radio]:checked').forEach(function (input) {
        var el = input.closest('.address-label-option');
        el.style.borderColor = '#7c3aed';
        el.style.color = '#7c3aed';
        el.style.background = '#faf5ff';
    });
</script>
