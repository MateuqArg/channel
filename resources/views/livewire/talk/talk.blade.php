<div class="container-fluid">
  <div class="row">
    <div class="col d-flex gradient top-table">
      <div>
        <input type="text" wire:model="search" class="form-control" placeholder="Buscar por id, evento o expositor">
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
          <th scope="col">ID publico</th>
          <th scope="col">Evento</th>
          <th scope="col">Expositor</th>
          <th scope="col">Titulo</th>
        </tr>
      </thead>
      <tbody>
        @foreach($talks as $talk)
        <tr>
          @if(!\Auth::user()->hasRole('staff'))
          <td>
            @include('livewire.talk.actions', ['talk' => $talk])
          </td>
          @endif
          <td>{{ $talk->id }}</td>
          <td>{{ $talk->custid }}</td>
          <td>{{ $talk->event->title }}</td>
          <td>{{ $talk->exhibitor->name }}</td>
          <td>{{ $talk->title }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  @if(!\Auth::user()->hasRole('staff'))
  @include('livewire.talk.create')
  @endif
  
  <script>
    window.livewire.on('alert', event => {
      $('#edit{{ $talk->id }}').modal('hide');
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