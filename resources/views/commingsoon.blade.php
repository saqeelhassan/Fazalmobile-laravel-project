@php
    $pageTitle    = 'Coming Soon — Fazal Mobiles';
    $extraScripts = [];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>{{ $pageTitle }}</title>
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
</head>

<body>
<div class="commingsoon">
        <div class="flex">
            <div class="c-width c-left">
                <div class="c-content">
                    <div class="c-logo">
                        <a href="{{ url('/') }}"><img src="{{ asset('img/logo-w.png') }}" alt="" class="img-reponsive"></a>
                    </div>
                    <h3 class="c-title">Our website is under construction</h3>
                    <div class="time-cound">
                        <div class="countdown countdown-time v3" data-countdown="countdown" data-date="08-31-2018-00-00-00">
                        </div>
                    </div>
                    <p>
                        We'll be here soon with our new awesome site, subscribe to be notified.
                    </p>
                    <form class="form_newsletter" action="#" method="post">
                        <input type="email" value="" placeholder="Enter your emaill adress" name="EMAIL" id="mail2" class="newsletter-input form-control">
                        <button id="subscribe2" class="button_mini btn btn-gradient" type="submit">
                            Subscribe
                        </button>
                    </form>
                    <div class="c-social">
                        <a href="#" class="fa fa-twitter"></a>
                        <a href="#" class="fa fa-facebook"></a>
                        <a href="#" class="fa fa-google-plus"></a>
                        <a href="#" class="fa fa-instagram"></a>
                    </div>
                </div>
            </div>
            <div class="c-width c-right">
                <img src="{{ asset('img/cs.jpg') }}" alt="">
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/slick.js') }}"></script>
    <script src="{{ asset('js/countdown.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    @foreach($extraScripts as $script)
    <script src="{{ asset($script) }}"></script>
    @endforeach

</body>
</html>
