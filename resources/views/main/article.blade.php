@extends('includes.app')
@section('content')
@include('includes.navbar')
<div class="container-fluid">
	<div class="row" style="background-image: url(https://via.placeholder.com/1500x400/2C2C2C/2C2C2C);">
		<div class="col-md 2"></div>
		<div class="col-md-8 p-4">
			<img src="{{ asset('images/articles/'.$article->image) }}" class="w-100">
			<div class="p-2">
				<p class="mb-0 text-muted">{{ $article->date }}</p>
				<h4 class="white">{{ $article->title }}</h4>
				{!! html_entity_decode($article->body) !!}
			</div>
		</div>
		<div class="col-md-2"></div>
	</div>
</div>

@include('includes.footer')
@endsection