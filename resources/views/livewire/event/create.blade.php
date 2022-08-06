<a data-bs-toggle="modal" data-bs-target="#create" class="btn btn-success btn-create" href=""><i class="bi bi-plus-lg"></i></a>

<div class="modal fade" wire:ignore.self id="create" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createLabel">Dar de alta evento</h5>
      </div>
      <div class="modal-body">
          <div class="mb-3">
            <label for="title" class="form-label">Titulo</label>
            <input type="text" wire:model="title" id="title" class="form-control" aria-describedby="titleHelp">
          </div>
          <div class="mb-3">
            <label for="date" class="form-label">Fecha</label>
            <input type="date" wire:model="date" id="date" class="form-control" aria-describedby="dateHelp">
            <div id="dateHelp" class="form-text">Día del evento o en su defecto del inicio de tal</div>
          </div>
          <div class="mb-3">
            <label for="date" class="form-label">Recordatorio "Solo faltan 3 días"</label>
            <input type="file" wire:model="tresdias" id="tresdias" class="form-control" aria-describedby="dateHelp">
          </div>
          <div class="mb-3">
            <label for="date" class="form-label">Recordatorio "Solo falta 1 día"</label>
            <input type="file" wire:model="undia" id="undia" class="form-control" aria-describedby="dateHelp">
          </div>
          <div class="mb-3">
            <label for="date" class="form-label">Recordatorio "El evento está por comenzar"</label>
            <input type="file" wire:model="hoy" id="hoy" class="form-control" aria-describedby="dateHelp">
          </div>
          <div class="mb-3">
            <label for="date" class="form-label">Recordatorio "Gracias por asistir"</label>
            <input type="file" wire:model="gracias" id="gracias" class="form-control" aria-describedby="dateHelp">
          </div>
          <div class="mb-3">
            <label for="date" class="form-label">Molde QR de ingreso</label>
            <input type="file" wire:model="registro" id="registro" class="form-control" aria-describedby="dateHelp">
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" wire:model.defer="approve" role="switch" id="approve">
            <label class="form-check-label" for="approve">¿Hace falta aprobar las asistencias?</label>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i></button>
        <button wire:click="create" class="btn btn-success"><i class="bi bi-send"></i> ENVIAR</button>
      </div>
    </div>
  </div>
</div>