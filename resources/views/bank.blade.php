@extends('layouts.app')

@section('content')
        
        <!-- <div v-if="loading" class="page-loader-container"><div class="loader"></div></div> -->
        <router-view></router-view>
        <add-transaction-btn></add-transaction-btn>

@endsection

@section('modals')

<category-modal></category-modal>
<transaction-modal></transaction-modal>
<account-modal></account-modal>
<interest-modal></interest-modal>

@endsection
