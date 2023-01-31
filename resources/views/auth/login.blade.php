@extends('site.base')
@section('content')
    <section class="position-relative h-100 pt-5 pb-4">
        <!-- Sign in form -->
        <div class="container d-flex flex-wrap justify-content-center h-100 pt-5">
            <div class="w-100 align-self-end pt-1 pt-md-4 pb-4" style="max-width: 526px;">
                <h1 class="text-center">Bem-vindo de volta</h1>
                <p class="text-center pb-3 mb-3">Não tem uma conta? <a href="/register">Cadastre-se aqui.</a></p>
                <form method="POST" action="{{route('login')}}" class="needs-validation mb-2">
                    @csrf
                    <div class="position-relative mb-3">
                        <label for="email" class="form-label fs-base">Login</label>
                        <input type="text" class="form-control form-control-lg @error('username') is-invalid @enderror" id="username" name="login" value="{{ old('username') }}"
                               placeholder="Login" required>
                        @error('username')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fs-base">Senha</label>
                        <div class="password-toggle">
                            <input type="password" id="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required>
                            <label class="password-toggle-btn" aria-label="Show/hide password">
                                <input class="password-toggle-check" type="checkbox">
                                <span class="password-toggle-indicator"></span>
                            </label>
                            <div class="invalid-feedback position-absolute start-0 top-100">Please enter your password!</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }} class="form-check-input">
                            <label for="remember" class="form-check-label fs-base">Continuar conectado</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary shadow-primary btn-lg w-100">Login</button>
                </form>
                @if (Route::has('password.request'))
                    <a class="btn btn-link btn-lg w-100" href="{{ route('password.request') }}">
                        Esqueceu sua Senha?
                    </a>
                @endif
                <hr class="my-4">
            </div>
        </div>
    </section>
@endsection
