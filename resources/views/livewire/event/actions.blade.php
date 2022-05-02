<a id="edit-btn" data-bs-toggle="modal" data-id="{{ $event->id }}" data-bs-target="#edit{{ $event->id }}"><i class="bi bi-pencil btn btn-outline-primary"></i></a>
<a id="delete-btn" data-id="{{ $event->id }}"><i class="bi bi-trash btn btn-outline-danger"></i></a>
<div class="modal fade" wire:ignore.self id="edit{{ $event->id }}" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editLabel">Editar evento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
            <div class="mb-3">
              <label for="title" class="form-label">Nombre</label>
              <input type="text" wire:model="event.title" id="title" class="form-control">
            </div>
            <div class="mb-3">
              <label for="date" class="form-label">Fecha</label>
              <input type="date" wire:model="event.date" id="date" class="form-control">
            </div>
            {{-- <div class="mb-3">
              <label for="inscription" class="form-label">Datos</label>
              <input type="text" wire:model="event.inscription" id="inscription" class="form-control">
            </div> --}}
            {{-- <div class="form-check form-check-inline">
              <input class="form-check-input" wire:model="event.inscription" type="checkbox" id="phone" value="phone">
              <label class="form-check-label" for="phone">Teléfono</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" wire:model="event.inscription" type="checkbox" id="charge" value="charge">
              <label class="form-check-label" for="charge">Cargo</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" wire:model="event.inscription" type="checkbox" id="company" value="company">
              <label class="form-check-label" for="company">Empresa</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" wire:model="event.inscription" type="checkbox" id="country" value="country">
              <label class="form-check-label" for="country">País</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" wire:model="event.inscription" type="checkbox" id="state" value="state">
              <label class="form-check-label" for="state">Provincia</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" wire:model="event.inscription" type="checkbox" id="city" value="city">
              <label class="form-check-label" for="city">Ciudad</label>
            </div> --}}
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" wire:model="event.approve" role="switch" id="approve">
              <label class="form-check-label" for="approve">¿Hace falta aprobar las asistencias?</label>
             </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i></button>
        <button wire:click="update({{ $event->id }})" class="btn btn-success"><i class="bi bi-send"></i> ENVIAR</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).on("click", "#edit-btn", function () {
      window.Livewire.emit('selected', $(this).data('id'))
  });
  
  $(document).on("click", "#delete-btn", function () {
    Swal.fire({
      title: '¿Estás seguro?',
      text: "¡No podras revertir esta acción!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, ¡eliminarla!',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        window.Livewire.emit('destroy', $(this).data('id'))
      }
    })
  });
</script>
