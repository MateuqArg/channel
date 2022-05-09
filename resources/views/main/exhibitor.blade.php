@extends('includes.app')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless/borderless.css">

<div class="container">
    <div class="row row-cols-1 g-3 ms-5 me-5">
        <div class="col">
            <div class="modal position-relative d-block">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Invitación como expositor</h5>
                  </div>
                  <div class="modal-body">
                <form method="POST" action="{{ route('exhibitor.store') }}" enctype="multipart/form-data">
                @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" value="{{ $user ? $user->name : "" }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ $user ? $user->email : "" }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> GUARDAR</button>
                  </div>
                </form>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

@if(Session::has('success'))
<script>
    $(document).ready( function() {
        Swal.fire({
            title: '¡Bienvenido!',
            html: 'Usuario confirmado correctamente',
            icon: 'success',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEnterKey: false,
            allowEscapeKey: false,
        })
    })
</script>
@endif
@include('includes.footer')
@endsection