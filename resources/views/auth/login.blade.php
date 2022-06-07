@extends('includes.auth.app')
@section('content')
    <main class="form-signin mt-0 pt-0">
      <img src="{{ asset('images/trama1.png') }}" style="position: absolute; height: 95%;">
      <img src="{{ asset('images/trama1.png') }}" style="position: absolute; left: 10px; height: 45%;">

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <img class="mb-4" src="{{ asset('images/logow.png') }}" height="57">
        <img class="mb-2" src="{{ asset('images/persona.png') }}" height="150">
        {{-- <h1 class="h3 mb-3 fw-normal">Please sign in</h1> --}}

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <h4 class="text-light mb-4">Ingresar en tu cuenta</h4>
        <p class="text-light">¿Olvidaste tu contraseña? <a class="text-light" href="{{ url('forgot-password') }}">Recuperala aqui</a></p>

        <div class="form-floating mb-4">
          <input type="email" class="form-control" name="email" id="email" :value="old('email')" required autofocus style="border-radius: 15px">
          <label for="email">Email</label>
        </div>
        
        <div class="form-floating mb-4">
          <input type="password" class="form-control" name="password" id="password" required autocomplete="current-password" style="border-radius: 15px">
          <label for="password">Contraseña</label>
        </div>

        <button class="px-auto py-3 btn btn-login text-light w-100" style="box-shadow: 0 0.5rem 1rem rgb(0 0 0 / 20%) !important;" type="submit"><h4 class="m-0">Entrar</h4></button>
        {{-- <button class="w-100 btn btn-lg btn-primary" type="submit">Iniciar sesión</button> --}}
      </form>
    </main>
@endsection