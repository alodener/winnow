<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<title>{{ config('app.name', 'Laravel') }}</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="" />
<meta name="keywords" content="TRX, TRON" />
<meta name="author" content="" />
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,500,700,900" rel="stylesheet">
<style>
    body{font-size: .9rem !important;}
</style>
<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/open-iconic-bootstrap.min.css">
<link rel="stylesheet" href="/css/icomoon.css">
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/css/custom.css">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel='shortcut icon' href='/imagem/logo.ico' type="image/x-icon" />
<style>
    .probootstrap-navabr-dark .navbar-nav > .nav-item > .nav-link {padding-top: 5px; padding-bottom: 5px; padding-left: 0px; padding-right: 0px;}
    #google_translate_element {display: none;}
    .goog-te-banner-frame {display: none !important;}
    body {position: static !important;top: 0 !important;}
    .form-control {height: 40px !important; }
    .breadcrumb {background-color: #ffc107 !important;}
    .breadcrumb-item.active {color: #111 !important;}
    ol.breadcrumb a {color: #6c6c6c;}
</style>
@yield('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark probootstrap-navabr-dark">
    <div class="container">
        <a class="navbar-brand" @guest href="{{route('site.index')}}" @else href="{{route('home')}}" @endguest>
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
                <li class="nav-item @if(Auth::user()->type === 'admin') probootstrap-seperator @endif"><a class="nav-link" href="{{route('home')}}">Home</a></li>
                <li class="nav-item probootstrap-seperator"><a class="nav-link" href="{{route('dashboard.produtos.index')}}">Investimentos</a></li>

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
                        Financeiro <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{route('dashboard.pagamentos.index')}}">Pagamentos</a></li>
                        @if(Auth::user()->ativo != 0)
                        <li><a class="dropdown-item" href="{{route('dashboard.financeiros.reinvestir.index')}}">Reinvestimentos</a></li>
                        <li><a class="dropdown-item" href="{{route('dashboard.financeiros.historicoTransacoes')}}">Histórico de Saques</a></li>
                        <li><a class="dropdown-item" href="{{route('dashboard.financeiros.extratos')}}">Extratos</a></li>
                        <li><a class="dropdown-item" href="{{route('dashboard.saques')}}">Saques</a></li>
                        <li><a class="dropdown-item" href="{{route('dashboard.contaBancaria')}}">Carteira</a></li>
                        @endif
                    </ul>
                </li>
                <li class="nav-item dropdown probootstrap-seperator">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}<span class="ion-chevron-down"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/perfil">Perfil</a></li>
                        <li><a class="dropdown-item" href="{{route('dashboard.validacaoDocumentos')}}">Documentação</a></li>
                        <li><a class="dropdown-item" href="{{route('clientTickets')}}">Suporte</a></li>
                        <li><a class="dropdown-item" href="/2fa">2FA</a></li>
                        <li><a class="dropdown-item" href="{{route('dashboard.arquivos.index')}}">Arquivos</a></li>
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
@yield('breadcrumb')
@yield('content')

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="/js/popper.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/main.js"></script>
<script defer src="/js/all.js"></script>
@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
{{--<script type="text/javascript">--}}
{{--    var comboGoogleTradutor = null; //Varialvel global--}}

{{--    function googleTranslateElementInit() {--}}
{{--        new google.translate.TranslateElement({--}}
{{--            pageLanguage: 'pt',--}}
{{--            includedLanguages: 'en,es,pt',--}}
{{--            layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL--}}
{{--        }, 'google_translate_element');--}}

{{--        comboGoogleTradutor = document.getElementById("google_translate_element").querySelector(".goog-te-combo");--}}
{{--    }--}}

{{--    function changeEvent(el) {--}}
{{--        if (el.fireEvent) {--}}
{{--            el.fireEvent('onchange');--}}
{{--        } else {--}}
{{--            var evObj = document.createEvent("HTMLEvents");--}}

{{--            evObj.initEvent("change", false, true);--}}
{{--            el.dispatchEvent(evObj);--}}
{{--        }--}}
{{--    }--}}

{{--    function trocarIdioma(sigla) {--}}
{{--        if (comboGoogleTradutor) {--}}
{{--            comboGoogleTradutor.value = sigla;--}}
{{--            changeEvent(comboGoogleTradutor);//Dispara a troca--}}
{{--            if(sigla == 'es'){--}}
{{--                document.getElementById("sigla").innerHTML = '<img src="{{asset('/imagem/flags/es.png')}}" style="width: 16px">';--}}
{{--            }else if(sigla == 'en'){--}}
{{--                document.getElementById("sigla").innerHTML = '<img src="{{asset('/imagem/flags/en.png')}}" style="width: 16px">'--}}
{{--            }else if(sigla == 'pt'){--}}
{{--                document.getElementById("sigla").innerHTML = '<img src="{{asset('/imagem/flags/brazil.png')}}" style="width: 16px">'--}}
{{--            }--}}
{{--        }--}}
{{--    }--}}
{{--</script>--}}
{{--<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>--}}
@stack('js')

</body>
</html>
