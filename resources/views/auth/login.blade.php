@extends('layouts.app')

@section('title', 'Connexion - B2B Platform')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h3 class="text-primary">B2B Platform</h3>
                        <p class="text-muted">Connectez-vous à votre compte</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse e-mail</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Se souvenir de moi
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Se connecter
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ route('password.request') }}" class="text-decoration-none">
                                Mot de passe oublié ?
                            </a>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <small class="text-muted">
                            Pas de compte ? Contactez votre grossiste pour créer un compte.
                        </small>
                    </div>
                </div>
            </div>

            <!-- Language switcher -->
            <div class="text-center mt-3">
                <div class="btn-group" role="group">
                    <a href="{{ route('set-locale', 'fr') }}"
                       class="btn btn-outline-secondary {{ app()->getLocale() === 'fr' ? 'active' : '' }}">
                        Français
                    </a>
                    <a href="{{ route('set-locale', 'ar') }}"
                       class="btn btn-outline-secondary {{ app()->getLocale() === 'ar' ? 'active' : '' }}">
                        العربية
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection