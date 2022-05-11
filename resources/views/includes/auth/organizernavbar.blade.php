<header class="p-3 mb-2 border-bottom">
    <div class="container-fluid">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="{{ route('organizer.events.index') }}" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
          <img src="{{ asset('images/logo.png') }}" class="me-2" alt="" height="40">
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="{{ route('organizer.events.index') }}" class="nav-link px-2 link-dark
            {{ Request::is('organizer/events') ? "active" : "" }}">Eventos</a></li>
          <li><a href="{{ route('organizer.exhibitor.index') }}" class="nav-link px-2 link-dark
            {{ Request::is('organizer/exhibitor') ? "active" : "" }}">Expositores</a></li>
          <li><a href="{{ route('organizer.talk.index') }}" class="nav-link px-2 link-dark
            {{ Request::is('organizer/talk') ? "active" : "" }}">Grupos</a></li>
          <li><a href="{{ route('organizer.visitors.index') }}" class="nav-link px-2 link-dark
            {{ Request::is('organizer/visitors') ? "active" : "" }}">Asistentes</a></li>
          <li><a href="{{ route('organizer.staff.index') }}" class="nav-link px-2 link-dark
            {{ Request::is('organizer/staff') ? "active" : "" }}">Staff</a></li>
        </ul>

        <div class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
          <a href="" id="simulate-btn" data-bs-toggle="modal" data-bs-target="#simulate" class="mb-0">Ver como expositor</a>
        </div>

        <div class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
          <p class="mb-0">{{ \Auth::user()->name }}</p>
        </div>

        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="user" data-bs-toggle="dropdown" aria-expanded="false">
            @if(\Auth::user()->avatar <> null)
              <img src="{{ asset('/uploads/'.\Auth::user()->avatar) }}" width="32" height="32" class="rounded-circle">
            @else
              <img src="{{ asset('/uploads/default.svg') }}" width="32" height="32" class="rounded-circle">
            @endif
          </a>
          <ul class="dropdown-menu text-small" aria-labelledby="user">
            <li><a class="dropdown-item" href="{{ route('profile') }}">Perfil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="dropdown-item">Cerrar sesión</button>
              </form>
            </li>
          </ul>
        </div>

        @livewire('tracks')
      </div>
    </div>

  <div class="modal fade" id="simulate" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="simulateLabel">Visualizar página como expositor</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('organizer.simulate.send') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="talks" class="form-label">Seleccionar entre la lista de expositores</label>
                <select class="form-control" name="userid" id="userid">
                  @foreach($exhibitors as $user)
                  <option value="{{ $user->id }}">{{ $user->name }}</option>
                  @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i></button>
          <button type="submit" class="btn btn-success"><i class="bi bi-send"></i> ENVIAR</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<script>
  $(document).ready(function() {
    $('#userid').select2({theme: 'bootstrap-5'});
  });
</script>
</header>