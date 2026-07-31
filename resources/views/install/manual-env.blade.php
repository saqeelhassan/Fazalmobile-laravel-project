@extends('install.layout', ['step' => 3])

@section('title', 'Manual Setup Required')

@section('content')
    <h1>One Extra Step</h1>
    <p class="lead">Your server won't let us write the <code>.env</code> file automatically. Copy the text below, replace the contents of the <code>.env</code> file in your project root with it, save, then click continue.</p>

    <textarea class="env-box" readonly onclick="this.select()">{{ $envContents }}</textarea>

    <form method="POST" action="{{ route('install.installAlternate') }}" style="margin-top:20px">
        @csrf
        <input type="hidden" name="confirm_manual_env" value="1">
        <div class="alert alert-info">
            Make sure you've saved the file above as <code>.env</code> before continuing. This will create the database tables and load the product catalog.
        </div>
        <div class="actions">
            <button type="submit" class="btn btn-primary">I've updated .env — Continue →</button>
        </div>
    </form>
@endsection
