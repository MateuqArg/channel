@extends('includes.app')
@section('content')
@include('includes.auth.organizernavbar')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless/borderless.css">

@livewire('visitors')

{{-- @include('includes.footer') --}}
@endsection