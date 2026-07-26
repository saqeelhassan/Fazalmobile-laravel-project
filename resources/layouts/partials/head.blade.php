<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>{{ $pageTitle ?? 'E-Come Electronics Store' }}</title>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">

    @foreach($extraCss ?? [] as $css)
    <link rel="stylesheet" href="{{ asset($css) }}">
    @endforeach

    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
</head>
