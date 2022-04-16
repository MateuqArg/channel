<a id="edit-btn" data-bs-toggle="modal" data-bs-target="#edit" data-exhibitor="{{ $exhibitor }}"><i class="bi bi-pencil btn btn-outline-warning"></i></a>
<a id="delete-btn" data-id="{{ $exhibitor->id }}"><i class="bi bi-trash btn btn-outline-danger"></i></a>
<div class="modal fade" wire:ignore.self id="edit" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editLabel">Editar roles</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
          <p>Al destildar el expositor se saldrá de todos los eventos</p>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="exhibitor" id="exhibitor" checked>
            <label class="form-check-label" for="exhibitor">
              Expositor
            </label>
          </div>
          <hr>
          <p>ID público de todos los eventos</p>
          @foreach($roles as $role)
          @if(strlen($role->name) == 6)
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="{{ $role->name }}" wire:model.defer="role" id="{{ $role->name }}" 
            {{ $user->hasRole($role->name) ? "checked" : "" }}>
            <label class="form-check-label" for="{{ $role->name }}">
              {{ $role->name }}
            </label>
          </div>
          @endif
          @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i></button>
        <button wire:click="update({{ $exhibitor->id }})" class="btn btn-success"><i class="bi bi-send"></i> ENVIAR</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).on("click", "#edit-btn", function () {
      var exhibitor = $(this).data('exhibitor');
      $(".modal-body #event").val(exhibitor.event_id);
      $(".modal-body #exhibitor").val(exhibitor.exhibitor_id);
      $(".modal-body #title").val(exhibitor.title);
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
        window.Livewire.emit('destroy', {{ $exhibitor->id }})
        Swal.fire(
          '¡Eliminado!',
          'La charla ha sido eliminada',
          'success'
        )
      }
    })
  });
</script>
