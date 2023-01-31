@extends('layouts.base')

@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active">Autenticação de Dois Fatores</li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')

        <div class="row layout-top-spacing justify-content-center">
            <div class="col-md-8 ">
                <h2 class="nh-title">Autenticação de Dois Fatores</h2>
                <div class="card bg-dark">
                    <div class="card-body">
                        <p>A Autenticação de Dois Datores (2FA) fortalece a segurança de acesso ao exigir dois métodos (também chamados de fatores)
                            para verificar sua identidade. A autenticação de dois fatores protege contra phishing, engenharia social e senha
                            ataques de força bruta e protegem seus logins de invasores que exploram credenciais fracas ou roubadas.</p>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        Digite o PIN do aplicativo Google Authenticator ou Authy:<br/><br/>
                        <form class="form-horizontal" action="{{ route('2faVerify') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('one_time_password-code') ? ' has-error' : '' }}">
                                <label for="one_time_password" class="control-label">TOKEN</label>
                                <input id="one_time_password" name="one_time_password" class="form-control col-md-4"  type="text" required autocomplete="off" />
                            </div>
                            <button class="btn btn-primary" type="submit">Autenticar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection
