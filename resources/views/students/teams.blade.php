@extends('includes.app')
@section('content')
@include('includes.adminnavbar')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<table class="table table-dark mt-3">
				<thead>
    				<tr>
      					<th>#</th>
      					<th>Acciones</th>
      					<th>Nombre</th>
      					<th>Nombre corto</th>
      					<th>Logo</th>
    				</tr>
  				</thead>
 		 		<tbody>
  					@forelse($teams as $team)
  						<tr>
  							<td>{{ $team->id }}</td>
  							<td>
  								<button type="button" class="btn p-0"
  								data-bs-id="{{ $team->id }}"
  								data-bs-name="{{ $team->name }}"
  								data-bs-short_name="{{ $team->short_name }}"
  								data-bs-toggle="modal" data-bs-target="#edit">
  									<span class="material-icons text-warning">edit</span>
								</button>
								<button onclick="deleteConfirm({{ $team->id }})" type="button" class="btn p-0">
  									<span class="material-icons text-danger">delete</span>
								</button>
  							</td>
  							<td>{{ $team->name }}</td>
  							<td>{{ $team->short_name }}</td>
  							<td><img src="{{ asset('images/teams/'.$team->logo) }}" width="40" height="40"></td>
  						</tr>
  					@empty
  					@endforelse
  				</tbody>
			</table>
			<!-- Button modal -->
			<button type="button" class="btn btn-success btn-create" data-bs-toggle="modal" data-bs-target="#create">
  				<span class="material-icons">add</span>
			</button>
		</div>
	</div>
</div>



<!-- Modal create -->
<div class="modal fade" id="create" tabindex="-1" aria-labelledby="create" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="create">Crear un nuevo equipo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {{ Form::open(array('url' => 'admin/create_team', 'method' => 'POST', 'files'=> true)) }}
  			<div class="mb-3">
    			<label for="name" class="form-label">Nombre</label>
    			<input type="text"  class="form-control" name="name" id="name">
 			</div>
  			<div class="mb-3">
    			<label for="short_name" class="form-label">Nombre corto</label>
    			<input type="text" class="form-control" name="short_name" id="short_name">
  			</div>
  			<div class="mb-3">
    			<label for="logo" class="form-label">Logo</label>
    			<input type="file" class="form-control" name="logo" id="logo">
  			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
        	<span class="material-icons">undo</span>
        </button>
        <button type="submit" class="btn btn-success">
        	<span class="material-icons">save</span>
        </button>
      </div>
    </div>
    	{{ Form::close() }}
  </div>
</div>

<!-- Modal edit -->
<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="edit" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit">Crearvo equipo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {{ Form::open(array('url' => 'admin/edit_team', 'method' => 'POST', 'files'=> true)) }}
        <input type="hidden" class="form-control" name="id" id="id">
  			<div class="mb-3">
    			<label for="name" class="form-label">Nombre</label>
    			<input type="text"  class="form-control" name="name" id="name">
 			</div>
  			<div class="mb-3">
    			<label for="short_name" class="form-label">Nombre corto</label>
    			<input type="text" class="form-control" name="short_name" id="short_name">
  			</div>
  			<div class="mb-3">
    			<label for="logo" class="form-label">Logo</label>
    			<input type="file" class="form-control" name="logo" id="logo">
  			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
        	<span class="material-icons">undo</span>
        </button>
        <button type="submit" class="btn btn-success">
        	<span class="material-icons">save</span>
        </button>
      </div>
    </div>
    	{{ Form::close() }}
  </div>
</div>

<script>
	var edit = document.getElementById('edit')
	edit.addEventListener('show.bs.modal', function (event) {
  		// Button that triggered the modal
  		var button = event.relatedTarget
  		// Extract info from data-bs-* attributes
  		var bsid = button.getAttribute('data-bs-id')
  		var bsname = button.getAttribute('data-bs-name')
  		var bsshortname = button.getAttribute('data-bs-short_name')
  		// Update the modal's content.
  		var modalTitle = edit.querySelector('.modal-title')
  		var modalId = edit.querySelector('.modal-body #id')
  		var modalName = edit.querySelector('.modal-body #name')
  		var modalShortname = edit.querySelector('.modal-body #short_name')

  		modalTitle.textContent = 'Editar equipo: ' + bsname
  		modalId.value = bsid
  		modalName.value = bsname
  		modalShortname.value = bsshortname
	})

	window.deleteConfirm = function(formId)
	{
    	Swal.fire({
        	icon: 'warning',
        	text: '¿Estás seguro que querés eliminar este equipo?',
        	confirmButtonText: 'Eliminar',
        	confirmButtonColor: '#e3342f',
    	}).then((result) => {
        	if (result.isConfirmed) {
            	window.location="{{ url('/admin/delete_team')}}/" + formId;
        	}
    	});
	}
</script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('includes.adminfooter')
@endsection