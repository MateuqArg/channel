@extends('includes.auth.app')
@section('content')
    <main class="form-signin mt-0 pt-0">
      <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <img class="mb-4" src="{{ asset('images/logow.png') }}" height="57">
        <img class="mb-2" src="{{ asset('images/persona.png') }}" height="150">

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <h4 class="text-light mb-4">Recuperar contraseña</h4>

        <div class="form-floating mb-4">
          <input type="email" class="form-control" name="email" id="email" :value="old('email')" required autofocus style="border-radius: 15px">
          <label for="email">Email</label>
        </div>

        <button class="px-auto py-3 btn btn-login text-light w-100" style="box-shadow: 0 0.5rem 1rem rgb(0 0 0 / 20%) !important;" type="submit"><h4 class="m-0">Enviar</h4></button>
      </form>
    </main>
@endsection