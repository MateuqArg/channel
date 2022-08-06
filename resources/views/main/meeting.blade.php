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
                </div>
                @else
                @if(is_object($event))
                <form method="GET" action="{{ route('events.meeting.store', ['custid' => $event->custid]) }}" enctype="multipart/form-data">
                @csrf                
                    <div class="mb-3">
                        <h4>Reuniones uno a uno</h4>
                        <p>Indíquenos si quiere coordinar una reunión individual con alguna de estas empresas. En este caso la empresa se contactará para coordinar el encuentro durante el evento.</p>
                    </div>
                    <div class="mb-3">
                        <label for="pido-reunirme-con" class="form-label me-2">Pido reunirme con...</label> <br>
                        @foreach($exhibitors as $exhibitor)
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="meeting[]" id="{{ $exhibitor->id }}" value="{{ $exhibitor->id }}">
                          <label class="form-check-label" for="{{ $exhibitor->id }}">{{ $exhibitor->name }}</label> <br>
                        </div>
                        @endforeach
                    </div>
              </div>
              <div class="modal-footer">

                <button type="submit" class="btn btn-success"><i class="bi bi-send"></i> ENVIAR</button>
              </div>
              </form>
              @else
               {{ $event }}
              @endif
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