@extends('includes.app')
@section('content')
@include('includes.auth.organizernavbar')
<div class="container-fluid">
  @if(!$visitors->isEmpty())
  <div class="row">
    <a class="notification-alert" data-bs-toggle="modal" data-bs-target="#visitors" class="btn btn-success btn-create" href="">
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <p class="mb-0"><i class="bi bi-check-circle-fill"></i> Hay inscripciones pendientes de aprobación</p>
    </div>
    </a>
  </div>
  @endif
  @if(Session::has('success'))
  <div class="row ps-3 pe-3">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <p class="mb-0"><i class="bi bi-check-circle-fill"></i> {{ Session::get('success') }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
  @endif
  
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
      @foreach($events as $event)
        <div class="col">
          <a class="text-decoration-none" href="">
            <div class="card shadow-sm">
              <div class="classes-card d-flex align-items-center" style="background-color: #949494;">
                  <h3 class="classes-card-text text-center mb-0">{{ $event->title }}</h3>
              </div>

              <div class="card-body">
                <p class="card-text subtitle">ID: {{ $event->custid }}</p>
                <div class="d-flex justify-content-between align-items-center">
                  <small class="text-muted">Fecha: {{ $event->date }}</small>
                </div>
              </div>
            </div>
          </a>
      </div>
      @endforeach
  </div>
</div>

<a data-bs-toggle="modal" data-bs-target="#create" class="btn btn-success btn-create" href=""><i class="bi bi-plus-lg"></i></a>

<div class="modal fade" id="create" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createLabel">Dar de alta evento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('organizer.events.create') }}">
          @csrf

          <div class="mb-3">
            <label for="title" class="form-label">Titulo</label>
            <input type="text" name="title" id="title" class="form-control" aria-describedby="titleHelp">
            <div id="titleHelp" class="form-text">We'll never share your email with anyone else.</div>
          </div>
          <div class="mb-3">
            <label for="date" class="form-label">Fecha</label>
            <input type="date" name="date" id="date" class="form-control" aria-describedby="dateHelp">
            <div id="dateHelp" class="form-text">Día del evento o en su defecto del inicio de tal</div>
          </div>
          <h4 class="mb-0">Formulario de inscripción</h4>
          <div class="form-text mt-0 mb-2">Selecciona los datos que se pedirán en el formulario</div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" name="inscription[]" type="checkbox" id="name" value="name" checked>
            <label class="form-check-label" for="name">Nombre</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" name="inscription[]" type="checkbox" id="email" value="email" checked>
            <label class="form-check-label" for="email">Email</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" name="inscription[]" type="checkbox" id="phone" value="phone" checked>
            <label class="form-check-label" for="phone">Teléfono</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" name="inscription[]" type="checkbox" id="charge" value="charge" checked>
            <label class="form-check-label" for="charge">Cargo</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" name="inscription[]" type="checkbox" id="company" value="company" checked>
            <label class="form-check-label" for="company">Empresa</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" name="inscription[]" type="checkbox" id="country" value="country" checked>
            <label class="form-check-label" for="country">País</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" name="inscription[]" type="checkbox" id="state" value="state" checked>
            <label class="form-check-label" for="state">Provincia</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" name="inscription[]" type="checkbox" id="city" value="city" checked>
            <label class="form-check-label" for="city">Ciudad</label>
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="approve" role="switch" id="approve" checked>
            <label class="form-check-label" for="approve">¿Hace falta aprobar las asistencias?</label>
           </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i></button>
        <button type="submit" class="btn btn-success"><i class="bi bi-send"></i> ENVIAR</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="visitors" tabindex="-1" aria-labelledby="visitorsLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="visitorsLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="accordion" id="accordionExample">
          @if(Session::has('successvisitors'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              <p class="mb-0"><i class="bi bi-check-circle-fill"></i> {{ Session::get('successvisitors') }}</p>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif
          @foreach($visitors as $visitor)
          <div class="accordion-item">
            <h2 class="accordion-header">
              <div class="row">
                <div class="col-9">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $visitor->custid }}" aria-expanded="true" aria-controls="{{ $visitor->custid }}">
                    {{ $visitor->user->name }} - {{ $visitor->event->title }}
                  </button>
                </div>
                <div class="col-1">
                  <a class="btn btn-success" href="{{ route('organizer.visitor.accept', ['id' => $visitor->id]) }}"><i class="bi bi-check-lg"></i></a>
                </div>
                <div class="col-1 ms-1">
                  <a class="btn btn-danger" href="{{ route('organizer.visitor.reject', ['id' => $visitor->id]) }}"><i class="bi bi-x-lg"></i></a>
                </div>
              </div>
            </h2>
            <div id="{{ $visitor->custid }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <p class="mb-0">
                  <strong>Nombre:</strong> {{ $visitor->user->name }}<br>
                  <strong>Email:</strong> {{ $visitor->user->email }}<br>
                  <strong>Teléfono:</strong> {{ $visitor->user->phone }}<br>
                  <strong>Empresa:</strong> {{ $visitor->company }}<br>
                  <strong>Cargo:</strong> {{ $visitor->charge }}<br>
                  <strong>País:</strong> {{ $visitor->country }}<br>
                  <strong>Provincia:</strong> {{ $visitor->state }}<br>
                  <strong>Ciudad:</strong> {{ $visitor->city }}
                </p>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  @if(Session::has('successvisitors'))
  $(document).ready(function(){
    $('#visitors').modal('show');
  });
  @endif
</script>
{{-- @include('includes.footer') --}}
@endsection