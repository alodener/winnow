<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />

    <!-- Favicon and Touch Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/imagem/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/imagem/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/imagem/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicon/site.webmanifest">
    <link rel="mask-icon" href="/imagem/favicon/safari-pinned-tab.svg" color="#6366f1">
    <link rel="shortcut icon" href="/imagem/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#080032">
    <meta name="msapplication-config" content="/assets/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <!-- Vendor Styles -->
    <link rel="stylesheet" media="screen" href="/assets/vendor/boxicons/css/boxicons.min.css"/>
    <link rel="stylesheet" media="screen" href="/assets/vendor/swiper/swiper-bundle.min.css"/>

    <!-- Main Theme Styles + Bootstrap -->
    <link rel="stylesheet" media="screen" href="/assets/css/theme.min.css">
    @yield('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <main class="page-wrapper">
        <header class="header navbar navbar-expand-lg navbar-light {{(Request::path()=='login' || Request::path()=='register')?'position-absolute':'bg-light'}} navbar-sticky">
            <div class="container px-3">
                <a href="/" class="navbar-brand pe-3">
                    <img src="/imagem/logo/logo_icon.png" width="47" alt="Silicon">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <div id="navbarNav" class="offcanvas offcanvas-end">
                    <div class="offcanvas-header border-bottom">
                        <h5 class="offcanvas-title">Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            @guest()
                                <li class="nav-item">
                                    <a href="/" class="nav-link">Inicio</a>
                                </li>
                            @else
                                <div class="dropdown order-lg-3 ms-4">
                                    <a href="#" class="d-flex nav-link p-0" data-bs-toggle="dropdown">
                                        <img src="/imagem/logo/logo_icon.png" class="rounded-circle" width="48" alt="Avatar">
                                        <div class="d-none d-sm-block ps-2">
                                            <div class="fs-xs lh-1 opacity-60">Olá,</div>
                                            <div class="fs-sm dropdown-toggle">{{Auth::user()->name}}</div>
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end my-1" style="width: 14rem;">
                                        <li>
                                            <a href="{{route('dashboard.perfil.index')}}" class="dropdown-item d-flex align-items-center">
                                                <i class="bx bx-user-circle fs-base opacity-60 me-2"></i>
                                                Perfil
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('dashboard.pagamentos.index')}}" class="dropdown-item d-flex align-items-center">
                                                    <?php $pagamentoCount = \App\Models\Pagamento::where(['user_id'=>auth()->id(),'status'=>'0'])->count();?>
                                                <i class="bx bx-shopping-bag fs-base opacity-60 me-2"></i>
                                                Pagamentos
                                                @if($pagamentoCount > 0)
                                                    <span class="bg-warning rounded-circle mt-n2 ms-1" style="width: 5px; height: 5px;"></span>
                                                    <span class="ms-auto fs-xs text-muted">{{$pagamentoCount}}</span>
                                                @endif
                                            </a>
                                        </li>
                                            <?php
                                            $indicacao_direta = \App\Models\Financeiro::where(['user_id'=>Auth::id(),'tipo_bonus'=>'indicacao_direta'])->sum('valor');
                                            $indicacao_indireta = \App\Models\Financeiro::where(['user_id'=>Auth::id(),'tipo_bonus'=>'indicacao_indireta'])->sum('valor');
                                            $total = $indicacao_direta+$indicacao_indireta;
                                            $config = \App\Models\Configuracao::first();
                                            ?>
                                        <li>
                                            <a href="{{route('dashboard.financeiros.extratos')}}" class="dropdown-item d-flex align-items-center">
                                                <i class="bx bx-dollar fs-base opacity-60 me-2"></i>
                                                Ganhos
                                                <span class="ms-auto fs-xs text-muted">R$ {{number_format($total,2,',','.')}}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('dashboard.saques')}}" class="dropdown-item d-flex align-items-center">
                                                <i class='bx bx-money-withdraw fs-base opacity-60 me-2'></i>
                                                Saques
                                                <span class="ms-auto fs-xs {{auth()->user()->wallet[0]->saldo >= $config->limite_saque ?"text-success":"text-muted"}}">R$ {{number_format(auth()->user()->wallet[0]->saldo,2,',','.')}}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('dashboard.contaBancaria')}}" class="dropdown-item d-flex align-items-center">
                                                <i class="bx bx-wallet fs-base opacity-60 me-2"></i>
                                                Carteira
                                                <span class="ms-auto fs-xs text-muted"></span>
                                            </a>
                                        </li>
                                            <?php $notifications = \App\Models\Notification::select('title','description')->where(['user_id'=>Auth::id(), 'readed'=>'0'])->orderBy('id','desc')->get(); ?>
                                        <li>
                                            <a href="#" class="dropdown-item d-flex align-items-center">
                                                <i class="bx bx-chat fs-base opacity-60 me-2"></i>
                                                Notificações
                                                @if(count($notifications) > 0)
                                                    <span class="bg-success rounded-circle mt-n2 ms-1" style="width: 5px; height: 5px;"></span>
                                                    <span class="ms-auto fs-xs text-muted">{{count($notifications)}}</span>
                                                @endif
                                            </a>
                                        </li>
                                            <?php
                                            $countUsers = \App\Models\User::count();
                                            $matriz = array(Auth::user()->username);
                                            for($a=0;$a<=$countUsers;$a++){
                                                //echo $matriz[$a]. "<br/>";
                                                if(empty($matriz[$a])){
                                                    break;
                                                }else{
                                                    $users = \App\Models\User::select('username','indicacao')->where('indicacao',$matriz[$a])->get();
                                                    foreach ($users as $user){
                                                        //echo $user. "<br/>";
                                                        array_push($matriz,$user->username);
                                                    }
                                                }
                                            }
                                            //return $matriz;
                                            $containdiretos = count($matriz);
                                            $indiretosCoun = $containdiretos - 1;
                                            ?>
                                        <li>
                                            <a href="{{route('dashboard.redes.diretos')}}" class="dropdown-item d-flex align-items-center">
                                                <i class="bx bx-group fs-base opacity-60 me-2"></i>
                                                Afiliados
                                                <span class="ms-auto fs-xs text-muted">{{$indiretosCoun}}</span>
                                            </a>
                                        </li>
                                        <li class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="bx bx-log-out fs-base opacity-60 me-2"></i> Sair
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @endguest
                        </ul>
                        @guest


                            <a href="{{route('register')}}" class="btn btn-primary btn-sm fs-sm rounded my-3 my-lg-0">
                                <i class="bx bx-user fs-lg me-2"></i>
                                Cadastre-se
                            </a>
                            <a href="{{route('login')}}" class="btn btn-secondary btn-sm fs-sm rounded my-3 my-lg-0 ms-2">
                                <i class="bx bx-log-in fs-lg me-2"></i>
                                Entrar
                            </a>
                        @endguest
                    </div>
                </div>
                <button type="button" class="navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </header>
        @yield('content')
    </main>
    <footer class="footer pt-5 pb-4 pb-lg-5">
        <div class="container pt-lg-4">
            <div class="row pb-5">
                <div class="col-lg-4 col-md-6">
                    <div class="navbar-brand text-dark p-0 me-0 mb-3 mb-lg-4">
                        <img src="/imagem/logo/logo_icon.png" width="47" alt="{{ config('app.name', 'Laravel') }}">
                        {{ config('app.name', 'Laravel') }}
                    </div>
{{--                    <p class="fs-sm pb-lg-3 mb-4">Proin ipsum pharetra, senectus eget scelerisque varius pretium platea velit. Lacus, eget eu vitae nullam proin turpis etiam mi sit. Non feugiat feugiat egestas nulla nec. Arcu tempus, eget elementum dolor ullamcorper sodales ultrices eros.</p>--}}
{{--                    <form class="needs-validation" novalidate>--}}
{{--                        <label for="subscr-email" class="form-label">Subscribe to our newsletter</label>--}}
{{--                        <div class="input-group">--}}
{{--                            <input type="email" id="subscr-email" class="form-control rounded-start ps-5" placeholder="Your email" required>--}}
{{--                            <i class="bx bx-envelope fs-lg text-muted position-absolute top-50 start-0 translate-middle-y ms-3 zindex-5"></i>--}}
{{--                            <div class="invalid-tooltip position-absolute top-100 start-0">Please provide a valid email address.</div>--}}
{{--                            <button type="submit" class="btn btn-primary">Subscribe</button>--}}
{{--                        </div>--}}
{{--                    </form>--}}
                </div>
{{--                <div class="col-xl-6 col-lg-7 col-md-5 offset-xl-2 offset-md-1 pt-4 pt-md-1 pt-lg-0">--}}
{{--                    <div id="footer-links" class="row">--}}
{{--                        <div class="col-lg-4">--}}
{{--                            <h6 class="mb-2">--}}
{{--                                <a href="#useful-links" class="d-block text-dark dropdown-toggle d-lg-none py-2" data-bs-toggle="collapse">Useful Links</a>--}}
{{--                            </h6>--}}
{{--                            <div id="useful-links" class="collapse d-lg-block" data-bs-parent="#footer-links">--}}
{{--                                <ul class="nav flex-column pb-lg-1 mb-lg-3">--}}
{{--                                    <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">Home</a></li>--}}
{{--                                    <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">About</a></li>--}}
{{--                                    <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">Courses</a></li>--}}
{{--                                    <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">Careers</a></li>--}}
{{--                                    <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">Blog</a></li>--}}
{{--                                </ul>--}}
{{--                                <ul class="nav flex-column mb-2 mb-lg-0">--}}
{{--                                    <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">Terms &amp; Conditions</a></li>--}}
{{--                                    <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">Privacy Policy</a></li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-xl-4 col-lg-3">--}}
{{--                            <h6 class="mb-2">--}}
{{--                                <a href="#social-links" class="d-block text-dark dropdown-toggle d-lg-none py-2" data-bs-toggle="collapse">Socials</a>--}}
{{--                            </h6>--}}
{{--                            <div id="social-links" class="collapse d-lg-block" data-bs-parent="#footer-links">--}}
{{--                                <ul class="nav flex-column mb-2 mb-lg-0">--}}
{{--                                    <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">Facebook</a></li>--}}
{{--                                    <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">LinkedIn</a></li>--}}
{{--                                    <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">Twitter</a></li>--}}
{{--                                    <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">Instagram</a></li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-xl-4 col-lg-5 pt-2 pt-lg-0">--}}
{{--                            <h6 class="mb-2">Contact Us</h6>--}}
{{--                            <a href="mailto:email@example.com" class="fw-medium">email@example.com</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
            <p class="fs-xs text-center text-md-start pb-2 pb-lg-0 mb-0">
                &copy; All rights reserved. Made by
                <a class="nav-link d-inline-block p-0" href="/" target="_blank" rel="noopener">{{ config('app.name', 'Laravel') }}</a>
            </p>
        </div>
    </footer>



    <!-- Vendor Scripts -->
    <script src="/js/jquery-3.2.1.slim.min.js"></script>
    <script src="/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
    <script src="/assets/vendor/parallax-js/dist/parallax.min.js"></script>
    <script src="/assets/vendor/jarallax/dist/jarallax.min.js"></script>
    <script src="/assets/vendor/jarallax/dist/jarallax-element.min.js"></script>
    <script src="/assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main Theme Script -->
    <script src="/assets/js/theme.min.js"></script>
    @stack('js')
</body>
</html>
