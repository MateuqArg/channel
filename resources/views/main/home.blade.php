@extends('includes.app')
@section('content')
@include('includes.navbar')
<div class="container col-xxl-8 px-4 py-4">
    <div class="row flex-lg-row-reverse align-items-center g-5">
      <div class="col-10 col-sm-8 col-lg-6">
        <img src="{{ asset('images/gianelli.jpg') }}" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
      </div>
      <div class="col-lg-6">
        <h1 class="display-6 fw-bold lh-1 mb-3">«La dulzura, las buenas maneras, la paciencia no pueden ser nunca excesivas»</h1>
        <p class="lead">-San Antonio María Gianelli</p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
          <button type="button" class="btn btn-primary btn-lg px-4 me-md-2">Nuestra espiritualidad</button>
          <button type="button" class="btn btn-outline-secondary btn-lg px-4">Ex alumnos</button>
        </div>
      </div>
    </div>
  </div>

@include('includes.footer')
@endsection