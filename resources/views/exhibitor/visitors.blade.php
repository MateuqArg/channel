@extends('includes.app')
@section('content')
@include('includes.auth.exhibitornavbar')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless/borderless.css">

@if(!$meetings->isEmpty())
  <div class="row">
    <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#meetings" href="">
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <p class="mb-0"><i class="bi bi-check-circle-fill"></i> Hay reuniones pendientes de aprobación</p>
    </div>
    </a>
  </div>
 @endif

<div class="modal fade" id="meetings" tabindex="-1" aria-labelledby="meetingsLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="meetingsLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="accordion" id="accordionExample">
          @if(Session::has('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              <p class="mb-0"><i class="bi bi-check-circle-fill"></i> {{ Session::get('success') }}</p>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif
          @foreach($meetings as $meeting)
          <div class="accordion-item">
            <h2 class="accordion-header">
              <div class="row">
                <div class="col-9">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $meeting->custid }}" aria-expanded="true" aria-controls="{{ $meeting->custid }}">
                    {{ $meeting->visitor->name }} - {{ $meeting->event->title }}
                  </button>
                </div>
                <div class="col-1">
                  <a class="btn btn-success" href="{{ route('exhibitor.meeting.accept', ['id' => $meeting->id]) }}"><i class="bi bi-check-lg"></i></a>
                </div>
                <div class="col-1 ms-1">
                  <a class="btn btn-danger" href="{{ route('exhibitor.meeting.reject', ['id' => $meeting->id]) }}"><i class="bi bi-x-lg"></i></a>
                </div>
              </div>
            </h2>
            <div id="{{ $meeting->custid }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <p class="mb-0">
                  <strong>Nombre:</strong> {{ $meeting->visitor->name }}<br>
                  <strong>Email:</strong> {{ $meeting->visitor->email }}<br>
                  <strong>Teléfono:</strong> {{ $meeting->visitor->phone }}<br>
                  <strong>Empresa:</strong> {{ $meeting->visitor->company }}<br>
                  <strong>Cargo:</strong> {{ $meeting->visitor->charge }}<br>
                  <strong>Provincia:</strong> {{ $meeting->visitor->state }}<br>
                  <strong>Ciudad:</strong> {{ $meeting->visitor->city }}
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

@livewire('exhvisitors')

<script>
	@if(Session::has('success'))
	  $(document).ready(function(){
	    $('#meetings').modal('show');
	  });
	@endif
</script>
{{-- @include('includes.footer') --}}
@endsection