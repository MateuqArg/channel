<a id="edit-btn" data-bs-toggle="modal" data-bs-target="#edit" data-talk="{{ $talk }}"><i class="bi bi-pencil btn btn-outline-warning"></i></a>
<a id="delete-btn" data-id="{{ $talk->id }}"><i class="bi bi-trash btn btn-outline-danger"></i></a>
<div class="modal fade" wire:ignore.self id="edit" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editLabel">Editar charla</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
            <div class="mb-3">
              <label for="event" class="form-label">Evento</label>
              <input type="text" wire:model.defer="event" id="event" class="form-control" aria-describedby="eventHelp">
            </div>
            <div class="mb-3">
              <label for="exhibitor" class="form-label">Expositor</label>
              <input type="text" wire:model.defer="exhibitor" id="exhibitor" class="form-control" aria-describedby="exhibitorHelp">
            </div>
            <div class="mb-3">
              <label for="title" class="form-label">Titulo</label>
              <input type="text" wire:model.defer="title" id="title" class="form-control" aria-describedby="titleHelp">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i></button>
        <button wire:click="update({{ $talk->id }})" class="btn btn-success"><i class="bi bi-send"></i> ENVIAR</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).on("click", "#edit-btn", function () {
      var talk = $(this).data('talk');
      $(".modal-body #event").val(talk.event_id);
      $(".modal-body #exhibitor").val(talk.exhibitor_id);
      $(".modal-body #title").val(talk.title);
  });
</script>
<script>
  window.livewire.on('alert', function(){
    $('#edit').modal('hide');
    Swal.fire(
      '¡Eliminado!',
      'La charla ha sido modificada',
      'success'
    )
  })

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
        window.Livewire.emit('destroy', {{ $talk->id }})
        Swal.fire(
          '¡Eliminado!',
          'La charla ha sido eliminada',
          'success'
        )
      }
    })
  });
</script>
