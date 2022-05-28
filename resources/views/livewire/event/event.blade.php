<div class="container-fluid">
  <div class="row">
    @if($this->show == false)
    <div class="col d-flex gradient top-table">
      <div>
        <input type="text" wire:model="search" class="form-control" placeholder="Buscar por id o eventos">
      </div>
      <div class="ms-auto">
        <button wire:click="download" class="btn btn-outline-primary download-btn"><i class="bi bi-download"></i> DESCARGAR</button>
      </div>
    </div>
  </div>
  <div class="row g-3">
    <table class="table">
      <thead class="gradient">
        <tr>
          @if(!\Auth::user()->hasRole('staff'))
          <th scope="col">Acciones</th>
          @endif
          <th scope="col">ID</th>
          <th scope="col">ID público</th>
          <th scope="col">Nombre</th>
          <th scope="col">Fecha</th>
          <th scope="col">¿Aprobar inscripciones?</th>
        </tr>
      </thead>
      <tbody>
        @foreach($events as $event)
        <tr>
          @if(!\Auth::user()->hasRole('staff'))
          <td>
            @include('livewire.event.actions', ['event' => $event])
          </td>
          @endif
          <td>{{ $event->id }}</td>
          <td>{{ $event->custid }}</td>
          <td>{{ $event->title }}</td>
          <td>{{ $event->date }}</td>
          <td>{{ $event->approve ? "Si" : "No" }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
      <div class="col d-flex gradient top-table pb-2">
      <div>
        <a id="back-btn"><i class="bi bi-arrow-left btn btn-outline-light"></i></a>
        <span class="ms-2">Viendo: {{ $this->detail->title }}</span>
      </div>
      <div class="ms-auto">
        <a href="" class="btn btn-outline-light"><i class="bi bi-plus-lg"></i></a>
      </div>
    </div>
    @endif
  </div>

  @if($this->show == false)
  @if(!\Auth::user()->hasRole('staff'))
  @include('livewire.event.create')
  @endif
  @endif
  
  {{-- @livewire('chats') --}}

  <script>
    $(document).on("click", "#back-btn", function () {
      window.Livewire.emit('getBack')
    });

    window.livewire.on('alert', event => {
      $('#edit{{ $event->id }}').modal('hide');
      $('#create').modal('hide');
      Swal.fire({
        title: event.title,
        html: event.text,
        icon: event.type,
        timer: 2000,
      })
    })
  </script>
</div>