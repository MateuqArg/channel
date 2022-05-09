<div class="container-fluid">
  <div class="row g-3">
    <a href="{{ route('exhibitor.groups.all') }}" class="col-md-2 card p-2 mx-2 text-decoration-none">
        <p class="m-0">Todos</p>
        {{-- <div class=""><i class="bi bi-x-lg"></i></div> --}}
    </a>
    @foreach($groups as $group)
    <a href="{{ route('exhibitor.groups.show', ['id' => $group->id]) }}" class="col-md-2 card p-2 mx-2 text-decoration-none">
        <p class="m-0">{{ $group->title }}</p>
        {{-- <div class=""><i class="bi bi-x-lg"></i></div> --}}
    </a>
    @endforeach
  </div>

  @if(!\Auth::user()->hasRole('staff'))
  @include('livewire.groups.create')
  @endif
</div>