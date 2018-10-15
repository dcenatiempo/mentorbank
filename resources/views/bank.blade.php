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
                    <bank-dashboard v-show="!loading" v-if="bankPage == 'dashboard'"></bank-dashboard>
                    <profile v-show="!loading" v-else-if="bankPage == 'profile'"></profile>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')
<add-transaction-btn></add-transaction-btn>
<category-modal></category-modal>
<transaction-modal></transaction-modal>
<account-modal></account-modal>
@endsection
