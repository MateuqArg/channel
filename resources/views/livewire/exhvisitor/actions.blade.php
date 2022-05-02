<a id="meet-btn{{ $visitor->id }}"><i class="bi bi-people btn btn-outline-primary"></i></a>
<script>
  window.livewire.on('alert', function(){
    $('#edit{{ $visitor->id }}').modal('hide');
    Swal.fire(
      '¡Eliminado!',
      'El asistente ha sido modificado',
      'success'
    )
  })

  $(document).on("click", "#meet-btn{{ $visitor->id }}", function () {
    Swal.fire({
      title: '¿Estás seguro?',
      text: "Solicitaras una reunión con {{ $forms[$visitor->form_id]['Nombre completo'] }}",
      icon: 'info',
      showCancelButton: true,
      cancelButtonColor: '#d33',
      confirmButtonText: 'Confirmar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        window.Livewire.emit('meet', {{ $visitor->id }})
        Swal.fire(
          '¡Solo queda esperar!',
          'La reunión se ha solicitado correctamente',
          'success'
        )
      }
    })
  });
</script>
