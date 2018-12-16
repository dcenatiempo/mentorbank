@extends('layouts.app')

@section('main-script')
<script src="{{ mix('js/subscription.js') }}" defer></script>
@endsection

@section('id')
<div id="subscription">
@endsection

@section('content')

    <router-view :downgrade="{{$downgrade}}"></router-view>

@endsection
