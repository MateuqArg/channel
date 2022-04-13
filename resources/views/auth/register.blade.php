@extends('includes.auth.app')
@section('content')
    <main class="form-signin">
      <form method="POST" action="{{ route('register') }}">
        @csrf

        <img class="mb-4" src="https://getbootstrap.com/docs/5.1/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div class="form-floating mb-2">
          <input type="name" class="form-control" name="name" id="name" :value="old('name')" required autofocus>
          <label for="name">Nombre</label>
        </div>

        <div class="form-floating mb-2">
          <input type="email" class="form-control" name="email" id="email" :value="old('email')" required>
          <label for="email">Email</label>
        </div>

        <div class="form-floating mb-2">
          <input type="number" class="form-control" name="phone" id="phone" :value="old('phone')" required>
          <label for="phone">Teléfono</label>
        </div>

        <div class="form-floating mb-2">
          <input type="password" class="form-control" name="password" id="password" required autocomplete="new-password">
          <label for="password">Contraseña</label>
        </div>

        <div class="form-floating mb-2">
          <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
          <label for="password_confirmation">Confirmar contraseña</label>
        </div>

        <div class="mb-3">
          <a href="{{ route('login') }}">¿Ya estás registrado?</a>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Crear cuenta</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2022 ChannelTalks</p>
        </form>
    </main>
@endsection