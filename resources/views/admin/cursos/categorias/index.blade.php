@extends('layouts.admin')
@section('title','Categorias')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.cursos.index')}}">Cursos</a></li>
                <li class="breadcrumb-item active"><a href="{{route('admin.cursos.categorias.index')}}">Categorias</a></li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <h4 class="float-left">Categorias</h4>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-sm float-right mb-3" data-toggle="modal" data-target="#exampleModal">
                Criar Categoria
            </button>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Criar Categoria</h1>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{route('admin.cursos.categorias.store')}}" method="post">
                            @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name">Nome</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Criar</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="table-responsive mt-3">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Nome</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($categorias as $c)
                            <tr>
                                <td>#{{$c->id}}</td>
                                <td>{{$c->name}}</td>
                                <td>
                                    <form action="{{route('admin.cursos.categorias.delete',$c->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('js')

@endpush
