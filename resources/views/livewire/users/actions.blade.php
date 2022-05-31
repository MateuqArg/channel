<a id="edit-btn" data-bs-toggle="modal" data-id="{{ $user->id }}" data-bs-target="#edit{{ $user->id }}"><i class="bi bi-pencil btn btn-outline-warning"></i></a>
<a id="delete-btn" data-id="{{ $user->id }}"><i class="bi bi-trash btn btn-outline-danger"></i></a>
<div class="modal fade" wire:ignore.self id="edit{{ $user->id }}" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
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
              <input type="text" wire:model="user.name" id="title" class="form-control">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" wire:model="user.email" id="email" class="form-control">
            </div>
            <div class="mb-3">
              <label for="avatar" class="form-label">Avatar</label>
              <input type="file" wire:model="file" id="avatar" class="form-control">
            </div>
            <div class="mb-3" wire:ignore>
              <p>Roles</p>
              <select class="form-control" wire:model="user.role" id="roles{{ $user->id }}" multiple="multiple">
                @foreach($roles as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i></button>
        <button wire:click="update({{ $user->id }})" class="btn btn-success"><i class="bi bi-send"></i> ENVIAR</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(function () {
    $('#roles{{ $user->id }}').select2({theme: 'bootstrap-5', dropdownParent: $('#edit{{ $user->id }}')});
  });

  $('#roles{{ $user->id }}').on('change', function (e) {
        var data = $('#roles{{ $user->id }}').select2("val");
        @this.set('user.role', data);
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
