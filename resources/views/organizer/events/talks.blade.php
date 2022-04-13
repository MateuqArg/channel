@extends('includes.app')
@section('content')
@include('includes.auth.organizernavbar')
<link href="{{ asset('/css/jquery.flexdatalist.min.css') }}" rel="stylesheet" type="text/css">
<script src="{{ asset('/js/jquery.flexdatalist.min.js') }}"></script>

<div class="container-fluid">  
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
      @foreach($talks as $talk)
        <div class="col">
          <a class="text-decoration-none" href="">
            <div class="card shadow-sm">
              <div class="classes-card d-flex align-items-center" style="background-color: #949494;">
                  <h3 class="classes-card-text text-center mb-0"></h3>
              </div>

              <div class="card-body">
                <p class="card-text subtitle">ID: {{ $talk->custid }}</p>
                <div class="d-flex justify-content-between align-items-center">
                  <small class="text-muted">Nombre: </small>
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
        <h5 class="modal-title" id="createLabel">Dar de alta charla</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          @if(Session::has('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              <p class="mb-0"><i class="bi bi-check-circle-fill"></i> {{ Session::get('success') }}</p>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif
        <form method="GET" action="{{ route('organizer.talk.create') }}">
          @csrf

          <div class="mb-3">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="new_talk" role="switch" id="new-talk" checked>
              <label class="form-check-label" for="new-talk">¿Crear nueva charla?</label>
            </div>
            <div id="search-talk">
              <label for="select" class="form-label">Selecciona la charla</label>
              <br>
              <input id="talks" type='text' placeholder='Escribe el nombre' multiple='multiple' class='flexdatalist' name='talks[]'>
              <br>
            </div>
            <div id="create-talk">
              <div class="mb-3">
                <label for="title" class="form-label">Titulo</label>
                <input type="text" name="title" id="title" class="form-control" aria-describedby="titleHelp">
              </div>
              <div class="mb-3">
                <label for="event" class="form-label">Selecciona el evento relacionado a la charla</label>
                <input id="events" type="text" placeholder="Escribe el evento" class="flexdatalist" name="event">
              </div>
            </div>
            <label for="select" class="form-label">Ahora selecciona el usuario que será expositor</label>
            <br>
            <input id="exhibitors" type="text" placeholder="Escribe el nombre" class="flexdatalist" name="exhibitor">
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


<script>
  @if(Session::has('success'))
  $(document).ready(function(){
    $('#create').modal('show');
  });
  @endif
</script>
<script>
  $(function () {
    $("#search-talk").hide(this.checked);
  });
  $('#new-talk').click(function() {
      $("#search-talk").toggle(!this.checked);
      $("#create-talk").toggle(this.checked);
  });
</script>
<script>
  var exhibitors = [
    @foreach($exhibitors as $exhibitor)
      { id: '{{ $exhibitor->id }}',
      custid: '{{ $exhibitor->custid }}',
      name: '{{ $exhibitor->name }}',
      email: '{{ $exhibitor->email }}',
      phone: '{{ $exhibitor->phone }}'
      },
    @endforeach
  ];

  var talks = [
    @foreach($talks as $talk)
      { id: '{{ $talk->id }}',
      custid: '{{ $talk->custid }}',
      title: '{{ $talk->title }}',
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

  $('#talks').flexdatalist({
    data: talks,
    searchIn: ["title"],
    minLength: 0,
    valueProperty: 'id',
    noResultsText: 'No hay resultados',
  })

  $('#exhibitors').flexdatalist({
    data: exhibitors,
    searchIn: ["name"],
    minLength: 0,
    valueProperty: 'id',
    searchByWord: true,
    noResultsText: 'No hay resultados',
  });
</script>

{{-- @include('includes.footer') --}}
@endsection