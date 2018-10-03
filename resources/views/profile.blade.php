@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h1>You are logged in!</h1>
                    <p>If no bank is yet created, either make a bank or join a bank</p>
                    <p>If a bank is created, but no accounts, create an account</p>
                    <p>If a bank and 1 account, show account dashboard</p>
                    <p>If a bank and 2+ accounts, show bank dashboard</p>
                </div>
            </div>
        </div>
    </div>
    <example-component></example-component>
</div>
@endsection
