<!DOCTYPE html>
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex" />
    <meta name="googlebot" content="noindex" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
    <meta name="theme-color" content="#050D1D">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />

    <link href="/assets2/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="/assets2/js/loader.js"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets2/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="/plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="/assets2/css/widgets/modules-widgets.css">
    <link rel="stylesheet" href="/plugins/font-icons/fontawesome/css/regular.css">
    <link rel="stylesheet" href="/plugins/font-icons/fontawesome/css/fontawesome.css">
    <link href="/assets2/css/elements/avatar.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    @yield('styles')
    <style>

    </style>
</head>
<body>
<!-- BEGIN LOADER -->
<div id="load_screen">
    <div class="loader">
        <div class="loader-content">
            <div class="spinner-grow align-self-center"></div>
        </div>
    </div>
</div>
<!--  END LOADER -->

<!--  BEGIN NAVBAR  -->
<div class="header-container fixed-top">
    <header class="header navbar navbar-expand-sm">

        <ul class="navbar-item theme-brand flex-row  text-center">
            <li class="nav-item theme-logo">
                <a href="/admin">
                    <img src="/imagem/logo/logo_icon.png" class="navbar-logo" alt="logo">
                </a>
            </li>
            <li class="nav-item theme-text">
                <a href="/admin" class="nav-link text-uppercase font-weight-light"> {{ config('app.name', 'Laravel') }} </a>
            </li>
        </ul>

        <ul class="navbar-item flex-row ml-md-auto">
            <?php $notifications = \App\Models\Notification::select('title','description')->where(['user_id'=>Auth::id(), 'readed'=>'0'])->orderBy('id','desc')->get(); ?>
            <li class="nav-item dropdown notification-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    @if(count($notifications) > 0)
                        <span class="badge badge-danger"></span>
                    @endif
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
                    <div class="notification-scroll">
                        @foreach($notifications as $n)
                            <div class="dropdown-item">
                                <div class="media">
                                    <i data-feather="alert-circle"></i>
                                    <div class="media-body">
                                        <div class="notification-para"><span class="user-name">{{$n->title}}</span> {{$n->description}}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown user-profile-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <div class="avatar" style="width: 2.5rem;height: 2.5rem;">
                        <span class="avatar-title rounded-circle font-weight-bold" style="background-color: #78c60a;">{{ Auth::user()->getNameInitials() }}</span>
                    </div>
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                    <div class="">
                        <div class="dropdown-item"><a href="/perfil"><i data-feather="user"></i> Perfil</a></div>
                        <div class="dropdown-item"><a href="{{route('dashboard.validacaoDocumentos')}}"><i data-feather="file-text"></i> Documentação</a></div>
                        <div class="dropdown-item"><a href="/2fa"><i data-feather="lock"></i> 2FA</a></div>
                        <div class="dropdown-item"><a href="{{route('dashboard.arquivos.index')}}"><i data-feather="download"></i> Arquivos</a></div>
                        <div class="dropdown-item">
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i data-feather="log-out"></i> Sair
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </header>
</div>
<!--  END NAVBAR  -->

<!--  BEGIN NAVBAR  -->
<div class="sub-header-container">
    <header class="header navbar navbar-expand-sm">
        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>

        <ul class="navbar-nav flex-row">
            <li>
                <div class="page-header">
                    <nav class="breadcrumb-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                </div>
            </li>
        </ul>
    </header>
</div>
<!--  END NAVBAR  -->

<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">

    <div class="overlay"></div>
    <div class="search-overlay"></div>

    <!--  BEGIN SIDEBAR  -->
    <div class="sidebar-wrapper sidebar-theme">
        <nav id="sidebar">
            <ul class="list-unstyled menu-categories" id="accordionExample">

                <li class="menu">
                    <a @if(request()->routeIs('admin.index')) data-active="true" aria-expanded="true" @else aria-expanded="false" @endif class="dropdown-toggle" href="{{route('admin.index')}}">
                        <div>
                            <i data-feather="home"></i>
                            <span>Inicio</span>
                        </div>
                    </a>
                </li>
                <?php $pagCount = \App\Models\Comprovante::where('status','0')->count();?>
                <li class="menu @if($pagCount > 0) active @endif">
                    <a href="#pagamentos" data-toggle="collapse" @if(request()->routeIs('admin.pagamentos.*')) data-active="true" aria-expanded="true" @else aria-expanded="false" @endif class="dropdown-toggle">
                        <div><i data-feather="book"></i> <span>Pagamentos @if($pagCount != '0') ({{$pagCount}}) @endif</span></div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{request()->routeIs('admin.pagamentos.*') ? 'show':''}}" id="pagamentos" data-parent="#accordionExample">
                        <li class="{{request()->routeIs('admin.pagamentos.index') ? 'active':''}}"><a href="{{route('admin.pagamentos.index')}}">Todos</a></li>
{{--                        <li class="{{request()->routeIs('admin.pagamentos.comprovantes') ? 'active':''}}"><a href="{{route('admin.pagamentos.comprovantes')}}">Comprovantes @if($pagCount != '0') ({{$pagCount}}) @endif</a></li>--}}
                        <li class="{{request()->routeIs('admin.pagamentos.pendentes') ? 'active':''}}"><a href="{{route('admin.pagamentos.pendentes')}}">Pgto. Pendentes</a></li>
                        <li class="{{request()->routeIs('admin.pagamentos.ativos') ? 'active':''}}"><a href="{{route('admin.pagamentos.ativos')}}">Pgto. Concluídos</a></li>
                    </ul>
                </li>
                <?php $docCount = \App\Models\ImgDocumento::where('status','0')->count();?>
                <li class="menu @if($docCount > 0) active @endif">
                    <a href="#documentos" data-toggle="collapse" @if(request()->routeIs('admin.documentos.*')) data-active="true" aria-expanded="true" @else aria-expanded="false" @endif class="dropdown-toggle">
                        <div>
                            <i data-feather="file-text"></i>
                            <span>Documentos @if($docCount != '0') ({{$docCount}}) @endif</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{request()->routeIs('admin.documentos.*')?'show':''}}" id="documentos" data-parent="#accordionExample">
                        <li class="{{request()->routeIs('admin.documentos.index') ? 'active':''}}"><a href="{{route('admin.documentos.index')}}">Pendentes</a></li>
                        <li class="{{request()->routeIs('admin.documentos.verificados') ? 'active':''}}"><a href="{{route('admin.documentos.verificados')}}">Verificado</a></li>
                    </ul>
                </li>
                <li class="menu">
                    <a href="#saques" class="dropdown-toggle" data-toggle="collapse" @if(request()->routeIs('admin.saques.*')) data-active="true" aria-expanded="true" @else aria-expanded="false" @endif>
                        <div>
                            <i data-feather="dollar-sign"></i>
                            <span>Saques</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{request()->routeIs('admin.saques.*')?'show':''}}" id="saques" data-parent="#accordionExample">
                        <li class="{{request()->routeIs('admin.saques.index') ? 'active':''}}"><a href="{{route('admin.saques.index')}}">Pendentes</a></li>
                        <li class="{{request()->routeIs('admin.saques.aprovados') ? 'active':''}}"><a href="{{route('admin.saques.aprovados')}}">Aprovados</a></li>
                    </ul>
                </li>
                <li class="menu">
                    <a @if(request()->routeIs('admin.financeiros.index')) data-active="true" aria-expanded="true" @else aria-expanded="false" @endif class="dropdown-toggle" href="{{route('admin.financeiros.index')}}">
                        <div><i data-feather="pie-chart"></i><span>Financeiro</span></div>
                    </a>
                </li>
{{--                <li class="menu">--}}
{{--                    <a @if(request()->routeIs('admin.cursos.*')) data-active="true" aria-expanded="true" @else aria-expanded="false" @endif class="dropdown-toggle" href="{{route('admin.cursos.index')}}">--}}
{{--                        <div><i data-feather="pie-chart"></i><span>Cursos</span></div>--}}
{{--                    </a>--}}
{{--                </li>--}}
                <li class="menu">
                    <a @if(request()->routeIs('admin.clubecerto.*')) data-active="true" aria-expanded="true" @else aria-expanded="false" @endif class="dropdown-toggle" href="{{route('admin.clubecerto.index')}}">
                        <div><i data-feather="award"></i><span>Clube Certo</span></div>
                    </a>
                </li>
                <li class="menu">
                    <a href="#usuarios" class="dropdown-toggle" data-toggle="collapse" @if(request()->routeIs('admin.users.*')) data-active="true" aria-expanded="true" @else aria-expanded="false" @endif>
                        <div>
                            <i data-feather="users"></i>
                            <span>Usuários</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{request()->routeIs('admin.users.*')?'show':''}}" id="usuarios" data-parent="#accordionExample">
                        <li class="{{request()->routeIs('admin.users.index') ? 'active':''}}"><a href="{{route('admin.users.index')}}">Todos</a></li>
{{--                        <li class="{{request()->routeIs('admin.users.create') ? 'active':''}}"><a href="{{route('admin.users.create')}}">Add Usuário</a></li>--}}
                    </ul>
                </li>

                <?php $tickets = \App\Models\Ticket::where('status','0')->count(); ?>
                <li class="menu">
                    <a @if(request()->routeIs('admin.adminTickets')) data-active="true" aria-expanded="true" @else aria-expanded="false" @endif class="dropdown-toggle" href="{{route('admin.adminTickets')}}">
                        <div><i class="fa fa-headphones"></i><span>Suporte @if($tickets > 0) ({{$tickets}}) @endif</span></div>
                    </a>
                </li>

                <li class="menu">
                    <a href="#configuracoes" class="dropdown-toggle" data-toggle="collapse" @if(request()->routeIs('admin.faqs.index') ||
                                                                                            request()->routeIs('admin.configuracoes.sistema.index') ||
                                                                                            request()->routeIs('admin.arquivos.index'))
                        data-active="true" aria-expanded="true" @else aria-expanded="false" @endif>
                        <div>
                            <i data-feather="settings"></i>
                            <span>Configurações</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{request()->routeIs('admin.faqs.index') ||
                                                                request()->routeIs('admin.carteiras.*') ||
                                                                request()->routeIs('admin.configuracoes.sistema.index') ||
                                                                request()->routeIs('admin.arquivos.index') ?'show':''}}" id="configuracoes" data-parent="#accordionExample">
                        <li class="{{request()->routeIs('admin.faqs.index') ? 'active':''}}"><a href="{{route('admin.faqs.index')}}">Faqs</a></li>
                        <li class="{{request()->routeIs('admin.configuracoes.sistema.index') ? 'active':''}}"><a href="{{route('admin.configuracoes.sistema.index')}}">Sistema</a></li>
                        <li class="{{request()->routeIs('admin.arquivos.index') ? 'active':''}}"><a href="{{route('admin.arquivos.index')}}">Arquivos</a></li>
                    </ul>
                </li>
                <li class="menu"><a @if(request()->routeIs('home')) data-active="true" aria-expanded="true" @else aria-expanded="false" @endif class="dropdown-toggle" href="{{route('home')}}">DASHBOARD</a></li>
            </ul>
        </nav>
    </div>
    <!--  END SIDEBAR  -->

    <!--  BEGIN CONTENT PART  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            @yield('content')
        </div>
        <div class="footer-wrapper pt-3">
            <div class="footer-section f-section-1">
                <p class="">Copyright © 2021 - {{date('Y')}} <a target="_blank" href="{{url('/')}}">{{ config('app.name', 'Laravel') }}</a>, All rights reserved.</p>
            </div>
            <div class="footer-section f-section-2">
                <p class="">Frase...</p>
            </div>
        </div>
    </div>
    <!--  END CONTENT PART  -->

</div>
<!-- END MAIN CONTAINER -->

<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="/assets2/js/libs/jquery-3.1.1.min.js"></script>
<script src="/bootstrap/js/popper.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script defer src="/js/all.js"></script>
<script src="/assets2/js/app.js"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="/assets2/js/custom.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
<script src="/plugins/font-icons/feather/feather.min.js"></script>
<script type="text/javascript">
    feather.replace();
</script>
@stack('js')
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
</body>
</html>
