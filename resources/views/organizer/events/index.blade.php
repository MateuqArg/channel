@extends('includes.app')
@section('content')
@include('includes.auth.organizernavbar')
<div class="container-fluid">
  <div class="row">
    <a class="notification-alert" data-bs-toggle="modal" data-bs-target="#inscriptions" class="btn btn-success btn-create" href="">
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <p class="mb-0"><i class="bi bi-check-circle-fill"></i> Hay inscripciones pendientes de aprobación</p>
    </div>
    </a>
  </div>
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

<div class="modal fade" id="inscriptions" tabindex="-1" aria-labelledby="inscriptionsLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="inscriptionsLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="accordion" id="accordionExample">
          @foreach($inscriptions as $inscription)
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $inscription->custid }}" aria-expanded="true" aria-controls="{{ $inscription->custid }}">
                {{ $inscription->name }} - {{ $inscription->event->title }}
              </button>
            </h2>
            <div id="{{ $inscription->custid }}" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
{{-- @include('includes.footer') --}}
@endsection