@extends('includes.app')
@section('content')
@include('includes.navbar')
<div class="container">
  <div class="row mt-4">
    <div class="col"></div>
    <div class="col align-self-center">
      <h4>Datos personales</h4>
      <p>Nombre: {{ $visitor->user->name }} <br>
        Email: {{ $visitor->user->email }} <br>
        Teléfono: {{ $visitor->user->phone }} <br>
        @if($visitor->company)
          Empresa: {{ $visitor->company }}<br>
        @endif
        @if($visitor->charge)
          Cargo: {{ $visitor->charge }}<br>
        @endif
        @if($visitor->country)
          País: {{ $visitor->country }}<br>
        @endif
        @if($visitor->state)
          Provincia: {{ $visitor->state }}<br>
        @endif
        @if($visitor->city)
          Ciudad: {{ $visitor->city }}<br>
        @endif
      </p>
    </div>
    <div class="col"></div>
  </div>
</div>

{{-- <a class="btn btn-success btn-create" href="{{  }}"><i class="bi bi-qr-code"></i></a> --}}

{{-- @include('includes.footer') --}}
@endsection