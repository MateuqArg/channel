@extends('includes.app')
@section('content')
@include('includes.auth.organizernavbar')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless/borderless.css">
<div class="container-fluid">
  @livewire('emails', ['event' => $event])
</div>

  {{-- @livewire('chats') --}}
@endsection