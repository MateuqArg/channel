@extends('includes.app')
@section('content')
@include('includes.adminnavbar')
<div class="container-fluid">
</div>

@include('includes.adminfooter')
<div class="container-fluid pt-5 pb-5">
  <div class="row">
    <div class="col-md-4">
      <h4 class="m-0 fs24">FASE DE GRUPOS</h4>
    </div>
  </div>
  <div class="row">
    <div class="col-md-2 col-2 p-2">
      <div class="row">
        <?php $i = 0 ?>
        @foreach($groups as $group)
        @if($group->group_id == "A")
        <div class="col-md-12 p-2 pt-1 pb-0">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$group->team->logo) }}"> {{ $group->team->name }}
            <span class="groups-score
            {{ $group->points == 0 ? "any" : ($i == 0 ? "winner" : ($i == 1 ? "winner" : "losser")) }}
            d-flex justify-content-center">
            {{ $group->won_maps }} : {{ $group->lost_maps }} 
            | {{ $group->won_rounds }} : {{ $group->lost_rounds }} 
            | @if($group->won_rounds > $group->lost_rounds) + @else - @endif
            {{ abs($group->won_rounds - $group->lost_rounds) }}
            </span>
          </div>
        </div>
        <?php $i++ ?>
        @endif
        @endforeach
      </div>
    </div>
    <div class="col-md-2 col-2 p-2">
      <div class="row">
        <?php $i = 0 ?>
        @foreach($groups as $group)
        @if($group->group_id == "B")
        <div class="col-md-12 p-2 pt-1 pb-0">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$group->team->logo) }}"> {{ $group->team->name }}
            <span class="groups-score
            {{ $group->points == 0 ? "any" : ($i == 0 ? "winner" : ($i == 1 ? "winner" : "losser")) }}
            d-flex justify-content-center">
            {{ $group->won_maps }} : {{ $group->lost_maps }} 
            | {{ $group->won_rounds }} : {{ $group->lost_rounds }} 
            | @if($group->won_rounds > $group->lost_rounds) + @else - @endif
            {{ abs($group->won_rounds - $group->lost_rounds) }}
            </span>
          </div>
        </div>
        <?php $i++ ?>
        @endif
        @endforeach
      </div>
    </div>
    <div class="col-md-2 col-2 p-2">
      <div class="row">
        <?php $i = 0 ?>
        @foreach($groups as $group)
        @if($group->group_id == "C")
        <div class="col-md-12 p-2 pt-1 pb-0">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$group->team->logo) }}"> {{ $group->team->name }}
            <span class="groups-score
            {{ $group->points == 0 ? "any" : ($i == 0 ? "winner" : ($i == 1 ? "winner" : "losser")) }}
            d-flex justify-content-center">
            {{ $group->won_maps }} : {{ $group->lost_maps }} 
            | {{ $group->won_rounds }} : {{ $group->lost_rounds }} 
            | @if($group->won_rounds > $group->lost_rounds) + @else - @endif
            {{ abs($group->won_rounds - $group->lost_rounds) }}
            </span>
          </div>
        </div>
        <?php $i++ ?>
        @endif
        @endforeach
      </div>
    </div>
    <div class="col-md-2 col-2 p-2">
      <div class="row">
        <?php $i = 0 ?>
        @foreach($groups as $group)
        @if($group->group_id == "D")
        <div class="col-md-12 p-2 pt-1 pb-0">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$group->team->logo) }}"> {{ $group->team->name }}
            <span class="groups-score
            {{ $group->points == 0 ? "any" : ($i == 0 ? "winner" : ($i == 1 ? "winner" : "losser")) }}
            d-flex justify-content-center">
            {{ $group->won_maps }} : {{ $group->lost_maps }} 
            | {{ $group->won_rounds }} : {{ $group->lost_rounds }} 
            | @if($group->won_rounds > $group->lost_rounds) + @else - @endif
            {{ abs($group->won_rounds - $group->lost_rounds) }}
            </span>
          </div>
        </div>
        <?php $i++ ?>
        @endif
        @endforeach
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-2">Grupo A</div>
    <div class="col-md-2">Grupo B</div>
    <div class="col-md-2">Grupo C</div>
    <div class="col-md-2">Grupo D</div>
  </div>
  <!-- Button modal -->
    <button type="button" class="btn btn-success btn-create" data-bs-toggle="modal" data-bs-target="#create">
        <span class="material-icons">add</span>
    </button>
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
        <input type="hidden" name="season_id" value="{{ $groups[0]->games[0]->season_id }}">
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
        <button onclick="deleteConfirm()" type="button" class="btn btn-danger">
          <span class="material-icons">delete</span>
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

  window.deleteConfirm = function()
  {
      var formId = $('.modal-body #id').val();

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
@endsection