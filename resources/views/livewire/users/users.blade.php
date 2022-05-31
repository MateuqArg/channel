<div class="container-fluid" wire:init="loadUsers">
  <div class="row">
    <div class="col d-flex gradient top-table">
      <div>
        <input type="text" wire:model="search" class="form-control" placeholder="Buscar por id o eventos">
      </div>
      <div class="ms-auto">
        <button wire:click="download" class="btn btn-outline-primary download-btn"><i class="bi bi-download"></i> DESCARGAR</button>
      </div>
    </div>
  </div>
  <div class="row g-3">
    <table class="table">
      <thead class="gradient">
        <tr>
          @if(!\Auth::user()->hasRole('staff'))
          <th scope="col">Acciones</th>
          @endif
          <th scope="col">ID</th>
          <th scope="col">ID público</th>
          <th scope="col">Nombre</th>
          <th scope="col">Email</th>
          <th scope="col">Avatar</th>
          <th scope="col">Roles</th>
          <th scope="col">Eventos</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
        <tr>
          @if(!\Auth::user()->hasRole('staff'))
          <td>
            @include('livewire.users.actions', ['user' => $user])
          </td>
          @endif
          <td>{{ $user->id }}</td>
          <td>{{ $user->custid }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>@if($user->avatar <> null)
              <img src="{{ asset('/uploads/'.$user->avatar) }}" width="50" height="50" class="rounded-circle">
            @else
              <img src="{{ asset('/uploads/default.svg') }}" width="50" height="50" class="rounded-circle">
            @endif
          </td>
          <td>
            @foreach($user->getRoleNames() as $role)
              @if(strlen($role) <> 6)
              @if($role == 'organizer')
              organizador
              @elseif($role == 'exhibitor')
              expositor
              @elseif($role == 'inactive')
              inactivo
              @elseif($role == 'staff')
              staff
              @endif
              @endif
            @endforeach
          </td>
          <td>
            @foreach($user->getRoleNames() as $role)
              @if(strlen($role) == 6)
              {{ $role }}
              @endif
            @endforeach
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  @if(!\Auth::user()->hasRole('staff'))
  {{-- @include('livewire.user.create') --}}
  @endif
  
  {{-- @livewire('chats') --}}
</div>