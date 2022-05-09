{{-- <a id="send-btn" data-receiver="{{ $forms[$visitor->form_id]['Nombre completo'] }}" data-bs-toggle="modal"data-bs-target="#send"><i class="bi bi-envelope btn btn-outline-success"></i></a> --}}
{{-- <a id="delete-btn" data-id="{{ $visitor->id }}"><i class="bi bi-trash btn btn-outline-danger"></i></a> --}}
<div class="modal fade" wire:ignore.self id="send" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editLabel">Enviar correo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
            <div class="mb-3">
              <label for="title" class="form-label">Destinatario</label>
              <input type="text" wire:model="email.receiver" id="receiver" class="form-control" aria-describedBy="receiverHelp">
              <div id="passwordHelpBlock" class="form-text">
                En caso de enviar a todos los contactos escribe "todos" en el campo
              </div>
            </div>
            <div class="mb-3">
              <label for="title" class="form-label">Asunto</label>
              <input type="text" wire:model="email.subject" id="title" class="form-control">
            </div>
            <div class="mb-3">
              <label for="date" class="form-label">Contenido</label>
              <textarea wire:model="email.content" rows="3" class="form-control"></textarea>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i></button>
        <button wire:click="sendEmail" class="btn btn-success"><i class="bi bi-send"></i> ENVIAR</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).on("click", "#send-btn", function () {
      // $('#receiver').val($(this).data('receiver'));
      // @this.set('email.subject', 'asdfajsk');
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
