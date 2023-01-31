<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="{{url('/')}}" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,500,700,900" rel="stylesheet">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="/css/icomoon.css">
    <link rel="stylesheet" href="/css/style.css?v=1.3.5">
    <link rel="stylesheet" href="/css/custom.css?v=1.0">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel='shortcut icon' href='/imagem/logo.ico' type="image/x-icon" />
    <style>
        .probootstrap-navabr-dark .navbar-nav > .nav-item > .nav-link {padding-top: 5px; padding-bottom: 5px; padding-left: 0px; padding-right: 0px;}
    </style>
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark probootstrap-navabr-dark">
    <div class="container">
        <a class="navbar-brand"  @guest href="{{route('site.index')}}" @else href="{{route('home')}}" @endguest>
            <img src="/imagem/logo/logo.png" alt="" style="width: 70px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#probootstrap-nav" aria-controls="probootstrap-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="probootstrap-nav">
            @guest
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item"><a class="nav-link" href="/">Voltar ao site <span class="ion-chevron-right" style="font-size:14px;"></span></a></li>
                </ul>
            @else
                <ul class="navbar-nav ml-auto">
                    @if(Auth::user()->type === 'admin')
                        <li class="nav-item"><a class="nav-link" href="{{route('admin.index')}}">ADMIN</a></li>
                    @endif
                    <li class="nav-item probootstrap-seperator"><a class="nav-link" href="{{route('home')}}">Home</a></li>
                    <li class="nav-item probootstrap-seperator"><a class="nav-link" href="{{route('dashboard.produtos.index')}}">Produtos</a></li>
                    @if(Auth::user()->ativo != 0)
                        <li class="nav-item dropdown probootstrap-seperator">
                            <a href="#" class="nav-link dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Rede <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{route('dashboard.redes.diretos')}}">Diretos</a></li>
                                <li><a class="dropdown-item" href="{{route('dashboard.redes.pendentes')}}">Pendentes</a></li>
                            </ul>
                        </li>
                    @endif
                    <li class="nav-item dropdown probootstrap-seperator">
                        <a href="#" class="nav-link dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Financeiros <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{route('dashboard.pagamentosPendentes')}}">Pagamentos Pendentes</a></li>
                            @if(Auth::user()->ativo != 0)
                                <li><a class="dropdown-item" href="{{route('dashboard.financeiros.rendimentos.index')}}">Rendimentos</a></li>
                                <li><a class="dropdown-item" href="{{route('dashboard.financeiros.historicoTransacoes')}}">Hisórico de Saques</a></li>
                                <li><a class="dropdown-item" href="{{route('dashboard.financeiros.extratos')}}">Extratos</a></li>
                                <li><a class="dropdown-item" href="{{route('dashboard.saques')}}">Saques</a></li>
                                <li><a class="dropdown-item" href="{{route('dashboard.contaBancaria')}}">Conta Bancária</a></li>
                            @endif
                        </ul>
                    </li>

                    <li class="nav-item dropdown probootstrap-seperator">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}<span class="ion-chevron-down"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/perfil">Perfil</a></li>
                            @if(Auth::user()->ativo == 1)
                                <li><a class="dropdown-item" href="{{route('dashboard.conta_xm.index')}}">Conta XM</a></li>
                            @endif
                            <li><a class="dropdown-item" href="{{route('dashboard.conta_copy_trader.index')}}">Conta FBS</a></li>
                            <li><a class="dropdown-item" href="{{route('dashboard.validacaoDocumentos')}}">Documentacao</a></li>
                            <li><a class="dropdown-item" href="/2fa">2FA</a></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endguest
        </div>
    </div>
</nav>
    <section class="probootstrap-section">
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-8">
                    <h2 class="nh-title">Verifique seu endereço de e-mail</h2>
                    <div class="card bg-light">
                        <div class="card-body">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    <p>Um novo link de verificação foi enviado para seu endereço de e-mail.</p>
                                </div>
                            @endif

                            <p>Antes de continuar, verifique seu e-mail para obter um link de verificação.</p>
                            <p>Se você não recebeu o email,</p>
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="rq-btn rq-btn-transparent">{{ __('clique aqui para solicitar outro') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        .probootstrap-footer{margin-top: 120px;}
    </style>
    <footer class="probootstrap-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-lg mb-4 pt-4">
                            <h2 class="probootstrap-heading">
                                <a href="{{url('/')}}">{{ config('app.name', 'Laravel') }}</a>
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md text-left mb-4 pt-4">
                            <ul class="list-unstyled footer-small-nav">
                                <li><a href="#">Legal</a></li>
                                <li><a href="#">Privacy</a></li>
                                <li><a href="#">Cookies</a></li>
                                <li><a href="#">Terms</a></li>
                                <li><a href="#">About</a></li>
                            </ul>
                        </div>
                        <div class="col-md text-md-right text-left text-white mb-4 pt-4">
                            <p><small>&copy; {{ config('app.name', 'Laravel') }} {{date('Y')}}. All Rights Reserved.</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/main.js"></script>
    <script defer src="/js/all.js"></script>
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
    @stack('js')

</body>
</html>
