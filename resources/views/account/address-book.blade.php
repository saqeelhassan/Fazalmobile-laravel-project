@php
    $pageTitle    = 'Address Book — Fazal Mobiles';
    $currentPage  = 'shop';
    $headerClass  = 'header-v5';
    $extraCss     = [];
    $extraScripts = [];
@endphp
@extends('layouts.app')

@section('content')
<!--content-->
        <div class="container container-240">

            <div class="myaccount">
                <ul class="breadcrumb v3">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/my-account') }}">My Account</a></li>
                    <li class="active">Address Book</li>
                </ul>

                @if(session('success'))
                <div class="alert alert-success" style="padding:14px 18px;border-radius:6px;background:#eafaf0;color:#1a7f4e;border:1px solid #b7ecd0;margin-bottom:25px">
                    {{ session('success') }}
                </div>
                @endif

                <div class="row" style="margin:0 -15px">
                    {{-- Sidebar --}}
                    <div class="col-md-3 col-sm-4 col-xs-12" style="padding:0 15px;margin-bottom:25px">
                        @include('layouts.partials.account_sidebar', ['u' => $u, 'active' => 'address'])
                    </div>

                    {{-- Main content --}}
                    <div class="col-md-9 col-sm-8 col-xs-12" style="padding:0 15px">
                        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:20px">
                            <h1 style="font-size:24px;font-weight:600;margin:0">Address Book</h1>
                            <button type="button" class="btn btn-submit btn-gradient" data-toggle="modal" data-target="#addAddressModal">+ Add New Address</button>
                        </div>

                        <div style="background:#fff;border:1px solid #eee;border-radius:8px;overflow:hidden">
                            @if($addresses->count())
                            <div style="overflow-x:auto">
                                <table style="width:100%;border-collapse:collapse">
                                    <thead>
                                        <tr style="background:#fafafa;border-bottom:1px solid #eee;text-align:left">
                                            <th style="padding:12px 16px;font-size:12px;color:#9ca3af;text-transform:uppercase">Full Name</th>
                                            <th style="padding:12px 16px;font-size:12px;color:#9ca3af;text-transform:uppercase">Address</th>
                                            <th style="padding:12px 16px;font-size:12px;color:#9ca3af;text-transform:uppercase">Postcode</th>
                                            <th style="padding:12px 16px;font-size:12px;color:#9ca3af;text-transform:uppercase">Phone Number</th>
                                            <th style="padding:12px 16px;font-size:12px;color:#9ca3af;text-transform:uppercase">Default</th>
                                            <th style="padding:12px 16px"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($addresses as $address)
                                        <tr style="border-bottom:1px solid #f0f0f0">
                                            <td style="padding:16px;font-weight:600;vertical-align:top">{{ $address->full_name }}</td>
                                            <td style="padding:16px;vertical-align:top">
                                                <span style="display:inline-block;background:linear-gradient(122deg,#c26af5,#54f0ff);color:#fff;font-size:10px;font-weight:700;padding:2px 8px;border-radius:4px;margin-right:6px;text-transform:uppercase">{{ $address->label }}</span>
                                                {{ $address->address_line }}
                                                @if($address->landmark)<div style="font-size:12px;color:#9ca3af;margin-top:2px">Landmark: {{ $address->landmark }}</div>@endif
                                                <div style="font-size:12px;color:#9ca3af;margin-top:2px">{{ collect([$address->province, $address->city, $address->zone])->filter()->implode(' - ') }}</div>
                                            </td>
                                            <td style="padding:16px;vertical-align:top;color:#666">{{ $address->postal_code ?: '—' }}</td>
                                            <td style="padding:16px;vertical-align:top;color:#666">{{ $address->phone }}</td>
                                            <td style="padding:16px;vertical-align:top;font-size:13px">
                                                @if($address->is_default_shipping)<div style="color:#7c3aed">Default Shipping Address</div>@endif
                                                @if($address->is_default_billing)<div style="color:#7c3aed">Default Billing Address</div>@endif
                                                @if(!$address->is_default_shipping)
                                                    <form method="post" action="{{ route('account.address-book.default-shipping', $address) }}" style="display:inline">
                                                        @csrf
                                                        <button type="submit" style="border:none;background:none;padding:0;color:#666;font-size:12px;text-decoration:underline;cursor:pointer">Make default shipping</button>
                                                    </form><br>
                                                @endif
                                                @if(!$address->is_default_billing)
                                                    <form method="post" action="{{ route('account.address-book.default-billing', $address) }}" style="display:inline">
                                                        @csrf
                                                        <button type="submit" style="border:none;background:none;padding:0;color:#666;font-size:12px;text-decoration:underline;cursor:pointer">Make default billing</button>
                                                    </form>
                                                @endif
                                            </td>
                                            <td style="padding:16px;vertical-align:top;white-space:nowrap">
                                                <button type="button" data-toggle="modal" data-target="#editAddressModal{{ $address->id }}" style="border:none;background:none;color:#7c3aed;font-size:13px;font-weight:600;cursor:pointer">EDIT</button>
                                                <form method="post" action="{{ route('account.address-book.destroy', $address) }}" style="display:inline" onsubmit="return confirm('Remove this address?')">
                                                    @csrf
                                                    <button type="submit" style="border:none;background:none;color:#e11d48;font-size:13px;font-weight:600;cursor:pointer;margin-left:10px">REMOVE</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div style="text-align:center;padding:50px 20px;color:#9ca3af">
                                <p>You haven't saved any addresses yet.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Add address modal --}}
                <div class="modal fade" id="addAddressModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document" style="max-width:480px;margin:30px auto">
                        <div class="modal-content" style="border-radius:10px;border:none">
                            <div class="modal-body" style="padding:30px">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute;top:14px;right:18px;background:none;border:none;font-size:24px;line-height:1;color:#9ca3af">&times;</button>
                                <h3 style="margin:0 0 20px;font-size:18px;font-weight:700">Add New Address</h3>
                                @include('layouts.partials.address_form_fields', ['action' => route('account.address-book.store'), 'address' => null])
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Edit address modals --}}
                @foreach($addresses as $address)
                <div class="modal fade" id="editAddressModal{{ $address->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document" style="max-width:480px;margin:30px auto">
                        <div class="modal-content" style="border-radius:10px;border:none">
                            <div class="modal-body" style="padding:30px">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute;top:14px;right:18px;background:none;border:none;font-size:24px;line-height:1;color:#9ca3af">&times;</button>
                                <h3 style="margin:0 0 20px;font-size:18px;font-weight:700">Edit Address</h3>
                                @include('layouts.partials.address_form_fields', ['action' => route('account.address-book.update', $address), 'address' => $address])
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
@include('layouts.partials.ecategory')
@endsection
