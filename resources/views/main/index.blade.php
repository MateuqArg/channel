@extends('includes.app')
@section('content')
@include('includes.navbar')
<div class="container-fluid">
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
      @foreach($events as $event)
        <div class="col">
          <a class="text-decoration-none" href="{{ route('visitor.inscription', ['custid' => $event->custid]) }}">
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

{{-- @include('includes.footer') --}}
@endsection