<div class="container-fluid" wire:init="loadVisitors">
    <div class="row">
        <div class="col"><h3 class="m-2">Contactos del {{ $group->title }}</h3></div>
        <div class="col">
            <a class="btn btn-outline-success" style="float: right;" id="send-all-btn" data-bs-toggle="modal" data-bs-target="#send"><i class="bi bi-envelope-plus"></i> Enviar correo</a>
        </div>
    </div>
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
    @if(count($visitors))
      <tbody>
        @foreach($visitors as $visitor)
        <tr>
          @if(!\Auth::user()->hasRole('staff'))
          <td>
            @if($visitor->event->id == substr($this->currentEvent, strrpos($this->currentEvent, ' ') + 1))
            @include('livewire.groups.actions', ['visitor' => $visitor])
            @endif
          </td>
          @endif
          <td>{{ $visitor->id }}</td>
          <td>{{ $visitor->custid }}</td>
          <td>{{ $visitor->event->title }}</td>
          <td>{{ $forms[$visitor->form_id]['Nombre completo'] }}</td>
          <td>{{ $visitor->present ? "Si" : "No" }}</td>
          <td>{{ $forms[$visitor->form_id]['Direccion de email'] }}</td>
          <td>{{ $forms[$visitor->form_id]['Telefono'] }}</td>
          <td>{{ $forms[$visitor->form_id]['Empresa'] }}</td>
          <td>{{ $forms[$visitor->form_id]['Cargo'] }}</td>
          <td>{{ $forms[$visitor->form_id]['Provincia'] }}</td>
          <td>{{ $forms[$visitor->form_id]['Localidad'] }}</td>
        </tr>
        @endforeach
      </tbody>
    @endif
    </table>
    @if($visitors->hasPages())
      {{ $visitors->links() }}
    @endif
  </div>

@include('livewire.groups.add')

<script>
    // $(document).on("click", "#send-all-btn", function () {
    //     // $('#receiver').val('Todos');
    // });
</script>
<script>
    window.livewire.on('alert', event => {
      $('#send').modal('hide');
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