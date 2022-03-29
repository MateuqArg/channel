@extends('includes.app')
@section('content')
@include('includes.adminnavbar')
<div class="container-fluid">
</div>

@include('includes.adminfooter')
<div class="container">
	<div class="row">
		@forelse($seasons as $season)
  			<a type="button" data-bs-toggle="modal" data-bs-target="#select_phase" data-bs-id="{{ $season->id }}"
          class="col-md-2 card text-center justify-content-center text-decoration-none admin-card m-2">
          <p class="season-id">{{ $season->id }}</p>
          {{ $season->name }}
        </a>
  		@empty
  		@endforelse
  		<a type="button" data-bs-toggle="modal" data-bs-target="#create"
  			class="col-md-2 card admin-add-card text-center justify-content-center text-decoration-none m-2">
  			<span class="material-icons">
  				add
  			</span>
  		</a>
	</div>
  </div>


<!-- Modal create -->
<div class="modal fade" id="create" tabindex="-1" aria-labelledby="create" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="create">Crear una nueva temporada</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {{ Form::open(array('url' => 'admin/create_season', 'method' => 'POST', 'files'=> true)) }}
  			<div class="mb-3">
    			<label for="first_team_id" class="form-label">Nombre</label>
    			<input type="text"  class="form-control" name="name" id="name">
 			</div>
 			<div class="mb-3">
    			<label for="type" class="form-label">Tipo de eliminatorias</label>
    			<select class="form-select" name="type">
  					<option selected>Selecciona el tipo de eliminatorias</option>
  					<option value="boone">Single bracket</option>
  					<option value="bothree">Con lower bracket</option>
				</select>
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

<!-- Modal select phase -->
<div class="modal fade" id="select_phase" tabindex="-1" aria-labelledby="select_phase" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="select_phase">Selecciona una fase</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <input type="hidden" class="form-control" name="id" id="id">
            <a id="groups"
              class="col-md-6 card text-center justify-content-center text-decoration-none admin-card">
                Grupos
            </a>
            <a id="playoffs"
              class="col-md-6 card text-center justify-content-center text-decoration-none admin-card">
                Eliminatorias
            </a>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <span class="material-icons">undo</span>
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  var select_phase = document.getElementById('select_phase')
  select_phase.addEventListener('show.bs.modal', function (event) {
      // Button that triggered the modal
      var button = event.relatedTarget
      // Extract info from data-bs-* attributes
      var bsid = button.getAttribute('data-bs-id')

      // Update the modal's content.
      var modalId = select_phase.querySelector('.modal-body #id')
      $(".modal-body #groups").attr("href", "{{ url('/admin/phase_groups')}}/" + bsid)
      $(".modal-body #playoffs").attr("href", "{{ url('/admin/phase_playoffs')}}/" + bsid)

      modalId.value = bsid
  })
</script>
@endsection