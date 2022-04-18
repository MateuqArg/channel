<div class="container-fluid">
  <div class="row">
    <div class="col-md-3">
      <input type="text" wire:model="search" class="form-control" placeholder="Buscar por id, evento o expositor">
    </div>
  </div>
  <div class="row g-3">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Acciones</th>
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
          <td>
            @include('livewire.talk.actions', ['talk' => $talk])
          </td>
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

  @include('livewire.talk.create')

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