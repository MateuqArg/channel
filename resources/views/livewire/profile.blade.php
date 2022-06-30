<div class="modal avatar-card" wire:init="autoload">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Perfil</h5>
      </div>
      <div class="modal-body">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <p class="mb-0"><i class="bi bi-check-circle-fill"></i> {{ Session::get('success') }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="name" class="form-control" id="name" wire:model="name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" wire:model="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" wire:model="password">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Teléfono</label>
                <input type="number" class="form-control" id="phone" wire:model="phone">
            </div>
            @if ($avatar)
                <img class="w-100" src="{{ $avatar->temporaryUrl() }}" alt="">
            @else
                <img class="avatar rounded-circle w-100" src="{{ asset('avatars/'.$user->avatar) }}">
            @endif
            <div class="mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                <input type="file" class="form-control" id="avatar" wire:model="avatar">
            </div>
      </div>
      <div class="modal-footer">
        <button wire:click="update" class="btn btn-success"><i class="bi bi-save"></i> GUARDAR</button>
      </div>
    </div>
  </div>
</div>