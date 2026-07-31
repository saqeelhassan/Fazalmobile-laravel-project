@extends('install.layout', ['step' => 1])

@section('title', 'Welcome')

@section('content')
    <h1>Welcome</h1>
    <p class="lead">This wizard will set up the database, create your admin account, and load the product catalog. It takes about a minute.</p>

    <div class="actions">
        <a href="{{ route('install.checkServer') }}" class="btn btn-primary">Get Started →</a>
    </div>
@endsection
