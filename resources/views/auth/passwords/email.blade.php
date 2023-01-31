@extends('layouts.app')

@section('content')
<section class="probootstrap-section">
    <div class="container">
        <div class="row mb-3 justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Recuperar Senha</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="input-group mb-3">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                       placeholder="Email" aria-label="Email" aria-describedby="button-addon2">
                                <button class="btn btn-outline-success" type="submit" id="button-addon2">Enviar link de redefinição de senha</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
