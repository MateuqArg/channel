@extends('includes.app')
@section('content')
@include('includes.navbar')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 p-5">
			<div class="row">
				<div class="col-md-12 d-flex justify-content-center">
					<h1 class="white">Ultimas <span style="color: #ff9900"> noticias</span></h1>
				</div>
			</div>
			<div class="row">
				@forelse($articles as $article)
					<div class="col-md-4">
						<a href="{{ url('articles/'.$article->slug) }}" class="text-decoration-none">
							<img src="{{ asset('images/articles/'.$article->image) }}" class="w-100">
							<p class="mb-0 text-muted">{{ $article->type }}</p>
							<h4 class="white">{{ $article->title }}</h4>
						</a>
					</div>
				@empty
					<h4 class="white text-center p-5">Todavía no hay ninguna noticia, vuelve más tarde</h4>
				@endforelse
			</div>
		</div>
	</div>
</div>

@include('includes.footer')
@endsection