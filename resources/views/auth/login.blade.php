@extends('includes.auth.app')
@section('content')
    <main class="form-signin">
      <form method="POST" action="{{ route('login') }}">
        @csrf

        <img class="mb-4" src="{{ asset('images/logo.png') }}" alt="" width="72" height="57">
        {{-- <h1 class="h3 mb-3 fw-normal">Please sign in</h1> --}}

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div class="form-floating">
          <input type="email" class="form-control" name="email" id="email" :value="old('email')" required autofocus>
          <label for="email">Email</label>
        </div>
        
        <div class="form-floating">
          <input type="password" class="form-control" name="password" id="password" required autocomplete="current-password">
          <label for="password">Contraseña</label>
        </div>

        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" id="remember_me" name="remember" value="remember"> Recordarme
          </label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Iniciar sesión</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2022 ChannelTalks</p>
      </form>
    </main>
@endsection