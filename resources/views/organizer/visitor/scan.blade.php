@extends('includes.app')
@section('content')
@include('includes.navbar')
<div class="container">
  <div class="row mt-4">
    <div class="col"></div>
    <div class="col align-self-center">
      <p>La impresión de la credencial debería haber sido enviada automáticamente, en caso de no ser así podés reintentar el proceso con el siguiente botón <a href="{{ route('organizer.visitor.print', ['custid' => $visitor->custid]) }}">IMPRIMIR</a></p>
      <h4>Verificar datos personales</h4>
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
      <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(300)->generate(route('organizer.visitor.track', ['custid' => \Auth::user()->custid]))) !!} ">
    </div>
    <div class="col"></div>
  </div>
</div>

{{-- <a class="btn btn-success btn-create" href="{{  }}"><i class="bi bi-qr-code"></i></a> --}}

{{-- @include('includes.footer') --}}
@endsection