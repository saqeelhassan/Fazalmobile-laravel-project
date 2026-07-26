<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('my-account');
        }

        $addresses = Auth::user()->addresses()->latest()->get();

        return view('account.address-book', ['u' => Auth::user(), 'addresses' => $addresses]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $address = Auth::user()->addresses()->create($data);

        if ($request->boolean('is_default_shipping')) {
            $this->makeDefault($address, 'is_default_shipping');
        }
        if ($request->boolean('is_default_billing')) {
            $this->makeDefault($address, 'is_default_billing');
        }

        return redirect()->route('account.address-book')->with('success', 'Address added.');
    }

    public function update(Request $request, Address $address)
    {
        abort_unless($address->user_id === Auth::id(), 403);

        $address->update($this->validated($request));

        return redirect()->route('account.address-book')->with('success', 'Address updated.');
    }

    public function destroy(Address $address)
    {
        abort_unless($address->user_id === Auth::id(), 403);

        $address->delete();

        return redirect()->route('account.address-book')->with('success', 'Address removed.');
    }

    public function makeDefaultShipping(Address $address)
    {
        abort_unless($address->user_id === Auth::id(), 403);

        $this->makeDefault($address, 'is_default_shipping');

        return redirect()->route('account.address-book')->with('success', 'Default shipping address updated.');
    }

    public function makeDefaultBilling(Address $address)
    {
        abort_unless($address->user_id === Auth::id(), 403);

        $this->makeDefault($address, 'is_default_billing');

        return redirect()->route('account.address-book')->with('success', 'Default billing address updated.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'label'        => ['nullable', 'string', 'max:50'],
            'full_name'    => ['required', 'string', 'max:255'],
            'phone'        => ['required', 'string', 'max:30'],
            'province'     => ['nullable', 'string', 'max:100'],
            'city'         => ['nullable', 'string', 'max:100'],
            'zone'         => ['nullable', 'string', 'max:100'],
            'address_line' => ['required', 'string', 'max:255'],
            'landmark'     => ['nullable', 'string', 'max:255'],
            'postal_code'  => ['nullable', 'string', 'max:20'],
        ]);
    }

    private function makeDefault(Address $address, string $column): void
    {
        Auth::user()->addresses()->where('id', '!=', $address->id)->update([$column => false]);
        $address->update([$column => true]);
    }
}
