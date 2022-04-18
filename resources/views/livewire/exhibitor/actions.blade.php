<a id="edit-btn" data-bs-toggle="modal" data-id="{{ $exhibitor->id }}" data-bs-target="#edit{{ $exhibitor->id }}"><i class="bi bi-pencil btn btn-outline-warning"></i></a>
<a id="delete-btn" data-id="{{ $exhibitor->id }}"><i class="bi bi-trash btn btn-outline-danger"></i></a>
<div class="modal fade" wire:ignore.self id="edit{{ $exhibitor->id }}" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editLabel">Editar roles</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
          <p>ID público de todos los eventos</p>
          <select class="form-control" wire:model="exhibitor.role" id="role" multiple="multiple">
            @foreach($roles as $role)
            @if(strlen($role->name) == 6)
            <option value="{{ $role->name }}">{{ $role->name }}</option>
            @endif
            @endforeach
          </select>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i></button>
      <button wire:click="update({{ $exhibitor->id }})" class="btn btn-success"><i class="bi bi-send"></i> ENVIAR</button>
    </div>
  </div>
</div>
<script>
  $(function () {
    $('#role').select2();
  });

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