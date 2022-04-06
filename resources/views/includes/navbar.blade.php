<div class="container-fluid">
  <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
    <a href="{{ url('/') }}" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
      <img src="{{ asset('images/logo.png') }}" class="me-2" alt="" width="40" height="40">
    </a>

    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
      <li class="nav-item dropdown">
        <a class="nav-link px-2 link-dark dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          INSTITUCIONAL
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="#">Historia</a></li>
          <li><a class="dropdown-item" href="#">Ideario educativo</a></li>
          <li><a class="dropdown-item" href="#">Autoridades</a></li>
          <li><a class="dropdown-item" href="#">Uniforme</a></li>
        </ul>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link px-2 link-dark dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          EL COLEGIO
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="#">¿Quienes somos?</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="#">Secundario</a></li>
          <li><a class="dropdown-item" href="#">Primario</a></li>
          <li><a class="dropdown-item" href="#">Administración</a></li>
        </ul>
      </li>
      <li><a href="#" class="nav-link px-2 link-dark">LA CAPILLA</a></li>
      <li><a href="#" class="nav-link px-2 link-dark">ACTIVIDADES</a></li>
      <li><a href="#" class="nav-link px-2 link-dark">CONTACTO</a></li>
    </ul>

    <div class="col-md-3 text-end">
      <a href="{{ url('login') }}" class="btn btn-outline-primary me-2">INGRESO</a>
      {{-- <button type="button" class="btn btn-primary">Sign-up</button> --}}
    </div>
  </header>
</div>