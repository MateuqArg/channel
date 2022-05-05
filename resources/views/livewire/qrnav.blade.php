<div>
<div class="col-12 col-lg-auto ms-3 mb-lg-0 me-lg-3">
    <a id="qr-btn" data-bs-toggle="modal" data-bs-target="#qr"><i class="bi bi-qr-code-scan btn btn-outline-success"></i></a>
</div>

<div class="modal fade" wire:ignore.self id="qr" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editLabel">Cambiar de grupo a escanear</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <p>Ahora se está editando la sesión: {{ session('talk') }}</p>
          <div class="mb-3" wire:ignore>
              <label for="talks" class="form-label">Seleccionar entre la lista de grupos</label>
              <select class="form-control" wire:model="talk" id="talk">
                @foreach($talks as $talk)
                <option value="{{ $talk->id }}">{{ $talk->title }}</option>
                @endforeach
              </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i></button>
        <button wire:click="changeTrack" class="btn btn-success"><i class="bi bi-send"></i> ENVIAR</button>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function() {
        $('#talk').select2({theme: 'bootstrap-5'});
        // window.Livewire.emit('selected')
    });

    $('#talk').on('change', function (e) {
        var data = $('#talk').select2("val");
        @this.set('talk', data);
    });
</script>
</div>