@extends('includes.app')
@section('content')
@include('includes.adminnavbar')
<div class="container-fluid">
</div>

@include('includes.adminfooter')
<div class="container-fluid pb-5" style="background-color: #C9C9C9">
  <div class="row">
    <div class="col-md-4">
      <h4 class="m-0 fs24">UPPER BRACKET</h4>
    </div>
  </div>
  <div class="row">
    <div class="col-md-2 col-2">
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[0]->game->first_team->logo) }}">
            <div class="d-none d-sm-inline">{{ $playoffs[0]->game->first_team->name }}</div>
            <span class="bracket-score d-flex justify-content-center
            {{ $playoffs[0]->game->first_rounds > $playoffs[0]->game->second_rounds ? "winner" : ($playoffs[0]->game->first_rounds < $playoffs[0]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[0]->game->first_rounds ? $playoffs[0]->game->first_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0 mt--1">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[0]->game->second_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[0]->game->second_team->name }}</div>
            <span class="bracket-score winner d-flex justify-content-center
            {{ $playoffs[0]->game->first_rounds < $playoffs[0]->game->second_rounds ? "winner" : ($playoffs[0]->game->first_rounds > $playoffs[0]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[0]->game->second_rounds ? $playoffs[0]->game->second_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[1]->game->first_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[1]->game->first_team->name }}</div>
            <span class="bracket-score d-flex justify-content-center
            {{ $playoffs[1]->game->first_rounds > $playoffs[1]->game->second_rounds ? "winner" : ($playoffs[1]->game->first_rounds < $playoffs[1]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[1]->game->first_rounds ? $playoffs[1]->game->first_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0 mt--1">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[1]->game->second_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[1]->game->second_team->name }}</div>
            <span class="bracket-score winner d-flex justify-content-center
            {{ $playoffs[1]->game->first_rounds < $playoffs[1]->game->second_rounds ? "winner" : ($playoffs[1]->game->first_rounds > $playoffs[1]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[1]->game->second_rounds ? $playoffs[1]->game->second_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[2]->game->first_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[2]->game->first_team->name }}</div>
            <span class="bracket-score d-flex justify-content-center
            {{ $playoffs[2]->game->first_rounds > $playoffs[2]->game->second_rounds ? "winner" : ($playoffs[2]->game->first_rounds < $playoffs[2]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[2]->game->first_rounds ? $playoffs[2]->game->first_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0 mt--1">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[2]->game->second_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[2]->game->second_team->name }}</div>
            <span class="bracket-score winner d-flex justify-content-center
            {{ $playoffs[2]->game->first_rounds < $playoffs[2]->game->second_rounds ? "winner" : ($playoffs[2]->game->first_rounds > $playoffs[2]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[2]->game->second_rounds ? $playoffs[2]->game->second_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[3]->game->first_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[3]->game->first_team->name }}</div>
            <span class="bracket-score d-flex justify-content-center
            {{ $playoffs[3]->game->first_rounds > $playoffs[3]->game->second_rounds ? "winner" : ($playoffs[3]->game->first_rounds < $playoffs[3]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[3]->game->first_rounds ? $playoffs[3]->game->first_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0 mt--1">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[3]->game->second_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[3]->game->second_team->name }}</div>
            <span class="bracket-score winner d-flex justify-content-center
            {{ $playoffs[3]->game->first_rounds < $playoffs[3]->game->second_rounds ? "winner" : ($playoffs[3]->game->first_rounds > $playoffs[3]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[3]->game->second_rounds ? $playoffs[3]->game->second_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row">
        <div class="col-md-12">Cuartos Upper Bracket</div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <h4 class="m-0 fs24">LOWER BRACKET</h4>
        </div>
      </div>
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[4]->game->first_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[4]->game->first_team->name }}</div>
            <span class="bracket-score d-flex justify-content-center
            {{ $playoffs[4]->game->first_rounds > $playoffs[4]->game->second_rounds ? "winner" : ($playoffs[4]->game->first_rounds < $playoffs[4]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[4]->game->first_rounds ? $playoffs[4]->game->first_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0 mt--1">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[4]->game->second_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[4]->game->second_team->name }}</div>
            <span class="bracket-score winner d-flex justify-content-center
            {{ $playoffs[4]->game->first_rounds < $playoffs[4]->game->second_rounds ? "winner" : ($playoffs[4]->game->first_rounds > $playoffs[4]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[4]->game->second_rounds ? $playoffs[4]->game->second_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[5]->game->first_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[5]->game->first_team->name }}</div>
            <span class="bracket-score d-flex justify-content-center
            {{ $playoffs[5]->game->first_rounds > $playoffs[5]->game->second_rounds ? "winner" : ($playoffs[5]->game->first_rounds < $playoffs[5]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[5]->game->first_rounds ? $playoffs[5]->game->first_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0 mt--1">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[5]->game->second_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[5]->game->second_team->name }}</div>
            <span class="bracket-score winner d-flex justify-content-center
            {{ $playoffs[5]->game->first_rounds < $playoffs[5]->game->second_rounds ? "winner" : ($playoffs[5]->game->first_rounds > $playoffs[5]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[5]->game->second_rounds ? $playoffs[5]->game->second_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row">
        <div class="col-md-12">Primera etapa lower bracket</div>
      </div>
    </div>
    <div class="col-md-2 col-3" style="margin-top: 4rem;">
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[6]->game->first_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[6]->game->first_team->name }}</div>
            <span class="bracket-score d-flex justify-content-center
            {{ $playoffs[6]->game->first_rounds > $playoffs[6]->game->second_rounds ? "winner" : ($playoffs[6]->game->first_rounds < $playoffs[6]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[6]->game->first_rounds ? $playoffs[6]->game->first_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row p-2" style="margin-bottom: 8.3rem;">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0 mt--1">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[6]->game->second_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[6]->game->second_team->name }}</div>
            <span class="bracket-score winner d-flex justify-content-center
            {{ $playoffs[6]->game->first_rounds < $playoffs[6]->game->second_rounds ? "winner" : ($playoffs[6]->game->first_rounds > $playoffs[6]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[6]->game->second_rounds ? $playoffs[6]->game->second_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>  
      </div>
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[7]->game->first_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[7]->game->first_team->name }}</div>
            <span class="bracket-score d-flex justify-content-center
            {{ $playoffs[7]->game->first_rounds > $playoffs[7]->game->second_rounds ? "winner" : ($playoffs[7]->game->first_rounds < $playoffs[7]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[7]->game->first_rounds ? $playoffs[7]->game->first_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0 mt--1">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[7]->game->second_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[7]->game->second_team->name }}</div>
            <span class="bracket-score winner d-flex justify-content-center
            {{ $playoffs[7]->game->first_rounds < $playoffs[7]->game->second_rounds ? "winner" : ($playoffs[7]->game->first_rounds > $playoffs[7]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[7]->game->second_rounds ? $playoffs[7]->game->second_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row">
        <div class="col-md-12">Semifinal upper bracket</div>
      </div>
      <div class="row p-2" style="margin-top: 5rem;">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[8]->game->first_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[8]->game->first_team->name }}</div>
            <span class="bracket-score d-flex justify-content-center
            {{ $playoffs[8]->game->first_rounds > $playoffs[8]->game->second_rounds ? "winner" : ($playoffs[8]->game->first_rounds < $playoffs[8]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[8]->game->first_rounds ? $playoffs[8]->game->first_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0 mt--1">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[8]->game->second_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[8]->game->second_team->name }}</div>
            <span class="bracket-score winner d-flex justify-content-center
            {{ $playoffs[8]->game->first_rounds < $playoffs[8]->game->second_rounds ? "winner" : ($playoffs[8]->game->first_rounds > $playoffs[8]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[8]->game->second_rounds ? $playoffs[8]->game->second_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>  
      </div>
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[9]->game->first_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[9]->game->first_team->name }}</div>
            <span class="bracket-score d-flex justify-content-center
            {{ $playoffs[9]->game->first_rounds > $playoffs[9]->game->second_rounds ? "winner" : ($playoffs[9]->game->first_rounds < $playoffs[9]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[9]->game->first_rounds ? $playoffs[9]->game->first_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0 mt--1">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[9]->game->second_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[9]->game->second_team->name }}</div>
            <span class="bracket-score winner d-flex justify-content-center
            {{ $playoffs[9]->game->first_rounds < $playoffs[9]->game->second_rounds ? "winner" : ($playoffs[9]->game->first_rounds > $playoffs[9]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[9]->game->second_rounds ? $playoffs[9]->game->second_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row">
        <div class="col-md-12">Segunda etapa lower bracket</div>
      </div>
    </div>
    <div class="col-md-2" style="margin-top: 12rem;">
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[10]->game->first_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[10]->game->first_team->name }}</div>
            <span class="bracket-score d-flex justify-content-center
            {{ $playoffs[10]->game->first_rounds > $playoffs[10]->game->second_rounds ? "winner" : ($playoffs[10]->game->first_rounds < $playoffs[10]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[10]->game->first_rounds ? $playoffs[10]->game->first_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0 mt--1">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[10]->game->second_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[10]->game->second_team->name }}</div>
            <span class="bracket-score winner d-flex justify-content-center
            {{ $playoffs[10]->game->first_rounds < $playoffs[10]->game->second_rounds ? "winner" : ($playoffs[10]->game->first_rounds > $playoffs[10]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[10]->game->second_rounds ? $playoffs[10]->game->second_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row">
        <div class="col-md-12">Final upper bracket</div>
      </div>
      <div class="row p-2" style="margin-top: 17.5rem;">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[11]->game->first_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[11]->game->first_team->name }}</div>
            <span class="bracket-score d-flex justify-content-center
            {{ $playoffs[11]->game->first_rounds > $playoffs[11]->game->second_rounds ? "winner" : ($playoffs[11]->game->first_rounds < $playoffs[11]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[11]->game->first_rounds ? $playoffs[11]->game->first_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0 mt--1">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[11]->game->second_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[11]->game->second_team->name }}</div>
            <span class="bracket-score winner d-flex justify-content-center
            {{ $playoffs[11]->game->first_rounds < $playoffs[11]->game->second_rounds ? "winner" : ($playoffs[11]->game->first_rounds > $playoffs[11]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[11]->game->second_rounds ? $playoffs[11]->game->second_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row">
        <div class="col-md-12">Final lower bracket</div>
      </div>
    </div>
    <div class="col-md-2" style="margin-top: 34rem;">
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[12]->game->first_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[12]->game->first_team->name }}</div>
            <span class="bracket-score d-flex justify-content-center
            {{ $playoffs[12]->game->first_rounds > $playoffs[12]->game->second_rounds ? "winner" : ($playoffs[12]->game->first_rounds < $playoffs[12]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[12]->game->first_rounds ? $playoffs[12]->game->first_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0 mt--1">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[12]->game->second_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[12]->game->second_team->name }}</div>
            <span class="bracket-score winner d-flex justify-content-center
            {{ $playoffs[12]->game->first_rounds < $playoffs[12]->game->second_rounds ? "winner" : ($playoffs[12]->game->first_rounds > $playoffs[12]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[12]->game->second_rounds ? $playoffs[12]->game->second_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row">
        <div class="col-md-12">Final de consolidación</div>
      </div>
    </div>
    <div class="col-md-2" style="margin-top: 20rem;">
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[13]->game->first_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[13]->game->first_team->name }}</div>
            <span class="bracket-score d-flex justify-content-center
            {{ $playoffs[13]->game->first_rounds > $playoffs[13]->game->second_rounds ? "winner" : ($playoffs[13]->game->first_rounds < $playoffs[13]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[13]->game->first_rounds ? $playoffs[13]->game->first_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#edit"
      data-bs-id="{{ $playoffs[0]->game->id }}" data-bs-season_id="{{ $playoffs[0]->game->season_id }}" data-bs-first_team_id="{{ $playoffs[0]->game->first_team_id }}" data-bs-second_team_id="{{ $playoffs[0]->game->second_team_id }}" data-bs-first_rounds="{{ $playoffs[0]->game->first_rounds }}" data-bs-second_rounds="{{ $playoffs[0]->game->second_rounds }}" data-bs-type="{{ $playoffs[0]->game->type }}" data-bs-date="{{ $playoffs[0]->game->date }}" data-bs-phase="{{ $playoffs[0]->game->phase }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0 mt--1">
          <div class="bracket-team white p-0">
            <img class="bracket-logo" src="{{ asset('images/teams/'.$playoffs[13]->game->second_team->logo) }}"><div class="d-none d-sm-inline">{{ $playoffs[13]->game->second_team->name }}</div>
            <span class="bracket-score winner d-flex justify-content-center
            {{ $playoffs[13]->game->first_rounds < $playoffs[13]->game->second_rounds ? "winner" : ($playoffs[13]->game->first_rounds > $playoffs[13]->game->second_rounds ? "losser" : "any") }}">
              {{ $playoffs[13]->game->second_rounds ? $playoffs[13]->game->second_rounds : "-" }}
            </span>
          </div>
        </div>
        </a>
      </div>
      <div class="row">
        <div class="col-md-12">Final del campeonato</div>
      </div>
    </div>
    <div class="col-md-2" style="margin-top: 22rem;">
      <div class="row p-2">
        <a type="button" data-bs-toggle="modal" data-bs-target="#season"
      data-bs-winner="{{ $season->winner }}" data-bs-id="{{ $playoffs[0]->season_id }}" class="p-0 m-0 fs-16 text-decoration-none">
        <div class="col-md-12 col-12 p-0">
          <div class="bracket-team white p-0">
            <div class="bracket-score d-flex" style="float: left;">
              <span class="material-icons" style="color: #DAA520;font-size: 30px;">emoji_events</span>
              <p class="mb-0" style="font-size: 20px;">{{ $season->winner }}</p>
            </div>
          </div>
        </div>
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Button modal -->
<button type="button" class="btn btn-danger btn-create" onclick="deletePlayoffs()" type="button">
  <span class="material-icons">delete</span>
</button>

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
        <input type="hidden"  class="form-control" name="season_id" id="season_id">
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

<!-- Modal edit season winner -->
<div class="modal fade" id="season" tabindex="-1" aria-labelledby="season" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar ganador</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {{ Form::open(array('url' => 'admin/season_winner', 'method' => 'POST', 'files'=> true)) }}
        <input type="hidden"  class="form-control" name="id" id="id">
        <div class="mb-3">
          <label for="winner" class="form-label">Nombre del equipo ganador</label>
          <input type="text"  class="form-control" name="winner" id="winner">
        </div>
      </div>
      <div class="modal-footer">
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

  var season = document.getElementById('season')
  season.addEventListener('show.bs.modal', function (event) {
      // Button that triggered the modal
      var button = event.relatedTarget
      // Extract info from data-bs-* attributes
      var bsid = button.getAttribute('data-bs-id')
      var bswinner = button.getAttribute('data-bs-winner')

      // Update the modal's content.
      var modalId = season.querySelector('.modal-body #id')
      var modalWinner = season.querySelector('.modal-body #winner')

      modalId.value = bsid
      modalWinner.value = bswinner
  })

  window.deleteConfirm = function()
  {
      var formId = $('.modal-body #id').val()

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

  window.deletePlayoffs = function()
  {
      var formId = {{ $playoffs[0]->season_id }}

      Swal.fire({
          icon: 'warning',
          text: '¿Estás seguro que querés eliminar estas eliminatorias?',
          confirmButtonText: 'Eliminar',
          confirmButtonColor: '#e3342f',
      }).then((result) => {
          if (result.isConfirmed) {
              window.location="{{ url('/admin/delete_playoffs')}}/" + formId;
          }
      });
  }
</script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection