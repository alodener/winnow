@extends('layouts.app')

@section('content')
    <div class="rq-registration-content-single">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h2 class="nh-title">Seu Consultor é: {{$user->name}}</h2>
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('registerIndicacao') }}">
                        @csrf
                        <div class="form-group row">
                        	<input type="hidden" name="indicacao" value="{{$user->id}}">
                            <div class="col-md-6">
                                <input id="name" type="text" class="rq-form-control @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nome Completo">
                                <small>Como está escrito em seu documento</small>       
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="email" type="email" class="rq-form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!--<div class="form-group row">
                            <div class="col-md-6">
                                <input id="confirm-email" type="email" name="confirm-email" class="rq-form-control @error('email') is-invalid @enderror"
                                       required placeholder="Confirmar seu email">
                                
                            </div>
                        </div>-->
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="password" type="password" class="rq-form-control @error('password') is-invalid @enderror"
                                       name="password" required autocomplete="new-password" placeholder="Senha">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="rq-form-control"
                                       name="password_confirmation" required autocomplete="new-password" placeholder="Repita a Senha">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="rq-btn rq-btn-primary fluid border-radius">
                                    Cadastrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
@endsection
