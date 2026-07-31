@extends('install.layout', ['step' => 2])

@section('title', 'Site & Database Details')

@section('content')
    <h1>Site & Database Details</h1>
    <p class="lead">Enter your database connection and create your admin account. The database must already exist — create it first if it doesn't.</p>

    <form method="POST" action="{{ route('install.postDetails') }}">
        @csrf

        <div class="section-title">Site</div>
        <div class="field">
            <label>Site Name</label>
            <input type="text" name="site_name" value="{{ old('site_name', $old['site_name']) }}" required>
        </div>
        <div class="field">
            <label>Site URL</label>
            <input type="url" name="app_url" value="{{ old('app_url', $old['app_url']) }}" required>
            <small>The full URL this site will be reached at, e.g. https://yourdomain.com</small>
        </div>

        <div class="section-title">Database</div>
        <div class="row2">
            <div class="field">
                <label>Database Host</label>
                <input type="text" name="db_host" value="{{ old('db_host', $old['db_host']) }}" required>
            </div>
            <div class="field">
                <label>Database Port</label>
                <input type="text" name="db_port" value="{{ old('db_port', $old['db_port']) }}" required>
            </div>
        </div>
        <div class="field">
            <label>Database Name</label>
            <input type="text" name="db_database" value="{{ old('db_database', $old['db_database']) }}" required>
        </div>
        <div class="row2">
            <div class="field">
                <label>Database Username</label>
                <input type="text" name="db_username" value="{{ old('db_username', $old['db_username']) }}" required>
            </div>
            <div class="field">
                <label>Database Password</label>
                <input type="password" name="db_password" value="">
            </div>
        </div>

        <div class="section-title">Admin Account</div>
        <div class="field">
            <label>Your Name</label>
            <input type="text" name="admin_name" value="{{ old('admin_name') }}" required>
        </div>
        <div class="row2">
            <div class="field">
                <label>Admin Email</label>
                <input type="email" name="admin_email" value="{{ old('admin_email', $old['admin_email']) }}" required>
            </div>
            <div class="field">
                <label>Admin Password</label>
                <input type="password" name="admin_password" minlength="8" required>
                <small>At least 8 characters</small>
            </div>
        </div>

        <div class="alert alert-info">
            This will create the database tables and load the full product catalog, categories and blog content. Any existing data in this database will be replaced.
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">Install →</button>
        </div>
    </form>
@endsection
