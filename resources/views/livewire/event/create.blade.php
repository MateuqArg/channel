<a data-bs-toggle="modal" data-bs-target="#create" class="btn btn-success btn-create" href=""><i class="bi bi-plus-lg"></i></a>

<div class="modal fade" wire:ignore.self id="create" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createLabel">Dar de alta evento</h5>
        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
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
            <label for="spread" class="form-label">Hoja de cálculo</label>
            <input type="text" wire:model="spread" id="spread" class="form-control" aria-describedby="spreadHelp">
            <div id="titleHelp" class="form-text">Ejemplo: 1qCqKCFDEskSdIHq0p7lWwZupleeRG5nBI7on7_uwqmE</div>
          </div>
          {{-- <h4 class="mb-0">Formulario de inscripción</h4>
          <div class="form-text mt-0 mb-2">Selecciona los datos que se pedirán en el formulario</div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" wire:model="inscription" type="checkbox" id="phone" value="phone" >
            <label class="form-check-label" for="phone">Teléfono</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" wire:model="inscription" type="checkbox" id="charge" value="charge">
            <label class="form-check-label" for="charge">Cargo</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" wire:model="inscription" type="checkbox" id="company" value="company">
            <label class="form-check-label" for="company">Empresa</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" wire:model="inscription" type="checkbox" id="country" value="country">
            <label class="form-check-label" for="country">País</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" wire:model="inscription" type="checkbox" id="state" value="state">
            <label class="form-check-label" for="state">Provincia</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" wire:model="inscription" type="checkbox" id="city" value="city">
            <label class="form-check-label" for="city">Ciudad</label>
          </div> --}}
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