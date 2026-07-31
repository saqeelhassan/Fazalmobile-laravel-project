@extends('install.layout', ['step' => 1])

@section('title', 'Server Check')

@section('content')
    <h1>Server Requirements</h1>
    <p class="lead">We checked your server for everything the app needs to run.</p>

    <ul class="check-list">
        <li>
            <span class="dot {{ $phpOk ? 'ok' : 'fail' }}"></span>
            PHP version {{ PHP_VERSION }} (8.2 or higher required)
        </li>
        @foreach ($extensions as $ext => $ok)
            <li>
                <span class="dot {{ $ok ? 'ok' : 'fail' }}"></span>
                {{ $ext }} extension
            </li>
        @endforeach
        @foreach ($paths as $path => $ok)
            <li>
                <span class="dot {{ $ok ? 'ok' : 'fail' }}"></span>
                <code>{{ $path }}</code> is writable
            </li>
        @endforeach
        <li>
            <span class="dot {{ $envWritable ? 'ok' : 'fail' }}"></span>
            <code>.env</code> is writable
        </li>
    </ul>

    @unless ($allOk)
        <div class="alert alert-error">
            Some requirements failed. You can still continue — if <code>.env</code> isn't writable we'll show you the file to copy manually instead of writing it automatically.
        </div>
    @endunless

    <div class="actions">
        <a href="{{ route('install.details') }}" class="btn btn-primary">Continue →</a>
    </div>
@endsection
