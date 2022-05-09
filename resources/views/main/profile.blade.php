@extends('includes.app')
@section('content')
@if(\Auth::user()->hasRole('exhibitor'))
@include('includes.auth.exhibitornavbar')
@elseif(\Auth::user()->hasRole('organizer'))
@include('includes.auth.organizernavbar')
@endif
<div class="container">
    <div class="row row-cols-1 g-3 ms-5 me-5">
        <div class="col">
            @livewire('profiles')
        </div>
    </div>
</div>
@include('includes.footer')
@endsection