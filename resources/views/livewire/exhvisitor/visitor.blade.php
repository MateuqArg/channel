<div class="container-fluid" wire:init="loadVisitors">
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
        <input type="text" wire:model="search" class="form-control" placeholder="Buscar por id, nombre o empresa">
      </div>
      <div>
        <button id="draw-btn" data-bs-toggle="modal" data-bs-target="#draw" class="btn btn-outline-primary download-btn"><i class="bi bi-dice-5"></i> SORTEAR</button>
      </div>
      <div class="ms-auto">
        <button wire:click="download" class="btn btn-outline-primary download-btn"><i class="bi bi-download"></i> DESCARGAR</button>
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
          <th scope="col">Nombre</th>
          <th scope="col">Empresa</th>
          <th scope="col">Cargo</th>
        </tr>
      </thead>
      <tbody>
        @if(count($visitors))
        @foreach($visitors as $visitor)
        <tr>
          @if(!\Auth::user()->hasRole('staff'))
          <td>
            @if($visitor->event->date > \Carbon\Carbon::now())
            @include('livewire.exhvisitor.actions', ['visitor' => $visitor])
            @endif
          </td>
          @endif
          <td>{{ $visitor->id }}</td>
          <td>{{ $visitor->custid }}</td>
          <td>{{ $visitor->name }}</td>
          <td>{{ $visitor->company }}</td>
          <td>{{ $visitor->charge }}</td>
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
                <input type="number" wire:model="drawcant" id="drawcant" class="form-control">
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
  $('#drawcant').on('change', function (e) {
      window.Livewire.emit('draw')
  });
</script>