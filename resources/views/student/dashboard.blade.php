@extends('includes.app')
@section('content')
@include('includes.auth.navbar')
<div class="container-fluid">
    <div class="row justify-content-center">
        <img src="{{ asset('images/banner.png') }}" class="banner">
    </div>
</div>
@include('includes.footer')
@endsection