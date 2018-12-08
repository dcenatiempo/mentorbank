@extends('layouts.app')

@section('main-script')
<script src="{{ mix('js/onboarding.js') }}" defer></script>
@endsection

@section('id')
<div id="onboarding">
@endsection

@section('content')
    <!-- <div v-if="loading" class="page-loader-container"><div class="loader"></div></div> -->
    <router-view></router-view>
@endsection
