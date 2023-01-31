@extends('layouts.admin')
@section('breadcrumb')
<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <div class="container">
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Todos os Planos</li>
        </div>
    </ol>
  </nav>
@endsection
@section('content')
<section class="probootstrap-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <a class="btn btn-info mb-4" href="{{route('admin.produtos.create')}}">Adicionar Produto</a>
            </div>
        </div>
        <div class="row">
            @foreach ($planos as $p)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <img src="/imagem/planos/{{$p->imagem}}" class="card-img-top" alt="...">
                            <h5 class="card-title pt-2">{{$p->name}}</h5>
                            <p class="card-text">{!!$p->descricao !!}</p>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{route('admin.produtos.edit',$p->id)}}" class="btn btn-outline-info" data-toggle="tooltip" title="Editar"><i class="icon-pencil"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
