@extends('includes.app')
@section('content')
{{-- @include('includes.navbar') --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-es_ES.min.js"></script>
<div class="container">
    <div class="row row-cols-1 g-3 ms-5 me-5">
        <div class="col">
            <div class="modal form-inscription">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Formulario de asistencia</h5>
                  </div>
                  <div class="modal-body">
                    @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <p class="mb-0"><i class="bi bi-check-circle-fill"></i> {{ Session::get('success') }}</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <form method="GET" action="{{ route('visitor.inscription.store', ['custid' => $event->custid]) }}" enctype="multipart/form-data">
                    @csrf
                    <h6>De tener una sesión iniciada se autocompletaran los datos compatibles, en caso de no tener cuenta con el envio de este formulario se le generará automáticamente.
                        @if(!$user)<br>¿Ya estás registrado? <a href="{{ route('login') }}">Iniciar sesión</a>@endif</h6>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre y Apellido</label>
                            <input type="text" name="name" class="form-control" id="name" aria-describedby="nameHelp" value="{{ $user ? $user->name : "" }}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" value="{{ $user ? $user->email : "" }}">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Teléfono</label>
                            <input type="number" name="phone" class="form-control" id="phone" aria-describedby="phoneHelp" value="{{ $user->phone ? $user->phone : "" }}">
                        </div>

                        @if(!$user)
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control" id="password" aria-describedby="passwordHelp">
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" aria-describedby="password_confirmationHelp">
                        </div>
                        @endif

                        @if(in_array("charge", $data))
                        <div class="mb-3">
                            <label for="charge" class="form-label">Cargo</label>
                            <input type="text" name="charge" class="form-control" id="charge" aria-describedby="chargeHelp">
                        </div>
                        @endif
                        @if(in_array("company", $data))
                        <div class="mb-3">
                            <label for="company" class="form-label">Empresa</label>
                            <input type="text" name="company" class="form-control" id="company" aria-describedby="companyHelp">
                        </div>
                        @endif
                        @if(in_array("country", $data))
                        <div class="mb-3">
                            <label for="country" class="form-label">País</label>
                            <input type="text" name="country" class="form-control" id="country" aria-describedby="countryHelp">
                        </div>
                        @if(in_array("state", $data))
                        <div class="mb-3">
                            <label for="state" class="form-label">Provincia</label>
                            <input type="text" name="state" class="form-control" id="state" aria-describedby="stateHelp">
                        </div>
                        @endif
                        @if(in_array("city", $data))
                        <div class="mb-3">
                            <label for="city" class="form-label">Ciudad</label>
                            <input type="text" name="city" class="form-control" id="city" aria-describedby="cityHelp">
                        </div>
                        @endif
                        @endif
                        <div class="form-check">
						  <input class="form-check-input meeting" type="checkbox" name="meeting" id="meeting">
						  <label class="form-check-label" for="meeting">
						    Solicitar reunión con expositor
						  </label>
						</div>
						<select name="exhibitors[]" multiple class="selectpicker" data-selected-text-format="count" data-style="selectmeet" style="display: none;">
                            @foreach($exhibitors as $exhibitor)
					           <option value="{{ $exhibitor->id }}">{{ $exhibitor->name }}</option>
                            @endforeach
						</select>
                  </div>
                  <div class="modal-footer">
                    @if(Session::has('success'))
                        <button disabled class="btn btn-success"><i class="bi bi-save"></i> GUARDAR</button>
                    @else
                        <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> GUARDAR</button>
                    @endif
                  </div>
                  </form>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

<script>
	$(function () {
	   $('select').selectpicker();
    });
</script>
<script>
    $(function () {
        $(".selectmeet").hide(this.checked);
    });
	$('.meeting').click(function() {
	    $(".selectmeet").toggle(this.checked);
	});
</script>
@include('includes.footer')
@endsection