<a data-bs-toggle="modal" data-bs-target="#create" class="btn btn-success btn-create" style="position: absolute;" id="create-btn"><i class="bi bi-plus-lg"></i></a>

<div class="modal fade" wire:ignore.self id="create" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createLabel">Dar de alta grupo</h5>
      </div>
      <div class="modal-body">
          <div class="mb-3">
              <div class="mb-3">
                <label for="title" class="form-label">Titulo</label>
                <br>
                <input type="text" wire:model.defer="cregroup.title" id="title" class="form-control" aria-describedby="titleHelp">
              </div>
              <div class="mb-3" wire:ignore>
                {{-- <label for="event" class="form-label">Selecciona el evento relacionado al grupo</label> --}}
                {{-- <select class="form-control" wire:model="cregroup.visitor" id="visitors" multiple="multiple">
                  @foreach($visitors as $visitor)
                  <option value="{{ $visitor->id }}">{{ $forms[$visitor->form_id]['Nombre completo'] }}</option>
                  @endforeach
                </select> --}}
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
    $('#visitors').select2({theme: 'bootstrap-5', dropdownParent: $('#create')});
  });
  $('#visitors').on('change', function (e) {
        var data = $('#visitors').select2("val");
        @this.set('group.visitor', data);
    });
</script>