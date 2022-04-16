@extends('includes.app')
@section('content')
@include('includes.auth.organizernavbar')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless/borderless.css">
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

  @livewire('events')
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