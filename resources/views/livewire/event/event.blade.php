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
          <th scope="col">ID público</th>
          <th scope="col">Nombre</th>
          <th scope="col">Fecha</th>
          <th scope="col">Datos</th>
          <th scope="col">¿Aprobar inscripciones?</th>
        </tr>
      </thead>
      <tbody>
        @foreach($events as $event)
        <tr>
          <td>
            @include('livewire.event.actions', ['event' => $event])
          </td>
          <td>{{ $event->id }}</td>
          <td>{{ $event->custid }}</td>
          <td>{{ $event->title }}</td>
          <td>{{ $event->date }}</td>
          <td>
              @foreach(explode('*', $event->inscription) as $data)
              {{ $data == "phone" ? "Teléfono" : ($data == "company" ? "Empresa" : ($data == "charge" ? "Cargo" : ($data == "country" ? "País" : ($data == "state" ? "Provincia" : ($data == "city" ? "Ciudad" : ""))))) }}
              @endforeach
          </td>
          <td>{{ $event->approve ? "Si" : "No" }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  @include('livewire.event.create')

  <script>
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