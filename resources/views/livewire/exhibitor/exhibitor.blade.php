<div class="container-fluid">
  <div class="row">
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
          <th scope="col">ID publico</th>
          <th scope="col">Nombre</th>
          <th scope="col">Eventos</th>
        </tr>
      </thead>
      <tbody>
        @foreach($exhibitors as $exhibitor)
        <tr>
          @if(!\Auth::user()->hasRole('staff'))
          <td>
            @include('livewire.exhibitor.actions', ['exhibitor' => $exhibitor])
          </td>
          @endif
          <td>{{ $exhibitor->id }}</td>
          <td>{{ $exhibitor->custid }}</td>
          <td>{{ $exhibitor->name }}</td>
          @foreach($exhibitor->getRoleNames() as $role)
          @if(strlen($role) == 6)
            <td>{{ $role }}</td>
          @endif
          @endforeach
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  @if(!\Auth::user()->hasRole('staff'))
  @include('livewire.exhibitor.create')
  @endif

  <script>
    window.livewire.on('alert', event => {
      $('#edit' + event.id).modal('hide');
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