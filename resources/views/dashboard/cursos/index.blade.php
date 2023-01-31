@extends('layouts.base')
@section('title','Inicio')
@section('styles')

@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
    <li class="breadcrumb-item active">Cursos</li>
@endsection
@section('content')
    <section class="container">
        <!-- Page title + Filters -->
        <div class="d-lg-flex align-items-center justify-content-between py-4 mt-lg-2">
            <h1 class="me-3">Cursos</h1>
            <form action="" method="post">
                <div class="d-md-flex mb-3">
                    <a href="{{route('dashboard.cursos.categorias')}}" class="btn btn-primary me-md-4 mb-2 mb-md-0" style="min-width: 240px;">
                        Todas categorias
                    </a>

                </div>
            </form>
        </div>
        <!-- Courses grid -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 gx-3 gx-md-4 mt-n2 mt-sm-0">

            @foreach($cursos AS $course)
                <!-- Item -->
                <div class="col pb-1 pb-lg-3 mb-4">
                    <article class="card h-100 border-0 shadow-sm">
                        <div class="position-relative">
                            <a href="{{route('dashboard.cursos.show',$course['course_id'])}}" class="d-block position-absolute w-100 h-100 top-0 start-0"></a>
{{--                            <span class="badge bg-success position-absolute top-0 start-0 zindex-2 mt-3 ms-3">Best Seller</span>--}}
                            <a href="#" class="btn btn-icon btn-light bg-white border-white btn-sm rounded-circle position-absolute top-0 end-0 zindex-2 me-3 mt-3" data-bs-toggle="tooltip" data-bs-placement="left" title="Salvar no Favoritos">
                                <i class="bx bx-bookmark"></i>
                            </a>
                           <img src="{{$course['course_image']}}" class="card-img-top" alt="Image">

                        </div>
                        <div class="card-body pb-3">
                            <h3 class="h5 mb-2">
                                <a href="{{route('dashboard.cursos.show',$course['course_id'])}}">{{$course['course_title']}}</a>
                            </h3>
                            <p class="fs-sm mb-2">por EDU CLUBE</p>
                            <p class="small">{{Str::limit($course['course_description'],100)}}</p>
                        </div>
                        <div class="card-footer d-flex align-items-center fs-sm text-muted py-4">
{{--                            <div class="d-flex align-items-center me-4">--}}
{{--                                <i class="bx bx-time fs-xl me-1"></i>--}}
{{--                                0 hours--}}
{{--                            </div>--}}
{{--                            <div class="d-flex align-items-center">--}}
{{--                                <i class="bx bx-like fs-xl me-1"></i>--}}
{{--                                94% (4.2K)--}}
{{--                            </div>--}}
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </section>
@endsection
@push('js')

@endpush
