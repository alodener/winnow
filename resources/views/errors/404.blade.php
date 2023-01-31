@extends('site.base')
@section('content')
    <section class="container d-flex flex-column h-100 align-items-center position-relative zindex-5">
        <div class="text-center pb-3 mt-auto">

            <!-- Parallax gfx (Light version) -->
            <div class="parallax mx-auto d-dark-mode-none" style="max-width: 574px;">
                <div class="parallax-layer" data-depth="-0.15">
                    <img src="/assets/img/404/light/layer01.png" alt="Layer">
                </div>
                <div class="parallax-layer" data-depth="0.12">
                    <img src="/assets/img/404/light/layer02.png" alt="Layer">
                </div>
                <div class="parallax-layer zindex-5" data-depth="-0.12">
                    <img src="/assets/img/404/light/layer03.png" alt="Layer">
                </div>
            </div>

            <!-- Parallax gfx (Dark version) -->
            <div class="parallax mx-auto d-none d-dark-mode-block" style="max-width: 574px;">
                <div class="parallax-layer" data-depth="-0.15">
                    <img src="/assets/img/404/dark/layer01.png" alt="Layer">
                </div>
                <div class="parallax-layer" data-depth="0.12">
                    <img src="/assets/img/404/dark/layer02.png" alt="Layer">
                </div>
                <div class="parallax-layer zindex-5" data-depth="-0.12">
                    <img src="/assets/img/404/dark/layer03.png" alt="Layer">
                </div>
            </div>

            <h1 class="visually-hidden">404</h1>
            <h2 class="display-5">Ooops!</h2>
            <p class="fs-xl pb-3 pb-md-0 mb-md-5">The page you are looking for is not available.</p>
            <a href="{{route('home')}}" class="btn btn-lg btn-primary shadow-primary w-sm-auto w-100">
                <i class="bx bx-home-alt me-2 ms-n1 lead"></i>
                Voltar para o Inicio
            </a>
        </div>
    </section>
@endsection
