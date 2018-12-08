@extends('layouts.app')

@section('main-script')
<script src="{{ mix('js/account.js') }}" defer></script>
@endsection

@section('id')
<div id="account">
@endsection

@section('content')
        
        <!-- <div v-if="loading" class="page-loader-container"><div class="loader"></div></div> -->
        <account-view :account-id="{{ Session::get('account_id')}}"></account-view>

@endsection

@section('modals')

@endsection
