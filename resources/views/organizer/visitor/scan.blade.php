@extends('includes.app')
@section('content')
@include('includes.auth.organizernavbar')
<div class="container">
  <div class="row mt-4">
    <div class="col"></div>
    <div class="col align-self-center">
      <p>La impresión de la credencial debería haber sido enviada automáticamente, en caso de no ser así podés reintentar el proceso con el siguiente botón <a href="{{ route('organizer.visitor.print', ['custid' => $visitor->custid]) }}">IMPRIMIR</a></p>
      <h4>Verificar datos personales</h4>
      <p>Nombre: {{ $forms[$visitor->form_id]['Nombre completo'] }} <br>
          Empresa: {{ $forms[$visitor->form_id]['Empresa'] }}<br>
          Cargo: {{ $forms[$visitor->form_id]['Cargo'] }}<br>
          @if($visitor->vip == true)
            *Este usuario es VIP
          @endif
      </p>
      <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(300)->generate(route('organizer.visitor.track', ['custid' => $visitor->custid]))) !!} ">
    </div>
    <div class="col"></div>
  </div>
</div>

{{-- <a class="btn btn-success btn-create" href="{{  }}"><i class="bi bi-qr-code"></i></a> --}}

{{-- @include('includes.footer') --}}
@endsection