@extends('layouts.app')

@section('main-script')
<script src="{{ mix('js/bank.js') }}" defer></script>
@endsection

@section('id')
<div id="bank">
@endsection

@section('content')
        
        <!-- <div v-if="loading" class="page-loader-container"><div class="loader"></div></div> -->
        <router-view></router-view>
        <add-transaction-btn></add-transaction-btn>

@endsection

@section('modals')

<category-modal></category-modal>
<account-category-modal></account-category-modal>
<transaction-modal></transaction-modal>
<account-modal></account-modal>
<interest-modal></interest-modal>
<profile-modal></profile-modal>

@endsection
