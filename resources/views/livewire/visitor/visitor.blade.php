<div class="container-fluid" wire:init="loadVisitors">
  @if(!$approve->isEmpty())
  <div class="row">
    <a class="notification-alert text-decoration-none" data-bs-toggle="modal" data-bs-target="#approve" class="btn btn-success btn-create" href="">
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <p class="mb-0"><i class="bi bi-check-circle-fill"></i> Haz click para ver las inscripciones pendientes de aprobación</p>
    </div>
    </a>
  </div>
  @endif

<div class="modal fade" id="approve" tabindex="-1" aria-labelledby="visitorsLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="visitorsLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="accordion" id="accordionExample">
          @if(Session::has('successvisitors'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              <p class="mb-0"><i class="bi bi-check-circle-fill"></i> {{ Session::get('successvisitors') }}</p>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif
          @foreach($approve as $visitor)
          <div class="accordion-item">
            <h2 class="accordion-header">
              <div class="row">
                <div class="col-9">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $visitor->custid }}" aria-expanded="true" aria-controls="{{ $visitor->custid }}">
                    {{ $visitor->name }} - {{ $visitor->event->title }}
                  </button>
                </div>
                <div class="col-1">
                  <a class="btn btn-success" href="{{ route('organizer.visitor.accept', ['id' => $visitor->id]) }}"><i class="bi bi-check-lg"></i></a>
                </div>
                <div class="col-1 ms-1">
                  <a class="btn btn-danger" href="{{ route('organizer.visitor.reject', ['id' => $visitor->id]) }}"><i class="bi bi-x-lg"></i></a>
                </div>
              </div>
            </h2>
            <div id="{{ $visitor->custid }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <p class="mb-0">
                  <strong>Nombre:</strong> {{ $visitor->name }}<br>
                  <strong>Email:</strong> {{ $visitor->email }}<br>
                  <strong>Teléfono:</strong> {{ $visitor->phone }}<br>
                  <strong>Empresa:</strong> {{ $visitor->company }}<br>
                  <strong>Cargo:</strong> {{ $visitor->charge }}<br>
                  <strong>Provincia:</strong> {{ $visitor->state }}<br>
                  <strong>Ciudad:</strong> {{ $visitor->city }}
                </p>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

  @if(Session::has('success'))
  <div class="row ps-3 pe-3">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <p class="mb-0"><i class="bi bi-check-circle-fill"></i> {{ Session::get('success') }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
  @endif
  <div class="row">
    <div class="col d-flex gradient top-table">
      <div class="d-flex">
        <select wire:model="cant" class="mx-2 form-select">
          <option value=10>10</option>
          <option value=25>25</option>
          <option value=50>50</option>
          <option value=100>100</option>
        </select>
      </div>
      <div>
        <input type="text" id="search" wire:model="search" class="form-control" placeholder="Buscar por id, nombre o empresa">
      </div>
      <div>
        <button id="draw-btn" data-bs-toggle="modal" data-bs-target="#draw" class="btn btn-outline-primary download-btn"><i class="bi bi-dice-5"></i> SORTEAR</button>
      </div>
      <div class="ms-auto">
        <button wire:click="download" class="btn btn-outline-primary download-btn"><i class="bi bi-download"></i> DESCARGAR</button>
      </div>
      <div class="">
        <select wire:model="downtype" class="mx-1 form-select">
          <option value="all">Todos</option>
          <option value="presents">Presentes: {{ $presents }}</option>
          <option value="vips">VIPs: {{ $vips }}</option>
        </select>
      </div>
      <div class="ms-1">
        <select wire:model="event" id="event" class="mx-2 form-select">
          @foreach($events as $event)
            <option value="{{ $event->id }}">{{ $event->title }}</option>
          @endforeach
        </select>
        {{-- {{ $this->event }} --}}
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
          <th scope="col">Evento</th>
          <th scope="col">Nombre</th>
          <th scope="col">¿Presente?</th>
          <th scope="col">Email</th>
          <th scope="col">Teléfono</th>
          <th scope="col">Empresa</th>
          <th scope="col">Cargo</th>
          <th scope="col">Provincia</th>
          <th scope="col">Ciudad</th>
        </tr>
      </thead>
      <tbody>
        @if(count($visitors))
        @foreach($visitors as $visitor)
        @if($visitor->vip)
        <tr class="table-danger">
        @else
        <tr>
        @endif
          @if(!\Auth::user()->hasRole('staff'))
          <td>
            @if($visitor->event->date > \Carbon\Carbon::now())
            @include('livewire.visitor.actions', ['visitor' => $visitor])
            @endif
          </td>
          @endif
          <td>{{ $visitor->id }}</td>
          <td>{{ $visitor->custid }}</td>
          <td>{{ $visitor->event->title }}</td>
          <td>{{ $visitor->name }}</td>
          <td>{{ $visitor->present ? "Si" : "No" }}</td>
          <td>{{ $visitor->email }}</td>
          <td>{{ $visitor->phone }}</td>
          <td>{{ $visitor->company }}</td>
          <td>{{ $visitor->charge }}</td>
          <td>{{ $visitor->state }}</td>
          <td>{{ $visitor->city }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @if($visitors->hasPages())
      {{ $visitors->links() }}
    @endif
    @endif
  </div>

  <div class="modal fade" wire:ignore.self id="draw" tabindex="-1" aria-labelledby="drawLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="drawLabel">Hacer sorteo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
              <div class="mb-3">
                <label for="drawcant" class="form-label">Cantidad de ganadores</label>
                <input type="number" id="drawcant" class="form-control">
              </div>
              @if($this->drawprices)
              @foreach($this->drawprices as $key => $price)
              Ganador n°{{ $key+1 }} = {{ $price }} <br>
              @endforeach
              @endif
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $('#drawcant').on('keyup', function (e) {
      var code = e.key
      window.Livewire.emit('draw', code)
  });

  $('#search').on('change', function (e) {
      window.Livewire.emit('refresh')
  });
</script>