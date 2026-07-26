{{-- Edit Profile modal. Requires: $u (authenticated User) --}}
<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width:440px;margin:30px auto">
        <div class="modal-content" style="border-radius:10px;border:none">
            <div class="modal-body" style="padding:30px">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute;top:14px;right:18px;background:none;border:none;font-size:24px;line-height:1;color:#9ca3af">&times;</button>
                <h3 style="margin:0 0 20px;font-size:18px;font-weight:700">Edit Personal Profile</h3>
                <form method="post" action="{{ route('my-account.profile') }}">
                    @csrf
                    <div class="form-group" style="margin-bottom:18px">
                        <label style="display:block;margin-bottom:8px">Full name</label>
                        <input type="text" class="form-control bdr" name="name" value="{{ $u->name }}" style="width:100%;box-sizing:border-box;margin-bottom:0">
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px">
                        <input type="checkbox" id="sms_pref" name="receive_marketing_sms" value="1" @checked($u->receive_marketing_sms)>
                        <label for="sms_pref" style="margin:0">Receive marketing SMS</label>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:20px">
                        <input type="checkbox" id="email_pref" name="receive_marketing_emails" value="1" @checked($u->receive_marketing_emails)>
                        <label for="email_pref" style="margin:0">Receive marketing emails</label>
                    </div>
                    <button type="submit" class="btn btn-submit btn-gradient" style="width:100%">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
