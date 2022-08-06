<a data-bs-toggle="modal" data-bs-target="#create" class="btn btn-success btn-create" id="create-btn"><i class="bi bi-plus-lg"></i></a>

<div class="modal fade" wire:ignore.self id="create" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createLabel">Agregar asistentes al grupo</h5>
      </div>
      <div class="modal-body">
          <div class="mb-3">
              <div class="mb-3" wire:ignore>
                <label for="event" class="form-label">Selecciona el evento relacionado al grupo</label>
                <select class="form-control" id="visitors" multiple="multiple">
                  @foreach($allvisitors as $visitor)
                  <option value="{{ $visitor->id }}">{{ $visitor->name }}</option>
                  @endforeach
                </select>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i></button>
        <button id="add" class="btn btn-success"><i class="bi bi-send"></i> ENVIAR</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#visitors').select2({theme: 'bootstrap-5', dropdownParent: $('#create')});
  });
  $('#add').on('click', function (e) {
        var data = $('#visitors').select2("val");
        window.Livewire.emit('addVisitors', data)
        // @this.set('visitor', data);
    });
</script>