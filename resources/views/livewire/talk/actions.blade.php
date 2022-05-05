<a id="edit-btn" data-bs-toggle="modal" data-id="{{ $talk->id }}" data-bs-target="#edit{{ $talk->id }}"><i class="bi bi-pencil btn btn-outline-primary"></i></a>
<a id="delete-btn" data-id="{{ $talk->id }}"><i class="bi bi-trash btn btn-outline-danger"></i></a>
<div class="modal fade" wire:ignore.self id="edit{{ $talk->id }}" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editLabel">Editar grupo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3" wire:ignore>
          <label for="events" class="form-label">Selecciona el evento relacionado al grupo</label>
          <select class="form-control" wire:model.defer="talk.event" id="events{{ $talk->id }}">
              @foreach($events as $event)
              <option value="{{ $event->id }}">{{ $event->title }}</option>
              @endforeach
          </select>
        </div>
        <div class="mb-3" wire:ignore>
          <label for="exhibitors" class="form-label">Ahora selecciona el usuario que será expositor</label>
            <select class="form-control" wire:model.defer="talk.exhibitor" id="exhibitors{{ $talk->id }}">
              @foreach($exhibitors as $exhibitor)
              <option value="{{ $exhibitor->id }}">{{ $exhibitor->name }}</option>
              @endforeach
            </select>
        </div>
        <div class="mb-3">
          <label for="title" class="form-label">Titulo</label>
          <input type="text" wire:model="talk.title" id="title" class="form-control" aria-describedby="titleHelp">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i></button>
        <button wire:click="update({{ $talk->id }})" class="btn btn-success"><i class="bi bi-send"></i> ENVIAR</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('#events{{ $talk->id }}').select2({theme: 'bootstrap-5', dropdownParent: $('#edit{{ $talk->id }}')});
    $('#exhibitors{{ $talk->id }}').select2({theme: 'bootstrap-5', dropdownParent: $('#edit{{ $talk->id }}')});
  });

  $('#events{{ $talk->id }}').on('change', function (e) {
        var data = $('#events{{ $talk->id }}').select2("val");
        @this.set('talk.event', data);
  });

  $('#exhibitors{{ $talk->id }}').on('change', function (e) {
        var data = $('#exhibitors{{ $talk->id }}').select2("val");
        @this.set('talk.exhibitor', data);
  });

  $(document).on("click", "#edit-btn", function () {
      window.Livewire.emit('selected', $(this).data('id'))
  });
  
  $(document).on("click", "#delete-btn", function () {
    Swal.fire({
      title: '¿Estás seguro?',
      text: "¡No podras revertir esta acción!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, ¡eliminarla!',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        window.Livewire.emit('destroy', $(this).data('id'))
      }
    })
  });
</script>
