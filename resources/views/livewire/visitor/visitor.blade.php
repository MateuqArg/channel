<div class="container-fluid">
  <div class="row">
    <div class="col-md-3">
      <input type="text" wire:model="search" class="form-control" placeholder="Buscar por id, nombre o empresa">
    </div>
  </div>
  <div class="row g-3">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Acciones</th>
          <th scope="col">ID</th>
          <th scope="col">ID público</th>
          <th scope="col">Evento</th>
          <th scope="col">Nombre</th>
          <th scope="col">¿Presente?</th>
          <th scope="col">Empresa</th>
          <th scope="col">Cargo</th>
          <th scope="col">País</th>
          <th scope="col">Provincia</th>
          <th scope="col">Ciudad</th>
        </tr>
      </thead>
      <tbody>
        @foreach($visitors as $visitor)
        <tr>
          <td>
            @include('livewire.visitor.actions', ['visitor' => $visitor])
          </td>
          <td>{{ $visitor->id }}</td>
          <td>{{ $visitor->custid }}</td>
          <td>{{ $visitor->event->title }}</td>
          <td>{{ $visitor->user->name }}</td>
          <td>{{ $visitor->present ? "Si" : "No" }}</td>
          <td>{{ $visitor->company }}</td>
          <td>{{ $visitor->charge }}</td>
          <td>{{ $visitor->country }}</td>
          <td>{{ $visitor->state }}</td>
          <td>{{ $visitor->city }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>