<a data-bs-toggle="modal" data-bs-target="#create" class="btn btn-success btn-create" href=""><i class="bi bi-plus-lg"></i></a>

<div class="modal fade" wire:ignore.self id="create" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createLabel">Dar de alta expositor</h5>
        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
      </div>
      <div class="modal-body">
          <div class="mb-3">
            <div class="mb-3" wire:ignore>
                <label for="event" class="form-label">Selecciona el/los usuario/s que será expositor</label>
                <select class="form-control" id="users" multiple="multiple">
                  @foreach($users as $user)
                  <option value="{{ $user->id }}">{{ $user->name }}</option>
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
    $('#users').select2({theme: 'bootstrap-5', dropdownParent: $('#create')});
  });
  $('#users').on('change', function (e) {
        var data = $('#users').select2("val");
        @this.set('user.id', data);
    });
</script>