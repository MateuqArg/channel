<header class="p-3 mb-2 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="{{ route('organizer.events.index') }}" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
          <img src="{{ asset('images/logo.png') }}" class="me-2" alt="" height="50">
        </a>

        {{-- Index links --}}
        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="{{ route('organizer.events.index') }}" class="nav-link px-2 link-dark
            {{ Request::is('organizer/events') ? "active" : "" }}">Eventos</a></li>
          <li><a href="{{ route('organizer.exhibitors') }}" class="nav-link px-2 link-dark
            {{ Request::is('organizer/exhibitors') ? "active" : "" }}">Expositores</a></li>
          <li><a href="{{ route('organizer.talks') }}" class="nav-link px-2 link-dark
            {{ Request::is('organizer/talks') ? "active" : "" }}">Charlas</a></li>
          <li><a href="{{ route('organizer.admins') }}" class="nav-link px-2 link-dark
            {{ Request::is('organizer/admins') ? "active" : "" }}">Administradores</a></li>
          <li><a href="{{ route('organizer.visitors') }}" class="nav-link px-2 link-dark
            {{ Request::is('organizer/visitors') ? "active" : "" }}">Asistentes</a></li>
        </ul>

        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="user" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/mdo.png" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small" aria-labelledby="user">
            <li><a class="dropdown-item" href="#">Perfil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="dropdown-item">Cerrar sesión</button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </header>