<div class="container-fluid">
  <div class="row">
    <div class="col-md-3">
      <input type="text" wire:model="search" class="form-control" placeholder="Buscar por id o eventos">
    </div>
  </div>
  <div class="row g-3">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Acciones</th>
          <th scope="col">ID</th>
          <th scope="col">ID publico</th>
          <th scope="col">Nombre</th>
          <th scope="col">Eventos</th>
        </tr>
      </thead>
      <tbody>
        @foreach($exhibitors as $exhibitor)
        <tr>
          <td>
            @include('livewire.exhibitor.actions', ['exhibitor' => $exhibitor])
          </td>
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

  @include('livewire.exhibitor.create')
</div>