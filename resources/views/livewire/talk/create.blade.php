<a data-bs-toggle="modal" data-bs-target="#create" class="btn btn-success btn-create" id="create-btn"><i class="bi bi-plus-lg"></i></a>

<div class="modal fade" wire:ignore.self id="create" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createLabel">Dar de alta grupo</h5>
        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
      </div>
      <div class="modal-body">
          <div class="mb-3">
              <div class="mb-3">
                <label for="title" class="form-label">Titulo</label>
                <br>
                <input type="text" wire:model.defer="cretalk.title" id="title" class="form-control" aria-describedby="titleHelp">
              </div>
              <div class="mb-3" wire:ignore>
                <label for="event" class="form-label">Selecciona el evento relacionado al grupo</label>
                <select class="form-control" wire:model.defer="cretalk.event" id="crevents">
                  @foreach($events as $event)
                  <option value="{{ $event->id }}">{{ $event->title }}</option>
                  @endforeach
                </select>
              </div>
              <div class="mb-3" wire:ignore>
                <label for="exhibitor" class="form-label">Ahora selecciona el usuario que será expositor</label>
                <select class="form-control" wire:model.defer="cretalk.exhibitor" id="crexhibitors">
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

<script>
  $(document).ready(function() {
    $('#crevents').select2({theme: 'bootstrap-5', dropdownParent: $('#create')});
    $('#crexhibitors').select2({theme: 'bootstrap-5', dropdownParent: $('#create')});
    $('#crevents').on('change', function (e) {
        var data = $('#crevents').select2("val");
        @this.set('cretalk.event', data);
    });
    $('#crexhibitors').on('change', function (e) {
        var data = $('#crexhibitors').select2("val");
        @this.set('cretalk.exhibitor', data);
    });
  });
</script>