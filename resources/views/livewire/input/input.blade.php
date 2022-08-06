<div class="container-fluid">
  <div class="row">
    <div class="col d-flex gradient top-table pb-2">
      <div>
        <a href="{{ route('organizer.events.index') }}"><i class="bi bi-arrow-left btn btn-outline-light"></i></a>
        <span class="ms-2">Viendo: {{ $this->event->title }}</span>
      </div>
      <div class="ms-auto">
        @include('livewire.input.create')
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
          <th scope="col">Tipo</th>
          <th scope="col">Nombre</th>
          <th scope="col">Etiqueta</th>
          <th scope="col">Opciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($event->inputs as $input)
        <tr>
          @if(!\Auth::user()->hasRole('staff'))
          <td>
            @include('livewire.input.actions', ['input' => $input])
          </td>
          @endif
          <td>{{ $input->id }}</td>
          <td>{{ $input->type }}</td>
          <td>{{ $input->name }}</td>
          <td>{{ $input->label }}</td>
          <td>{{ $input->options }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>