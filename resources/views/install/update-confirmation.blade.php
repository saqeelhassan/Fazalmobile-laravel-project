@extends('install.layout', ['step' => 4])

@section('title', 'Update')

@section('content')
    <h1>Apply Updates</h1>
    <p class="lead">This runs any new database migrations without touching your existing data or re-seeding the catalog.</p>

    <form method="POST" action="{{ route('install.update') }}">
        @csrf
        <div class="actions">
            <button type="submit" class="btn btn-primary">Run Pending Migrations →</button>
        </div>
    </form>
@endsection
