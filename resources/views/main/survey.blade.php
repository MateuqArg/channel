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
                <form method="GET" action="{{ route('events.survey.store', ['custid' => $event->custid]) }}" enctype="multipart/form-data">
                @csrf
                    @foreach($inputs as $input)
                    <div class="mb-3">
                        @if($input->type == 'title')
                            <h4>{{ $input->label }}</h4>
                            <p>{{ $input->options }}</p>
                        @else
                        <label for="{{ $input->id }}" class="form-label me-2">{{ $input->label }}</label> <br>
                        @if($input->type == 'select')
                        <select name="{{ $input->id }}" class="form-control" id="{{ $input->id }}">
                            @foreach(explode('*', $input->options) as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </select>
                        @elseif($input->type == 'radio')
                        Poco
                        @foreach(explode('*', $input->options) as $option)
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="{{ $input->id }}" id="{{ $option }}" value="{{ $option }}">
                          <label class="form-check-label" for="{{ $option }}">{{ $option }}</label>
                        </div>
                        @endforeach
                        Mucho
                        @elseif($input->type == 'checkbox')
                        @foreach(explode('*', $input->options) as $option)
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="{{ $input->id }}[]" id="{{ $option }}" value="{{ $option }}">
                          <label class="form-check-label" for="{{ $option }}">{{ $option }}</label> <br>
                        </div>
                        @endforeach
                        @else
                        <input type="{{ $input->type }}" name="{{ $input->id }}" class="form-control" id="{{ $input->id }}">
                        @endif
                        @endif
                    </div>
                    @endforeach
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