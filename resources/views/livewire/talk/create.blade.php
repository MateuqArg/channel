<a data-bs-toggle="modal" data-bs-target="#create" class="btn btn-success btn-create" id="create-btn"><i class="bi bi-plus-lg"></i></a>

<div class="modal fade" wire:ignore.self id="create" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createLabel">Dar de alta charla</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          @if(Session::has('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              <p class="mb-0"><i class="bi bi-check-circle-fill"></i> {{ Session::get('success') }}</p>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif

          <div class="mb-3">
              <div class="mb-3">
                <label for="title" class="form-label">Titulo</label>
                <br>
                <input type="text" wire:model="talk.title" id="title" class="form-control" aria-describedby="titleHelp">
              </div>
              <div class="mb-3">
                <label for="event" class="form-label">Selecciona el evento relacionado a la charla</label>
                <select wire:model="talk.event" id="event">
                  <option value="">Escribe el nombre</option>
                  @foreach($events as $event)
                  <option value="{{ $event->id }}">{{ $event->title }}</option>
                  @endforeach
                </select>
              </div>
              <div class="mb-3">
                <label for="exhibitor" class="form-label">Ahora selecciona el usuario que será expositor</label>
                <select  wire:model="talk.exhibitor" id="exhibitor">
                  <option value="">Escribe el nombre</option>
                  @foreach($exhibitors as $exhibitor)
                  <option value="{{ $exhibitor->id }}">{{ $exhibitor->name }}</option>
                  @endforeach
                </select>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i></button>
        <button wire:click="create()" class="btn btn-success"><i class="bi bi-send"></i> ENVIAR</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $('#event').select2({placeholder: 'Select an option'});
    $('#exhibitor').select2();
  });

  $(document).on("click", "#create-btn", function () {
      window.Livewire.emit('cleanData')
  });
</script>