<a id="edit-btn" data-bs-toggle="modal" data-bs-target="#edit" data-event="{{ $event }}"><i class="bi bi-pencil btn btn-outline-warning"></i></a>
<a id="delete-btn" data-id="{{ $event->id }}"><i class="bi bi-trash btn btn-outline-danger"></i></a>
<div class="modal fade" wire:ignore.self id="edit" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
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
            {{-- <div class="form-check form-check-inline">
              <input class="form-check-input" wire:model="event.inscription.phone" type="checkbox" id="phone">
              <label class="form-check-label" for="phone">Teléfono</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" wire:model="event.inscription.charge" type="checkbox" id="charge">
              <label class="form-check-label" for="charge">Cargo</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" wire:model="event.inscription.charge" type="checkbox" id="company" value="company" checked>
              <label class="form-check-label" for="company">Empresa</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" wire:model="event.charge" type="checkbox" id="country" value="country" checked>
              <label class="form-check-label" for="country">País</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" wire:model.defer="inscription" type="checkbox" id="state" value="state" checked>
              <label class="form-check-label" for="state">Provincia</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" wire:model.defer="inscription" type="checkbox" id="city" value="city" checked>
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
      window.Livewire.emit('selected', {{ $event->id }})

      // var event = $(this).data('event');
      // $(".modal-body #event").val(event.event_id);
      // $(".modal-body #exhibitor").val(event.exhibitor_id);
      // $(".modal-body #title").val(event.title);
  });
</script>
<script>

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
        window.Livewire.emit('destroy', {{ $event->id }})
      }
    })
  });
</script>
