<a data-bs-toggle="modal" data-bs-target="#create" class="btn btn-success btn-create" href=""><i class="bi bi-plus-lg"></i></a>

<div class="modal fade" wire:ignore.self id="create" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createLabel">Dar de alta expositor</h5>
        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
      </div>
      <div class="modal-body">
          @if(Session::has('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              <p class="mb-0"><i class="bi bi-check-circle-fill"></i> {{ Session::get('success') }}</p>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif
          @csrf
      <form method="POST" action="{{ route('organizer.exhibitor.create') }}" enctype="multipart/form-data">
      @csrf
          <div class="mb-3">
              <label for="name" class="form-label">Nombre</label>
              <input type="text" name="name" class="form-control" id="name" aria-describedby="nameHelp">
          </div>
          <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-left"></i></button>
        <button type="submit" class="btn btn-success"><i class="bi bi-send"></i> ENVIAR</button>
      </div>
      </form>
    </div>
  </div>
</div>