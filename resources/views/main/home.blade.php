@extends('includes.appindex')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless/borderless.css">
<img src="{{ asset('images/tramainicio.png') }}" style="position: absolute; bottom: 0px; height: 70%;">
<div class="container d-block d-sm-none">
  <div class="row">
    <div class="col d-flex">
      <img src="{{ asset('images/logow.png') }}" class="header mx-auto mt-4">
    </div>
  </div>
  <div class="row">
    <div class="col d-flex">
      <img src="{{ asset('images/act.png') }}" class="header mx-auto">
    </div>
  </div>
  <div style="margin-top: calc(100% - 20rem);">
      <div class="row">
        <div class="col mx-4 my-2">
          <h4 class="text-light">Te invitamos a ser parte <i class="bi bi-chevron-down"></i>
          </h4>
        </div>
      </div>
      <div class="row p-2" style="position: relative;">
        <a href="{{ route('login') }}" class="col rounded-3 shadow-sm btn-shadow btn-gradient text-decoration-none text-center p-2 m-1">
            <img src="{{ asset('images/candado.png') }}" style="width: 80%;">
            <p class="text-light mb-0">Login</p>
        </a>
        <a href="https://mediaware.org/channeltalks" class="col rounded-3 shadow-sm btn-shadow bg-light text-decoration-none text-center p-2 m-1">
          <img src="{{ asset('images/calendar.png') }}" style="width: 80%;">
          <p class="text-dark mb-0">Eventos</p>
        </a>
        <a href="https://mediaware.org/channeltalks/agenda" class="col rounded-3 shadow-sm btn-shadow bg-light text-decoration-none text-center p-2 m-1">
          <img src="{{ asset('images/burbuja.png') }}" style="width: 80%;">
          <p class="text-dark mb-0">Charlas</p>
        </a>
      </div>
      <div class="row m-auto mt-4" style="position: relative;">
        <div class="col d-flex">
          <a href="https://www.enfasys.net/channeltalks/galeria-de-fotos-2022" class="shadow-lg mx-auto btn btn-gallery text-light" style="box-shadow: 0 0.5rem 1rem rgb(0 0 0 / 20%) !important;">
            Galeria de fotos <img src="{{ asset('images/camara.png') }}" class="ms-2" style="width: 40px">
          </a>
        </div>
      </div>
  </div>
</div>
<div class="container index-container d-none d-sm-block">
  <div class="row">
    <div class="col">
      <img src="{{ asset('images/logow.png') }}" class="header">
    </div>
  </div>
  <div class="row">
    <div class="col">
      <img src="{{ asset('images/act.png') }}" class="header">
    </div>
  </div>
  <div class="row justify-content-end" style="position: absolute; bottom: 20px; right: 70px;">
    <div class="col-md-4 p-0">
      <div class="row">
        <div class="col mx-4 my-2">
          <h4 class="text-light">Te invitamos a ser parte <i class="bi bi-chevron-down"></i>
          </h4>
        </div>
      </div>
      <div class="row p-2">
        <a href="{{ route('login') }}" class="col rounded-3 shadow-sm btn-shadow btn-gradient text-decoration-none text-center p-2 m-1">
            <img src="{{ asset('images/candado.png') }}" style="width: 80%;">
            <p class="text-light mb-0">Login</p>
        </a>
        <a href="https://mediaware.org/channeltalks" class="col rounded-3 shadow-sm btn-shadow bg-light text-decoration-none text-center p-2 m-1">
          <img src="{{ asset('images/calendar.png') }}" style="width: 80%;">
          <p class="text-dark mb-0">Eventos</p>
        </a>
        <a href="https://mediaware.org/channeltalks/agenda" class="col rounded-3 shadow-sm btn-shadow bg-light text-decoration-none text-center p-2 m-1">
          <img src="{{ asset('images/burbuja.png') }}" style="width: 80%;">
          <p class="text-dark mb-0">Charlas</p>
        </a>
      </div>
      <div class="row m-auto mt-4">
        <div class="col d-flex">
          <a href="https://www.enfasys.net/channeltalks/galeria-de-fotos-2022" class="shadow-lg mx-auto btn btn-gallery text-light" style="box-shadow: 0 0.5rem 1rem rgb(0 0 0 / 20%) !important;">
            Galeria de fotos <img src="{{ asset('images/camara.png') }}" class="ms-2" style="width: 40px">
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- @include('includes.footer') --}}
@endsection