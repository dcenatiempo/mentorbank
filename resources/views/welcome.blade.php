@extends('layouts.guest')

@section('content')
    <div class="content">

        <h1 class="title">
            KidBank
        </h1>

        <h2 class="subtitle">
            Helping parents teach their kids how to manage their money.
        </h2>

        <a v-if="{{ Auth::check() === false ? 'true' : 'false' }}" href="/register" class="btn btn-confirm">Create a Bank</a>
        <a v-else-if="{{ Auth::user()->email_verified_at === null ? 'true' : 'false' }}" href="/email/verify" class="btn btn-confirm">Verify Email</a>
        <a v-else href="/home" class="btn btn-confirm">Enter Bank</a>

    </div>
@endsection
