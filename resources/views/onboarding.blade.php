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
                    <h1 v-if="loading">Loading User...</h1>
                    <new-user v-if="type == 'none'"></new-user>
                    <banker-profile v-else-if="type == 'banker'"></banker-profile>
                    <account-holder-profile v-else-if="type == 'account_holder'"></account-holder-profile>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
