@extends('includes.app')
@section('content')
@include('includes.auth.exhibitornavbar')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless/borderless.css">

@livewire('groupshow', ['gid' => $id])

@endsection