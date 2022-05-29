<a id="edit-btn" data-bs-toggle="modal" data-id="{{ $email->id }}" data-bs-target="#edit{{ $email->id }}"><i class="bi bi-pencil btn btn-outline-warning"></i></a>
<a id="delete-btn" data-id="{{ $email->id }}"><i class="bi bi-trash btn btn-outline-danger"></i></a>
<div class="modal fade" wire:ignore.self id="edit{{ $email->id }}" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editLabel">Editar email</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
            <div class="mb-3">
              <label for="name" class="form-label">Nombre</label>
              <input type="text" wire:model="email.name" id="name" class="form-control">
            </div>
            <div class="mb-3">
              <label for="subject" class="form-label">Asunto</label>
              <input type="text" wire:model="email.subject" id="subject" class="form-control">
            </div>
            {{-- <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" role="switch" id="type">
              <label class="form-check-label" for="type">¿El contenido es una imagen?</label>
            </div> --}}
            <div class="mb-3" id="img">
              <label for="content" class="form-label">Imagen</label>
              <input type="file" class="form-control" wire:model="file" id="content">
            </div>
            {{-- <div class="mb-3" id="text">
              <label for="contentt" class="form-label">Contenido</label>
              <input type="text" class="form-control" wire:model="email.content" id="contentt">
            </div> --}}
            <div class="mb-3">
              <label for="date" class="form-label">Fecha</label>
              <input type="date" wire:model="email.date" id="date" class="form-control">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i></button>
        <button wire:click="update({{ $email->id }})" class="btn btn-success"><i class="bi bi-send"></i> ENVIAR</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(function () {
    $("#img").hide(this.checked);
  });
  $('#type').click(function() {
    $("#img").toggle(this.checked);
    $("#text").toggle(!this.checked);
  });
</script>
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