@extends('layouts.base')
@section('title','Autenticação de Dois Fatores')
@section('breadcrumb')
   <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
   <li class="breadcrumb-item active">Autenticação de Dois Fatores</li>
@endsection
@section('content')

        <div class="row layout-top-spacing justify-content-center">
            <div class="col-lg-8">
                <h2 class="nh-title">Autenticação de Dois Fatores</h2>
                <div class="card ">
                    <div class="card-body">
                        <p>A autenticação de dois fatores (2FA) fortalece a segurança de acesso ao exigir dois métodos (também chamados de fatores)
                            para verificar sua identidade. A autenticação de dois fatores protege contra phishing, engenharia social e senha bruta
                            força ataques e protege seus logins de invasores que exploram credenciais fracas ou roubadas.</p>

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
{{--                        @if (session('success'))--}}
{{--                            <div class="alert alert-warning">--}}
{{--                                {{ session('success') }}--}}
{{--                            </div>--}}
{{--                        @endif--}}

                        @if($data['user']->loginSecurity == null)
                            <form class="form-horizontal" method="POST" action="{{ route('generate2faSecret') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <button type="submit" class="btn btn-warning">
                                        Gerar Chave Secreta para habilitar 2FA
                                    </button>
                                </div>
                            </form>
                        @elseif(!$data['user']->loginSecurity->google2fa_enable)
                            1. Leia este código QR com seu aplicativo Google Authenticator ou Authy. <br>
                            Como alternativa, você pode usar o código: <br>
                            <h3><code>{{ $data['secret'] }}</code></h3>
                            <!--<img src="{{$data['google2fa_url'] }}" alt="" style="width: 200px">-->
                            <div class="">
                                {!! $data['google2fa_url'] !!}
                            </div>
                            <br/>
                            2. Digite o PIN do aplicativo Google Authenticator:<br/><br/>
                            <form class="form-horizontal" method="POST" action="{{ route('enable2fa') }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('verify-code') ? ' has-error' : '' }}">
                                    <label for="secret" class="control-label">Código de Autenticador</label>
                                    <input id="secret" type="password" class="form-control col-md-4" name="secret" required  autocomplete="off">
                                    @if ($errors->has('verify-code'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('verify-code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-warning">
                                    Habilitar 2FA
                                </button>
                            </form>
                        @elseif($data['user']->loginSecurity->google2fa_enable)
                            <div class="alert alert-warning">
                                2FA está atualmente <strong>Ativado</strong> em sua conta.
                            </div>
                            <p>Se você deseja desativar a autenticação de dois fatores. Confirme sua senha e clique em Desativar botão 2FA.</p>
                            <form class="form-horizontal" method="POST" action="{{ route('disable2fa') }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                    <label for="change-password" class="control-label">Senha Atual</label>
                                    <input id="current-password" type="password" class="form-control col-md-4" name="current-password" required  autocomplete="off">
                                    @if ($errors->has('current-password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-warning ">Desabilitar 2FA</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
@endsection
