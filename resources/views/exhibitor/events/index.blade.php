@extends('includes.app')
@section('content')
@include('includes.auth.exhibitornavbar')
<link href="{{ asset('/css/jquery.flexdatalist.min.css') }}" rel="stylesheet" type="text/css">
<script src="{{ asset('/js/jquery.flexdatalist.min.js') }}"></script>

<div class="container-fluid">
  @if(!$meetings->isEmpty())
  <div class="row">
    <a class="notification-alert" data-bs-toggle="modal" data-bs-target="#meetings" class="btn btn-success btn-create" href="">
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <p class="mb-0"><i class="bi bi-check-circle-fill"></i> Hay reuniones pendientes de aprobación</p>
    </div>
    </a>
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

<a data-bs-toggle="modal" data-bs-target="#request" class="btn btn-success btn-create" href=""><i class="bi bi-plus-lg"></i></a>

<div class="modal fade" id="request" tabindex="-1" aria-labelledby="requestLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="requestLabel">Solicitar reunión</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          @if(Session::has('successrequest'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              <p class="mb-0"><i class="bi bi-check-circle-fill"></i> {{ Session::get('successrequest') }}</p>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif
        <form method="POST" action="{{ route('exhibitor.meeting.request') }}">
          @csrf

          <div class="mb-3">
            <label for="select" class="form-label">Selecciona el evento para la reunión</label>
            <br>
            <input id="events" type='text' placeholder='Escribe el nombre' multiple='multiple' class='flexdatalist' name='events[]'>
            <br>
            <label for="select" class="form-label">Ahora selecciona el visitante</label>
            <br>
            <input id="visitors" type='text' placeholder='Escribe el nombre' multiple='multiple' class='flexdatalist' name='visitors[]'>
            <div id="titleHelp" class="form-text">We'll never share your email with anyone else.</div>
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
                  <strong>Cargo:</strong> {{ $meeting->visitor->charge }}<br>
                  <strong>Empresa:</strong> {{ $meeting->visitor->company }}<br>
                  <strong>País:</strong> {{ $meeting->visitor->country }}<br>
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

<script>
  var visitors = [
    @foreach($visitors as $visitor)
      { id: '{{ $visitor->id }}',
      custid: '{{ $visitor->custid }}',
      event: '{{ $visitor->event->title }}',
      name: '{{ $visitor->user->name }}',
      email: '{{ $visitor->user->email }}',
      },
    @endforeach
  ];

  var events = [
    @foreach($events as $event)
      { id: '{{ $event->id }}',
      custid: '{{ $event->custid }}',
      title: '{{ $event->title }}',
      },
    @endforeach
  ];

  $('#events').flexdatalist({
    data: events,
    searchIn: ["title"],
    minLength: 0,
    valueProperty: 'id',
    // visibleProperties: ["name","custid","email"],
    noResultsText: 'No hay resultados',
  })

  $('#visitors').flexdatalist({
    data: visitors,
    searchIn: ["name","event"],
    minLength: 0,
    valueProperty: 'id',
    // visibleProperties: ["name","custid","email"],
    chainedRelatives: true,
    relatives: '#events',
    searchByWord: true,
    groupBy: 'event',
    noResultsText: 'No hay resultados',
  });

  // var visitors = [
  //   @foreach($visitors as $visitor)
  //     { id: '{{ $visitor->id }}',
  //     custid: '{{ $visitor->custid }}',
  //     event: '{{ $visitor->event->title }}',
  //     name: '{{ $visitor->name }}',
  //     email: '{{ $visitor->email }}',
  //     },
  //   @endforeach
  // ];
  // // $('#events').on('select:flexdatalist', function(event, set, options) {
  // //   console.log($('#events').flexdatalist('value'))  
  // //         @foreach($visitors as $visitor)
  // //         if (set.title == '{{ $visitor->event->title }}') {
  // //           visitors.push({ id: '{{ $visitor->id }}',
  // //           custid: '{{ $visitor->custid }}',
  // //           event: '{{ $visitor->event->title }}',
  // //           event_id: '{{ $visitor->event->id }}',
  // //           name: '{{ $visitor->name }}',
  // //           email: '{{ $visitor->email }}',
  // //           })
  // //         }
  // //         @endforeach
  // // });

  // // $('#events').on('after:flexdatalist.remove', function(event) {
  // //   visitors.forEach(function(visitor, index) {
  // //     if (!($('#events').flexdatalist('value').indexOf(visitor.event_id) > -1)) {
  // //       $('#visitors').flexdatalist('remove', 1)
  // //     }
  // //   });
  // // });
</script>
<script>
  @if(Session::has('success'))
  $(document).ready(function(){
    $('#meetings').modal('show');
  });
  @endif
  @if(Session::has('successrequest'))
  $(document).ready(function(){
    $('#request').modal('show');
  });
  @endif
</script>
{{-- @include('includes.footer') --}}
@endsection