<a id="edit-btn" data-bs-toggle="modal" data-bs-target="#edit{{ $visitor->id }}" data-visitor="{{ $visitor }}"><i class="bi bi-award btn btn-outline-primary"></i></a>
{{-- <a id="delete-btn" data-id="{{ $visitor->id }}" ><i class="bi bi-trash btn btn-outline-danger"></i></a> --}}
<div class="modal fade" wire:ignore.self id="edit{{ $visitor->id }}" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editLabel">Editar de asistente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
            {{-- <div class="mb-3">
              <label for="company" class="form-label">Empresa</label>
              <input type="text" wire:model.defer="company" id="company" class="form-control" aria-describedby="companyHelp">
            </div>
            <div class="mb-3">
              <label for="charge" class="form-label">Cargo</label>
              <input type="text" wire:model.defer="charge" id="charge" class="form-control" aria-describedby="chargeHelp">
            </div>
            <div class="mb-3">
              <label for="country" class="form-label">País</label>
              <input type="text" wire:model.defer="country" id="country" class="form-control" aria-describedby="countryHelp">
            </div>
            <div class="mb-3">
              <label for="state" class="form-label">Provincia</label>
              <input type="text" wire:model.defer="state" id="state" class="form-control" aria-describedby="stateHelp">
            </div>
            <div class="mb-3">
              <label for="city" class="form-label">Ciudad</label>
              <input type="text" wire:model.defer="city" id="city" class="form-control" aria-describedby="cityHelp">
            </div> --}}
            <div class="mb-3 form-check">
              <label class="form-check-label" for="vip">¿Este asistente es de tipo VIP?</label>
              <input class="form-check-input" type="checkbox" wire:model.defer="vip" id="vip" aria-describedby="vipHelp">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i></button>
        <button wire:click="update({{ $visitor->id }})" class="btn btn-success"><i class="bi bi-send"></i> ENVIAR</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).on("click", "#edit-btn", function () {
      var visitor = $(this).data('visitor');
      // $(".modal-body #company").val(visitor.company);
      // $(".modal-body #charge").val(visitor.charge);
      // $(".modal-body #country").val(visitor.country);
      // $(".modal-body #state").val(visitor.state);
      // $(".modal-body #city").val(visitor.city);
      if (visitor.vip == 1) {
          $(".modal-body #vip").prop("checked", true);
      } else if (visitor.vip == 0) {
          $(".modal-body #vip").prop("checked", false);
      }
  });
</script>
<script>
  window.livewire.on('alert', function(){
    $('#edit{{ $visitor->id }}').modal('hide');
    Swal.fire(
      '¡Eliminado!',
      'El asistente ha sido modificado',
      'success'
    )
  })

  $(document).on("click", "#delete-btn", function () {
    Swal.fire({
      title: '¿Estás seguro?',
      text: "¡No podras revertir esta acción!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, ¡eliminarlo!',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        window.Livewire.emit('destroy', {{ $visitor->id }})
        Swal.fire(
          '¡Eliminado!',
          'El asistente ha sido eliminado',
          'success'
        )
      }
    })
  });
</script>
