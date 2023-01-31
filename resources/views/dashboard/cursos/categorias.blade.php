@extends('layouts.base')
@section('title','Categoria')
@section('styles')

@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
    <li class="breadcrumb-item active">Cursos</li>
@endsection
@section('content')
    <section class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 gx-3 gx-md-4 mt-n2 mt-sm-0">
            <div class="col-lg-12">
                <h1 class="me-3 d-block">Categorias</h1>
            </div>
            @foreach($categorias['CATEGORIES'] as $c)
                <div class="col pb-1 pb-lg-3 mb-4">
                    <article class="card h-100 border-0 shadow-sm">
                        <div class="position-relative">
                            <div class="card-body">
{{--                                <img src="" class="card-img-top" alt="Image">--}}
                                <a class="text-decoration-none" href="{{route('dashboard.cursos.getCategoria',$c['category_id'])}}">
                                    {{$c['category_title']}} <span> ({{$c['category_courses_total']}})</span>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </section>
@endsection
@push('js')

@endpush
