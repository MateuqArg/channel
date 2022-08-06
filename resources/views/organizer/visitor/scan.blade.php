@extends('includes.app')
@section('content')
@include('includes.auth.organizernavbar')
<div class="container">
  <div class="row mt-4">
    <div class="col-4"></div>
    <div class="col-3 align-self-center">
      <p>La impresión de la credencial debería haber sido enviada automáticamente, en caso de no ser así podés reintentar el proceso con el siguiente botón <a href="{{ route('organizer.visitor.print', ['custid' => $visitor->custid]) }}">IMPRIMIR</a></p>
      <h4>Verificar datos personales</h4>
      <p>Nombre: {{ $visitor->name }} <br>
          Empresa: {{ $visitor->company }}<br>
          Cargo: {{ $visitor->charge }}<br>
          @if($visitor->vip == true)
          <h3 class="alert alert-success"><i class="bi bi-award"></i> Este usuario es VIP</h3>
          @endif
      </p>
      <img class="w-100" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(300)->generate(route('organizer.visitor.track', ['custid' => $visitor->custid]))) !!} ">
    </div>
    <div class="col-4"></div>
  </div>
</div>

{{-- <a class="btn btn-success btn-create" href="{{  }}"><i class="bi bi-qr-code"></i></a> --}}

{{-- @include('includes.footer') --}}
@endsection