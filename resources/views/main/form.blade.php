@extends('includes.app')
@section('content')
{{-- @include('includes.navbar') --}}
<div class="container">
    <div class="row row-cols-1 pt-3 justify-content-center">
        <div class="col-md-6">
          <img src="https://www.channeltalks.net/images/header.png" class="w-100">
          <div class="card">
            <div class="modal-content">
              <div class="modal-header d-block">
                <h4 class="modal-title"><strong>Inscripción {{ $event->title }}</strong></h4>
                <p>Evento de actualización de modelo de negocios. Inscripción gratuita, exclusivo para el canal IT. Jueves 7 de Julio, desde las 9:00 hs en Salones del Puerto - Calle 1º de Enero 40, Ciudad de Santa Fe - Puerto.</p>
              </div>
              <div class="modal-body">
                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <p class="mb-0"><i class="bi bi-check-circle-fill"></i> {{ Session::get('success') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if(is_object($event))
                <form method="GET" action="{{ route('events.form.store', ['custid' => $event->custid]) }}" enctype="multipart/form-data">
                @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre completo <strong>*</strong></label>
                        <input type="text" name="name" class="form-control" id="name" aria-describedby="nameHelp">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Dirección de email <strong>*</strong></label>
                        <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Teléfono <strong>*</strong></label>
                        <input type="number" name="phone" class="form-control" id="phone" min="1" aria-describedby="phoneHelp">
                    </div>

                    <div class="mb-3">
                        <label for="company" class="form-label">Empresa <strong>*</strong></label>
                        <input type="text" name="company" class="form-control" id="company" aria-describedby="companyHelp">
                    </div>
                    <div class="mb-3">
                        <label for="charge" class="form-label">Cargo <strong>*</strong></label>
                        <input type="text" name="charge" class="form-control" id="charge" aria-describedby="chargeHelp">
                    </div>
                    <div class="mb-3">
                        <label for="state" class="form-label">Provincia <strong>*</strong></label>
                        <input type="text" name="state" class="form-control" id="state" aria-describedby="stateHelp">
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">Localidad <strong>*</strong></label>
                        <input type="text" name="city" class="form-control" id="city" aria-describedby="cityHelp">
                    </div>
                    {{-- <div class="form-check">
					  <input class="form-check-input meeting" type="checkbox" name="meeting" id="meeting">
					  <label class="form-check-label" for="meeting">
					    Solicitar reunión con expositor
					  </label>
					</div>
					<select name="exhibitors[]" class="exhibitors" style="display: none;">
                        @foreach($exhibitors as $exhibitor)
				           <option value="{{ $exhibitor->id }}">{{ $exhibitor->name }}</option>
                        @endforeach
					</select> --}}
              </div>
              <div class="modal-footer">

                <button type="submit" class="btn btn-success"><i class="bi bi-box-arrow-in-up-right"></i> SIGUIENTE</button>
              </div>
              </form>
              @else
               {{ $event }}
              @endif
            </div>
          </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.exhibitors').select2();
    });
    $(function () {
        $(".selectmeet").hide(this.checked);
    });
    $('.meeting').click(function() {
        $(".selectmeet").toggle(this.checked);
    });
</script>
@include('includes.footer')
@endsection