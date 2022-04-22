@extends('includes.app')
@section('content')
@include('includes.auth.organizernavbar')
<div class="container">
  <div class="row mt-4">
    <div class="col"></div>
    <div class="col align-self-center">
      <form method="GET" action="{{ route('organizer.visitor.store', ['id' => $visitor->id]) }}">
        <div class="mb-3">
          <label for="talks" class="form-label">Seleccionar entre la lista de charlas</label>
          <select class="form-control" name="talk" id="talks">
            @foreach($talks as $talk)
            <option value="{{ $talk->id }}">{{ $talk->title }}</option>
            @endforeach
          </select>
        </div>
        <button class="btn btn-success w-100 mb-3">ENVIAR</button>
      </form>
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

<script>
  $(document).ready(function() {
    $('#talks').select2({theme: 'bootstrap-5'});
  });

  @if(Session::has('alert'))
  $(document).ready(function() {
    Swal.fire({
      title: '¡Genial!',
      html: 'El ingreso ha sido registrado correctamente.',
      icon: 'success',
      timer: 2000,
    })
  });
  @endif
</script>
@endsection