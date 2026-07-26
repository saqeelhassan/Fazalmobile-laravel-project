@include('layouts.partials.config')
@include('layouts.partials.head')

<body>

<!-- Page Loader -->
<div id="page-loader">
    <div class="loader-inner">
        <div class="loader-logo">
            <img src="{{ asset('img/logo.png') }}" alt="Fazal Mobile">
        </div>
        <div class="loader-spinner">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>
<!-- End Page Loader -->

@include('layouts.partials.pushmenu')

<div class="wrappage">

@include('layouts.partials.header')

@yield('content')

@include('layouts.partials.footer')
