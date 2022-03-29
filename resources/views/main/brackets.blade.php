@extends('includes.app')
@section('content')
@include('includes.navbar')
<div style="background-color: #C9C9C9">
@if($setting->current_phase == 'playoffs')
	@include('includes.playoffs')
	@include('includes.groups')
@else
	@include('includes.groups')
	@include('includes.playoffs')
@endif
<div class="container-fluid">
	@include('includes.schedule')
</div>
</div>

<footer class="footer">
	<div class="container">
		<div class="col-md-12">
			<p class="m-0">© 2021 Ignis Gaming - Todos los derechos reservados</p>
		</div>
	</div>
</footer>
@endsection