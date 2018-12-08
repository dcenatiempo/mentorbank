@extends('layouts.app')

@section('main-script')
<script src="{{ mix('js/portal.js') }}" defer></script>
@endsection

@section('id')
<div id="portal">
@endsection

@section('content')
        
        <!-- <div v-if="loading" class="page-loader-container"><div class="loader"></div></div> -->
        <!-- <router-view></router-view> -->
        <bank-portal></bank-portal>

@endsection

@section('modals')

@endsection
