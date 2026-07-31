@extends('install.layout', ['step' => 4])

@section('title', 'Installed')

@section('content')
    <h1>Installation Complete 🎉</h1>
    <p class="lead">The database, product catalog, and your admin account are all set up.</p>

    <div class="alert alert-success">
        You can now log in to the admin panel with the email and password you just set.
    </div>

    <div class="alert alert-info">
        For security, delete <code>routes/install_r.php</code>, the <code>App\Http\Controllers\Install</code> folder, and the <code>resources/views/install</code> folder now that setup is done — or at minimum leave them, they will refuse to run again automatically.
    </div>

    <div class="actions">
        <a href="{{ route('admin.login') }}" class="btn btn-primary">Go to Admin Login →</a>
        <a href="{{ route('home') }}" class="btn btn-outline">View Site</a>
    </div>
@endsection
