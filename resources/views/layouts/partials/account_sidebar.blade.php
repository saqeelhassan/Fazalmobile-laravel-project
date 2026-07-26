{{-- Account sidebar. Requires: $u (authenticated User). Optional: $active ('profile'|'orders'|null) --}}
<div style="background:#fff;border:1px solid #eee;border-radius:8px;padding:22px">
    <p style="margin:0 0 10px;color:#666">Hello, <strong>{{ $u->name }}</strong></p>
    @if($u->email_verified_at || $u->google_id || $u->facebook_id)
        <span style="display:inline-block;background:#dcfce7;color:#166534;font-size:12px;font-weight:600;padding:4px 12px;border-radius:20px;margin-bottom:20px">✓ Verified Account</span>
    @else
        <span style="display:inline-block;background:#f3f4f6;color:#6b7280;font-size:12px;font-weight:600;padding:4px 12px;border-radius:20px;margin-bottom:20px">Not Verified</span>
    @endif

    <ul style="list-style:none;margin:0;padding:0">
        <li style="margin-bottom:14px">
            <a href="{{ url('/my-account') }}#manage-account" style="color:#333;font-weight:700;text-decoration:none">Manage My Account</a>
            <ul style="list-style:none;margin:10px 0 0;padding-left:12px">
                <li style="margin-bottom:10px"><a href="{{ route('account.profile') }}" style="color:{{ ($active ?? null) === 'profile' ? '#7c3aed' : '#666' }};text-decoration:none;font-size:14px;font-weight:{{ ($active ?? null) === 'profile' ? '700' : '400' }}">My Profile</a></li>
                <li><a href="{{ route('account.address-book') }}" style="color:{{ ($active ?? null) === 'address' ? '#7c3aed' : '#666' }};text-decoration:none;font-size:14px;font-weight:{{ ($active ?? null) === 'address' ? '700' : '400' }}">Address Book</a></li>
            </ul>
        </li>
        <li style="margin-bottom:14px;border-top:1px solid #f0f0f0;padding-top:14px">
            <a href="{{ url('/my-account') }}#orders" style="color:#333;font-weight:700;text-decoration:none">My Orders</a>
            <ul style="list-style:none;margin:10px 0 0;padding-left:12px">
                <li style="margin-bottom:10px"><a href="{{ route('account.returns') }}" style="color:{{ ($active ?? null) === 'returns' ? '#7c3aed' : '#666' }};text-decoration:none;font-size:14px;font-weight:{{ ($active ?? null) === 'returns' ? '700' : '400' }}">My Returns</a></li>
                <li style="margin-bottom:10px"><a href="{{ route('account.cancellations') }}" style="color:{{ ($active ?? null) === 'cancellations' ? '#7c3aed' : '#666' }};text-decoration:none;font-size:14px;font-weight:{{ ($active ?? null) === 'cancellations' ? '700' : '400' }}">My Cancellations</a></li>
                <li><a href="{{ url('/returns-exchange') }}" style="color:#666;text-decoration:none;font-size:14px">Returns / Exchange Policy</a></li>
            </ul>
        </li>
        <li style="margin-bottom:14px;border-top:1px solid #f0f0f0;padding-top:14px">
            <a href="{{ url('/wishlist') }}" style="color:#333;font-weight:700;text-decoration:none">My Wishlist</a>
        </li>
        <li style="border-top:1px solid #f0f0f0;padding-top:14px">
            <form method="post" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="border:none;background:none;padding:0;color:#e11d48;font-weight:700;cursor:pointer">Logout</button>
            </form>
        </li>
    </ul>
</div>
