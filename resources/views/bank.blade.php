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

                    <h1>Hello {{ Auth::user()->name }}, You are logged in!</h1>
                    <h1 v-if="loading">Loading Bank...</h1>
                    <!-- <new-bank v-if="accounts.accountList.length == 0"></new-bank> -->
                    <bank-dashboard v-else></bank-dashboard>
                </div>
            </div>
        </div>
    </div>
    <example-modal></example-modal>
</div>
@endsection
