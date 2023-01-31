<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
    <meta name="theme-color" content="#050D1D">
    <meta name="description" content="a gestora de investimentos esportivos de maior desempenho do mercado nacional" />
    <meta name="keywords" content="TRX, TRON" />
    <meta name="author" content="" />

    <link href="/assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="/assets/js/loader.js"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="/plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="/assets/css/widgets/modules-widgets.css">
    <link rel="stylesheet" href="/plugins/font-icons/fontawesome/css/regular.css">
{{--    <link rel="stylesheet" href="/plugins/font-icons/fontawesome/css/fontawesome.css">--}}
    <link href="/assets/css/elements/avatar.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"/>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    @yield('styles')
    <style>
        body{background: #060e38!important;}
        #sidebar ul.menu-categories li.menu > .dropdown-toggle {color: #dee2e6;!important;}
        #sidebar ul.menu-categories li.menu > .dropdown-toggle svg {color: #dee2e6;!important;}
        #sidebar ul.menu-categories.ps { border-right: 1px solid #1a1c2d !important; }
        .card-gradient {
            background: rgb(0,0,0);
            background: linear-gradient(45deg, rgba(0,0,0,1) 12%, rgba(14,23,38,1) 64%);
        }
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
                <a href="{{route('home')}}">
                    <img src="/imagem/logo/RolloverFinal.png" class="navbar-logo" alt="logo">
                </a>
            </li>
            <li class="nav-item theme-text">
                <a href="{{route('home')}}" class="nav-link text-uppercase font-weight-light"> {{ config('app.name', 'Laravel') }} </a>
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
                @if(Auth::user()->type == 'admin')
                    <li class="menu">
                        <a href="/admin" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="settings" style="color: #e2a03f"></i>
                                <span style="color: #e2a03f">ADMINISTRAÇÃO</span>
                            </div>
                        </a>
                    </li>
                @endif
                <li class="menu">
                    <a href="{{route('home')}}" @if(request()->routeIs('home')) data-active="true" aria-expanded="true" @else aria-expanded="false" @endif class="dropdown-toggle">
                        <div class="">
                            <i data-feather="home"></i>
                            <span>Inicio</span>
                        </div>
                    </a>
                </li>
                <li class="menu">
                    <a href="{{route('dashboard.produtos.index')}}" @if(request()->routeIs('dashboard.produtos.index')) data-active="true" aria-expanded="true" @else aria-expanded="false" @endif class="dropdown-toggle">
                        <div><i data-feather="trending-up"></i> <span>Investimentos</span></div>
                    </a>
                </li>
                <li class="menu">
                    <a href="#rede" data-toggle="collapse" @if(request()->routeIs('dashboard.redes.diretos') || request()->routeIs('dashboard.redes.pendentes')) data-active="true" aria-expanded="true" @else aria-expanded="false" @endif class="dropdown-toggle">
                        <div><i data-feather="users"></i> <span>Afiliados</span></div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{request()->routeIs('dashboard.redes.diretos') || request()->routeIs('dashboard.redes.pendentes') ? 'show':''}}" id="rede" data-parent="#accordionExample">
                        <li class="{{request()->routeIs('dashboard.redes.diretos') ? 'active':''}}"><a href="{{route('dashboard.redes.diretos')}}">Diretos</a></li>
                        <li class="{{request()->routeIs('dashboard.redes.pendentes') ? 'active':''}}"><a href="{{route('dashboard.redes.pendentes')}}">Pendentes</a></li>
                    </ul>
                </li>
                <li class="menu">
                    <a href="#financeiros" data-toggle="collapse" @if(request()->routeIs('dashboard.financeiros.*') ||
                                                                          request()->routeIs('dashboard.pagamentos.index') ||
                                                                          request()->routeIs('dashboard.saques') ||
                                                                          request()->routeIs('dashboard.contaBancaria')
                                                                          ) data-active="true" aria-expanded="true" @else aria-expanded="false" @endif class="dropdown-toggle">
                        <div><i data-feather="dollar-sign"></i> <span>Financeiro</span></div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{request()->routeIs('dashboard.financeiros.*') ||
                                                                          request()->routeIs('dashboard.pagamentos.index') ||
                                                                          request()->routeIs('dashboard.saques') ||
                                                                          request()->routeIs('dashboard.contaBancaria') ? 'show':''}}" id="financeiros" data-parent="#accordionExample">
                        <li class="{{request()->routeIs('dashboard.pagamentos.index') ? 'active':''}}"><a href="{{route('dashboard.pagamentos.index')}}">Pagamentos</a></li>
                        @if(Auth::user()->ativo != 0)
                            <li class="{{request()->routeIs('dashboard.financeiros.reinvestir.index') ? 'active':''}}"><a href="{{route('dashboard.financeiros.reinvestir.index')}}">Reinvestimentos</a></li>
                            <li class="{{request()->routeIs('dashboard.financeiros.historicoTransacoes') ? 'active':''}}"><a href="{{route('dashboard.financeiros.historicoTransacoes')}}">Histórico de Saques</a></li>
                            <li class="{{request()->routeIs('dashboard.financeiros.extratos') ? 'active':''}}"><a href="{{route('dashboard.financeiros.extratos')}}">Extratos</a></li>
                            <li class="{{request()->routeIs('dashboard.saques') ? 'active':''}}"><a href="{{route('dashboard.saques')}}">Saques</a></li>
                            <li class="{{request()->routeIs('dashboard.contaBancaria') ? 'active':''}}"><a href="{{route('dashboard.contaBancaria')}}">Carteira</a></li>
                        @endif
                    </ul>
                </li>
                <li class="menu">
                    <a href="{{route('clientTickets')}}" @if(request()->routeIs('clientTickets')) data-active="true" aria-expanded="true" @else aria-expanded="false" @endif class="dropdown-toggle">
                        <div><i data-feather="tool"></i> <span>Suporte</span></div>
                    </a>
                </li>
{{--                <?php $links = \App\Models\Link::all('name','link')?>--}}
{{--                @if($links->count() > 0)--}}
{{--                    @foreach($links as $l)--}}
{{--                    <li class="menu">--}}
{{--                        <a href="{{$l->link}}" target="_blank" class="dropdown-toggle">--}}
{{--                            <div class="">--}}
{{--                                <i data-feather="target"></i>--}}
{{--                                <span>{{$l->name}}</span>--}}
{{--                            </div>--}}
{{--                            <div><i data-feather="external-link" style="width: 14px"></i></div>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    @endforeach--}}
{{--                @endif--}}
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
                <p class="">Copyright © {{date('Y')}} <a target="_blank" href="{{url('/')}}">{{ config('app.name', 'Laravel') }}</a>, All rights reserved.</p>
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
<script src="/assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="/bootstrap/js/popper.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/assets/js/app.js"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<script src="/assets/js/custom.js"></script>
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
