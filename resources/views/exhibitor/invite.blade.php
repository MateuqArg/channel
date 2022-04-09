@extends('includes.app')
@section('content')
@include('includes.auth.exhibitornavbar')
<div class="container">
    <div class="row row-cols-1 g-3 ms-5 me-5">
        <div class="col">
            <div class="modal position-relative d-block">
              <div class="modal-dialog mb-0">
                <div class="modal-content">
                  <div class="modal-body">
                    <form method="GET" action="{{ route('exhibitor.invite.send') }}" enctype="multipart/form-data">
                      <div class="mb-3">
                        <label for="file" class="form-label">Cargar archivo excel</label>
                        <input type="file" name="excel" class="form-control" id="excel" aria-describedby="excelHelp" accept=".xls, .xlsx">
                        <div id="excelHelp" class="form-text">Solo se aceptan archivos con formato .xls y .xlsx</div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
    <div class="row row-cols-1 g-3 ms-5 me-5">
        <div class="col">
            <div class="modal position-relative d-block">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Invitar clientes</h5>
                  </div>
                  <div class="modal-body">
                    @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <p class="mb-0"><i class="bi bi-check-circle-fill"></i> {{ Session::get('success') }}</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="name" name="name" class="form-control" id="name" aria-describedby="nameHelp">
                            <div id="nameHelp" class="form-text">Texto de aclaración sobre el input de arriba.</div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">Texto de aclaración sobre el input de arriba.</div>
                        </div>
                        <div class="mb-3">
                            <label for="company" class="form-label">Empresa</label>
                            <input type="name" name="company" class="form-control" id="company" aria-describedby="companyHelp">
                            <div id="companyHelp" class="form-text">Texto de aclaración sobre el input de arriba.</div>
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
@include('includes.footer')
@endsection