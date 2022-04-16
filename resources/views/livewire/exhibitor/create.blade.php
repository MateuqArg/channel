<a data-bs-toggle="modal" data-bs-target="#create" class="btn btn-success btn-create" href=""><i class="bi bi-plus-lg"></i></a>

<div class="modal fade" id="create" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createLabel">Dar de alta expositor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          @if(Session::has('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              <p class="mb-0"><i class="bi bi-check-circle-fill"></i> {{ Session::get('success') }}</p>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif
        <form method="GET" action="{{ route('organizer.exhibitor.create') }}">
          @csrf

          <div class="mb-3">
            <label for="select" class="form-label">Selecciona el evento en caso de añadir</label>
            <br>
            <input id="events" type='text' placeholder='Escribe el nombre' multiple='multiple' class='flexdatalist' name='events[]'>
            <div id="eventsHelp" class="form-text">Se puede dejar en blanco para darle a un usuario el rol de expositor</div>
            <br>
            <label for="select" class="form-label">Ahora selecciona el usuario</label>
            <br>
            <input id="exhibitors" type='text' placeholder='Escribe el nombre' multiple='multiple' class='flexdatalist' name='exhibitors[]'>
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

  $('#exhibitors').flexdatalist({
    data: exhibitors,
    searchIn: ["name"],
    minLength: 0,
    valueProperty: 'id',
    // visibleProperties: ["name","custid","email"],
    searchByWord: true,
    noResultsText: 'No hay resultados',
  });
</script>