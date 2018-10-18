@extends('layouts.app')

@section('content')
        
        <h1>Hello, <router-link to="/bank/profile">{{ Auth::user()->name }}</router-link>You are logged in!</h1>
        <h1 v-if="loading">Loading Bank...</h1>
        <router-view></router-view>

@endsection

@section('modals')
<add-transaction-btn></add-transaction-btn>
<category-modal></category-modal>
<transaction-modal></transaction-modal>
<account-modal></account-modal>
@endsection
