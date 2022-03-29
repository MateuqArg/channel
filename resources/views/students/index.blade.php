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
      					<th>Primer equipo</th>
      					<th>Segundo equipo</th>
      					<th>Rondas primer equipo</th>
      					<th>Rondas segundo equipo</th>
      					<th>Tipo</th>
      					<th>Fecha</th>
      					<th>Fase</th>
    				</tr>
  				</thead>
 		 		<tbody>
  					@forelse($games as $game)
  						<tr>
  							<td>{{ $game->id }}</td>
  							<td>
  								<button type="button" class="btn p-0"
  								data-bs-toggle="modal" data-bs-target="#edit"
                  data-bs-id="{{ $game->id }}" data-bs-season_id="{{ $game->season_id }}" data-bs-first_team_id="{{ $game->first_team_id }}" data-bs-second_team_id="{{ $game->second_team_id }}" data-bs-first_rounds="{{ $game->first_rounds }}" data-bs-second_rounds="{{ $game->second_rounds }}" data-bs-type="{{ $game->type }}" data-bs-date="{{ $game->date }}" data-bs-phase="{{ $game->phase }}">
  									<span class="material-icons text-warning">edit</span>
								</button>
								<button onclick="deleteConfirm({{ $game->id }})" type="button" class="btn p-0">
  									<span class="material-icons text-danger">delete</span>
								</button>
  							</td>
  							<td>{{ $game->first_team->name }}</td>
  							<td>{{ $game->second_team->name }}</td>
  							<td>{{ $game->first_rounds }}</td>
  							<td>{{ $game->second_rounds }}</td>
  							<td>{{ $game->type }}</td>
  							<td>{{ $game->date }}</td>
  							<td>{{ $game->phase }}</td>
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
        <h5 class="modal-title" id="create">Crear un nuevo partido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {{ Form::open(array('url' => 'admin/create_game', 'method' => 'POST', 'files'=> true)) }}
  			<div class="mb-3">
    			<label for="first_team_id" class="form-label">Id del primer equipo</label>
    			<input type="number"  class="form-control" name="first_team_id" id="first_team_id">
 			</div>
  			<div class="mb-3">
    			<label for="second_team_id" class="form-label">Id del segundo equipo</label>
    			<input type="number" class="form-control" name="second_team_id" id="second_team_id">
  			</div>
  			<div class="mb-3">
    			<label for="first_rounds" class="form-label">Rondas del primer equipo (se puede dejar vacio)</label>
    			<input type="number" class="form-control" name="first_rounds" id="first_rounds">
  			</div>
  			<div class="mb-3">
    			<label for="second_rounds" class="form-label">Rondas del segundo equipo (se puede dejar vacio)</label>
    			<input type="number" class="form-control" name="second_rounds" id="second_rounds">
  			</div>
  			<div class="mb-3">
    			<label for="type" class="form-label">Tipo de partido</label>
    			<select class="form-select" name="type">
  					<option selected>Selecciona el tipo de partido</option>
  					<option value="boone">Best of one</option>
  					<option value="bothree">Best of three</option>
				</select>
  			</div>
  			<div class="mb-3">
    			<label for="date" class="form-label">Fecha y horario del partido (se puede dejar vacio)</label>
    			<input type="date" class="form-control" name="date" id="date">
  			</div>
  			<div class="mb-3">
    			<label for="phase" class="form-label">Fase</label>
    			<select class="form-select" name="phase">
  					<option selected>Selecciona la fase del partido</option>
  					<option value="groups">Fase de grupos</option>
  					<option value="playoffs">Fase de eliminatorias</option>
				</select>
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
        <h5 class="modal-title" id="edit">Editar partido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {{ Form::open(array('url' => 'admin/edit_game', 'method' => 'POST', 'files'=> true)) }}
        <input type="hidden" class="form-control" name="id" id="id">
        <div class="mb-3">
          <label for="season_id" class="form-label">Id de temporada (normalmente coincide con el número de temporada)</label>
          <input type="number"  class="form-control" name="season_id" id="season_id">
        </div>
        <div class="mb-3">
          <label for="first_team_id" class="form-label">Id del primer equipo</label>
          <input type="number"  class="form-control" name="first_team_id" id="first_team_id">
        </div>
        <div class="mb-3">
          <label for="second_team_id" class="form-label">Id del segundo equipo</label>
          <input type="number"  class="form-control" name="second_team_id" id="second_team_id">
        </div>
        <div class="mb-3">
          <label for="first_rounds" class="form-label">Cantidad de rondas del primer equipo</label>
          <input type="number"  class="form-control" name="first_rounds" id="first_rounds">
        </div>
        <div class="mb-3">
          <label for="second_rounds" class="form-label">Cantidad de rondas del segundo equipo</label>
          <input type="number"  class="form-control" name="second_rounds" id="second_rounds">
        </div>
        <div class="mb-3">
          <label for="type" class="form-label">Tipo de partido</label>
          <select class="form-select" name="type" id="type">
            <option>Selecciona el tipo de partido</option>
            <option value="boone">Best of one</option>
            <option value="bothree">Best of three</option>
        </select>
        </div>
        <div class="mb-3">
          <label for="date" class="form-label">Fecha y horario del partido (se puede dejar vacio)</label>
          <input type="datetime-local" class="form-control" name="date" id="date">
        </div>
        <div class="mb-3">
          <label for="phase" class="form-label">Fase</label>
          <select class="form-select" name="phase" id="phase">
            <option selected>Selecciona la fase del partido</option>
            <option value="groups">Fase de grupos</option>
            <option value="playoffs">Fase de eliminatorias</option>
        </select>
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
      var bsseasonid = button.getAttribute('data-bs-season_id')
      var bsfirstteamid = button.getAttribute('data-bs-first_team_id')
      var bssecondteamid = button.getAttribute('data-bs-second_team_id')
      var bsfirstrounds = button.getAttribute('data-bs-first_rounds')
      var bssecondrounds = button.getAttribute('data-bs-second_rounds')
      var bstype = button.getAttribute('data-bs-type')
      var bsdate = button.getAttribute('data-bs-date')
      var bsphase = button.getAttribute('data-bs-phase')

      // Update the modal's content.
      var modalId = edit.querySelector('.modal-body #id')
      var modalSeasonid = edit.querySelector('.modal-body #season_id')
      var modalFirstteamid = edit.querySelector('.modal-body #first_team_id')
      var modalSecondteamid = edit.querySelector('.modal-body #second_team_id')
      var modalFirstrounds = edit.querySelector('.modal-body #first_rounds')
      var modalSecondrounds = edit.querySelector('.modal-body #second_rounds')
      var modalType = edit.querySelector('.modal-body #type')
      var modalDate = edit.querySelector('.modal-body #date')
      var modalPhase = edit.querySelector('.modal-body #phase')

      modalId.value = bsid
      modalSeasonid.value = bsseasonid
      modalFirstteamid.value = bsfirstteamid
      modalSecondteamid.value = bssecondteamid
      modalFirstrounds.value = bsfirstrounds
      modalSecondrounds.value = bssecondrounds
      modalType.value = bstype
      modalDate.value = bsdate
      modalPhase.value = bsphase
  })
</script>

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
        	text: '¿Estás seguro que querés eliminar este partido?',
        	confirmButtonText: 'Eliminar',
        	confirmButtonColor: '#e3342f',
    	}).then((result) => {
        	if (result.isConfirmed) {
            	window.location="{{ url('/admin/delete_game')}}/" + formId;
        	}
    	});
	}
</script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('includes.adminfooter')
@endsection