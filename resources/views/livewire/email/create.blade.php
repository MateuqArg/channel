<a data-bs-toggle="modal" data-bs-target="#create" class="btn btn-outline-light"><i class="bi bi-plus-lg"></i></a>

<div class="text-dark modal fade" wire:ignore.self id="create" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createLabel">Dar de alta correo</h5>
      </div>
      <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" wire:model="name" id="name" class="form-control" aria-describedby="nameHelp">
          </div>
          <div class="mb-3">
            <label for="subject" class="form-label">Asunto</label>
            <input type="text" wire:model="subject" id="subject" class="form-control" aria-describedby="subjectHelp">
          </div>
          <div class="mb-3">
            <label for="content" class="form-label">Contenido</label>
            <input type="file" wire:model="content" id="content" class="form-control" aria-describedby="contentHelp">
          </div>
          <div class="mb-3">
            <label for="date" class="form-label">Fecha</label>
            <input type="date" wire:model="date" id="date" class="form-control" aria-describedby="dateHelp">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i></button>
        <button wire:click="create" class="btn btn-success"><i class="bi bi-send"></i> ENVIAR</button>
      </div>
    </div>
  </div>
</div>