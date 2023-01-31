@extends('layouts.base')
@section('title',$course['course_title'])
@section('styles')

@endsection

@section('content')
    <section class="jarallax dark-mode bg-dark pt-2 pt-lg-3 pb-lg-5" data-jarallax data-speed="0.4">
        <span class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-70"></span>
        <div class="jarallax-img" style="background-image: url(/assets/img/portfolio/courses/single.jpg);"></div>
        <div class="container position-relative zindex-5 pb-5">

            <!-- Breadcrumb -->
            <nav class="py-4" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"><i class="bx bx-home-alt fs-lg me-1"></i>Ínicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('dashboard.cursos.index')}}">Crusos</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{$course['course_title']}}</li>
                </ol>
            </nav>

            <!-- Badges -->
            <div class="d-flex pt-1 pb-3 py-sm-4">
{{--                <?php $categorias = \App\Models\CatCurso::where('curso_id',$course['course_id'])->get(); ?>--}}
{{--                @foreach($categorias as $cat)--}}
{{--                    <a href="#" class="badge bg-white text-nav fs-sm text-decoration-none me-2">{{$cat->categorias->name}}</a>--}}
{{--                @endforeach--}}
            </div>

            <!-- Title -->
            <h1>{{$course['course_title']}}</h1>
            <p class="fs-lg text-light opacity-70">{{$course['course_description']}}</p>

            <!-- Stats -->
            <div class="d-sm-flex py-3 py-md-4 py-xl-5">
{{--                <div class="d-flex border-sm-end pe-sm-3 me-sm-3 mb-2 mb-sm-0">--}}
{{--                    <div class="text-nowrap me-1">--}}
{{--                        <i class="bx bxs-star text-warning"></i>--}}
{{--                        <i class="bx bxs-star text-warning"></i>--}}
{{--                        <i class="bx bxs-star text-warning"></i>--}}
{{--                        <i class="bx bxs-star text-warning"></i>--}}
{{--                        <i class="bx bx-star text-muted opacity-75"></i>--}}
{{--                    </div>--}}
{{--                    <span class="text-light opacity-70">(1.2K reviews)</span>--}}
{{--                </div>--}}
{{--                <div class="d-flex border-sm-end pe-sm-3 me-sm-3 mb-2 mb-sm-0">--}}
{{--                    <i class="bx bx-like fs-xl text-light opacity-70 me-1"></i>--}}
{{--                    <span class="text-light opacity-70">4.2K likes</span>--}}
{{--                </div>--}}
{{--                <div class="d-flex">--}}
{{--                    <i class="bx bx-time fs-xl text-light opacity-70 me-1"></i>--}}
{{--                    <span class="text-light opacity-70">220 hours</span>--}}
{{--                </div>--}}
            </div>

            <!-- Author -->
            <div class="d-flex align-items-center mt-xl-5 pt-2 pt-md-4 pt-lg-5">
                <img src="{{$course['course_teacher']['teacher_image']}}" class="rounded-circle" width="60" alt="{{$course['course_teacher']['teacher_name']}}">
                <div class="ps-3">
                    <div class="text-light opacity-80 mb-1">Criado por</div>
                    <h6 class="mb-0" >{{$course['course_teacher']['teacher_name']}}</h6>
                    <p class="text-white">{{$course['course_teacher']['teacher_description']}}</p>
                </div>
            </div>
        </div>

    </section>

    <!-- Course description -->
    <section class="container pt-5 mt-2 mt-lg-4 mt-xl-5">
        <div class="row">
            <!-- Sidebar (Course summary) -->
            <aside class="col-lg-4 col-md-5 offset-xl-1 order-md-2 mb-5">
                <div style="margin-top: -96px;"></div>
                <div class="position-sticky top-0 pt-5">
                    <div class="pt-5 mt-md-3">
                        <div class="card shadow-sm p-sm-3">
                            <div class="card-body">
                                <h4 class="mb-4">Este curso inclui:</h4>
                                <ul class="list-unstyled pb-3">
                                    <li class="d-flex align-items-center mb-2">
                                        <i class="bx bx-slideshow fs-xl text-muted me-2 pe-1"></i>
                                        220 horas de vídeo sob demanda
                                    </li>
{{--                                    <li class="d-flex align-items-center mb-2">--}}
{{--                                        <i class="bx bx-file fs-xl text-muted me-2 pe-1"></i>--}}
{{--                                        18 articles--}}
{{--                                    </li>--}}
{{--                                    <li class="d-flex align-items-center mb-2">--}}
{{--                                        <i class="bx bx-download fs-xl text-muted me-2 pe-1"></i>--}}
{{--                                        25 downloadable resources--}}
{{--                                    </li>--}}
                                    <li class="d-flex align-items-center mb-2">
                                        <i class="bx bx-infinite fs-xl text-muted me-2 pe-1"></i>
                                        Acesso vitalício completo
                                    </li>
                                    <li class="d-flex align-items-center mb-2">
                                        <i class="bx bx-trophy fs-xl text-muted me-2 pe-1"></i>
                                        Certificado de conclusão
                                    </li>
                                </ul>
                                <?php $pagamento = \App\Models\Pagamento::where(['user_id'=>auth()->id(),'status'=>'1'])->orderBy('id','desc')->first(); ?>
                                @if($pagamento)
                                    <a href="{{route('dashboard.cursos.assistir',$course['course_id'])}}" target="_blank" class="btn btn-primary btn-lg shadow-primary">
                                        <i class="bx bx-play-circle me-2"></i>
                                        Assistir o Curso
                                    </a>
                                @else
                                    <a href="#" class="btn btn-primary btn-lg shadow-primary">Join the course</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Content -->
            <div class="col-xl-7 col-lg-8 col-md-7 order-md-1 mb-5">
                <h2 class="h1 pb-md-2 pb-lg-3">Descrição do Curso</h2>
                <p class="mb-3">{{$course['course_description']}}</p>
                <hr class="mb-3">
                <?php
                    function video_player($url) {
                        preg_match('#(\.be/|/embed/|/v/|/watch\?v=)([A-Za-z0-9_-]{5,11})#', $url, $match);
                        return '<iframe width="100%" height="450" src="//www.youtube.com/embed/'.$match[2].'?wmode=transparent&autohide=1&rel=0&showinfo=0&showsearch=0&iv_load_policy=3&modestbranding=1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
                    }
                ?>
                {!! video_player($course['course_video']) !!}
                <hr class="mb-3">
                <h3 class="mb-4">Tópicos</h3>
                <ul class="list-unstyled mb-5">
                    @foreach($course['course_topics'] AS $topic)
                        <li class="d-flex align-items-center mb-2">
                            <i class="bx bx-check-circle text-primary fs-xl me-2"></i>
                            {{$topic}}.
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
@endsection
@push('js')

@endpush
