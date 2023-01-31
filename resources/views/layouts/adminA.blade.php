<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta name="robots" content="noindex" />
<meta name="googlebot" content="noindex" />
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
<title>@yield('title', config('app.name', 'Laravel'))</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="author" content="{{url('/')}}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<!--<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">-->
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,500,700,900" rel="stylesheet">
<style>
    body{font-size: .9rem !important;}
</style>
<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/open-iconic-bootstrap.min.css">
<link rel="stylesheet" href="/css/icomoon.css">
<link rel="stylesheet" href="/css/style.css?v=1.3.5">
<link rel="stylesheet" href="/css/custom.css?v=0.9">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <style>
        .probootstrap-navabr-dark .navbar-nav > .nav-item > .nav-link {padding-top: 5px; padding-bottom: 5px; padding-left: 0px; padding-right: 0px;}
        #google_translate_element {display: none;}
        .goog-te-banner-frame {display: none !important;}
        body {position: static !important;top: 0 !important;}
        .form-control {height: 40px !important; }
        .breadcrumb {background-color: #ffc107 !important;}
        .breadcrumb-item.active {color: #111 !important;}
    </style>
@yield('styles')
<link rel='shortcut icon' href='/imagem/logo.ico' type="image/x-icon" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark probootstrap-navabr-dark">
        <div class="container">
            <a class="navbar-brand"  @guest href="{{route('site.index')}}" @else href="{{route('admin.index')}}" @endguest>
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
                    <li class="nav-item"><a class="nav-link" href="{{route('admin.index')}}">Inicio</a></li>
                    <?php $pagCount = \App\Models\Comprovante::where('status','0')->count();?>
                    <li class="nav-item dropdown probootstrap-seperator @if($pagCount > 0) active @endif">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                                            aria-haspopup="true" aria-expanded="false">
                            Pagamentos @if($pagCount != '0') ({{$pagCount}}) @endif<span class="ion-chevron-down"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{route('admin.pagamentos.comprovantes')}}">Comprovantes @if($pagCount != '0') ({{$pagCount}}) @endif</a></li>
                            <li><a class="dropdown-item" href="{{route('admin.pagamentos.pendentes')}}">Pagamentos Pendentes</a></li>
                            <li><a class="dropdown-item" href="{{route('admin.pagamentos.ativos')}}">Pagamentos Concluídos</a></li>
                            <li><a class="dropdown-item" href="{{route('admin.financeiros.index')}}">Financeiro</a></li>
                          </ul>
                    </li>
                    <?php $docCount = \App\Models\ImgDocumento::where('status','0')->count();?>
                    <li class="nav-item dropdown probootstrap-seperator @if($docCount > 0) active @endif">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                                            aria-haspopup="true" aria-expanded="false">
                            Documentos @if($docCount != '0') ({{$docCount}}) @endif<span class="ion-chevron-down"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{route('admin.documentos.index')}}">Pendentes</a></li>
                            <li><a class="dropdown-item" href="{{route('admin.documentos.verificados')}}">Verificado</a></li>
                          </ul>
                    </li>
                    <li class="nav-item dropdown probootstrap-seperator">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                                            aria-haspopup="true" aria-expanded="false">
                            Saques <span class="ion-chevron-down"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{route('admin.saques.index')}}">Pendentes</a></li>
                            <li><a class="dropdown-item" href="{{route('admin.saques.aprovados')}}">Aprovados</a></li>
                          </ul>
                    </li>
{{--                    <li class="nav-item probootstrap-seperator"><a class="nav-link" href="{{route('admin.produtos.index')}}">Produtos</a></li>--}}
{{--                    <li class="nav-item probootstrap-seperator"><a class="nav-link" href="{{route('admin.users.index')}}">Usuários</a></li>--}}
                    <li class="nav-item dropdown probootstrap-seperator">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false">
                            Usuários <span class="ion-chevron-down"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{route('admin.users.index')}}">Todos</a></li>
                            <li><a class="dropdown-item" href="{{route('admin.users.pontos')}}">Pontuadores</a></li>
                        </ul>
                    </li>
                    <?php $tickets = \App\Models\Ticket::where('status','0')->count(); ?>
                    <li class="nav-item dropdown probootstrap-seperator">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false">
                            Configurações @if($tickets > 0) ({{$tickets}}) @endif <span class="ion-chevron-down"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{route('admin.rendimentos.index')}}">Rendimento</a></li>
                            <li><a class="dropdown-item" href="{{route('admin.rifas.index')}}">Rifas</a></li>
                            <li><a class="dropdown-item" href="{{route('admin.adminTickets')}}">Suporte @if($tickets > 0) ({{$tickets}}) @endif</a></li>
                            <li><a class="dropdown-item" href="{{route('admin.links.index')}}">Links</a></li>
                            <li><a class="dropdown-item" href="{{route('admin.faqs.index')}}">Faqs</a></li>
                            <li><a class="dropdown-item" href="{{route('admin.configuracoes.sistema.index')}}">Sistema</a></li>
                            <li><a class="dropdown-item" href="{{route('admin.arquivos.index')}}">Arquivos</a></li>
                        </ul>
                    </li>
                    <li class="nav-item probootstrap-seperator"><a class="nav-link" href="{{route('home')}}">DASHBOARD</a></li>
                </ul>
                @endguest
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
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
@stack('js')
</body>
</html>
