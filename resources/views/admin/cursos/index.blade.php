@extends('layouts.admin')
@section('title','Cursos')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{route('admin.cursos.index')}}">Cursos</a></li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <h2>Cursos</h2>
            <a class="btn btn-primary" href="{{route('admin.cursos.create')}}">Adicionar Curso</a>
            <a class="btn btn-primary" href="{{route('admin.cursos.categorias.index')}}">Categorias</a>
            <div class="table-responsive mt-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
@push('js')

@endpush
