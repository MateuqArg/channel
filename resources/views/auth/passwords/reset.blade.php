@extends('includes.auth.app')
@section('content')
    <main class="form-signin mt-0 pt-0">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <img class="mb-4" src="{{ asset('images/logow.png') }}" height="57">
            <img class="mb-2" src="{{ asset('images/persona.png') }}" height="150">

            <input type="hidden" name="token" value="{{ $token }}">

            <h4 class="text-light mb-4">Modificar contraseña</h4>

            <div class="form-floating mb-4">
                <input type="email" class="form-control" name="email" id="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus style="border-radius: 15px">
                <label for="email">Email</label>
            </div>

            <div class="form-floating mb-4">
                <input type="password" class="form-control" name="password" id="password" required autofocus style="border-radius: 15px">
                <label for="password">Nueva contraseña</label>
            </div>

            <div class="form-floating mb-4">
                <input type="password" class="form-control" name="password_confirmation" id="password-confirm" required autofocus style="border-radius: 15px">
                <label for="password">Nueva contraseña</label>
            </div>

            <button class="px-auto py-3 btn btn-login text-light w-100" style="box-shadow: 0 0.5rem 1rem rgb(0 0 0 / 20%) !important;" type="submit"><h4 class="m-0">Enviar</h4></button>
        </form>
    </main>
@endsection