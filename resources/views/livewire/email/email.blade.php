<div class="container-fluid">
  <div class="row">
    <div class="col d-flex gradient top-table pb-2">
      <div>
        <a href="{{ route('organizer.events.index') }}"><i class="bi bi-arrow-left btn btn-outline-light"></i></a>
        <span class="ms-2">Viendo: {{ $this->event->title }}</span>
      </div>
      <div class="ms-auto">
        @include('livewire.email.create')
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
          <th scope="col">Nombre</th>
          <th scope="col">Asunto</th>
          <th scope="col">Contenido</th>
          <th scope="col">Fecha</th>
          {{-- <th scope="col">Objetivo</th> --}}
          <th scope="col">¿Enviado?</th>
        </tr>
      </thead>
      <tbody>
        @foreach($event->emails as $email)
        <tr>
          @if(!\Auth::user()->hasRole('staff'))
          <td>
            @include('livewire.email.actions', ['email' => $email])
          </td>
          @endif
          <td>{{ $email->id }}</td>
          <td>{{ $email->name }}</td>
          <td>{{ $email->subject }}</td>
          <td><img src="{{ asset('uploads/'.$email->content) }}" style="height: 100px;"></td>
          <td>{{ $email->date }}</td>
          {{-- <td>{{ $email->objective }}</td> --}}
          <td>{{ $email->sended ? "Si" : "No" }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>