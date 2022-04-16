@extends('includes.app')
@section('content')
@include('includes.auth.organizernavbar')
<link href="{{ asset('/css/jquery.flexdatalist.min.css') }}" rel="stylesheet" type="text/css">
<script src="{{ asset('/js/jquery.flexdatalist.min.js') }}"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless/borderless.css">

@livewire('visitors')

{{-- @include('includes.footer') --}}
@endsection