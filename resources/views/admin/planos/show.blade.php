@extends('layouts.admin')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.produtos.index')}}">Produtos</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$plano->name}}</li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <section class="probootstrap-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <a class="btn btn-info mb-4" href="{{route('admin.sub-planos.create',['produto'=>$plano->id])}}">Adicionar Sub Plano</a>
                </div>
                @foreach ($subplanos as $p)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <img src="/imagem/planos/{{$p->img}}" class="card-img-top" alt="...">
                                <h5 class="card-title pt-1">{{$p->name}}</h5>
                                <h6>$ {{number_format($p->valor,2,'.','')}}</h6>
                                <div class="card-text">{!!$p->descricao !!}</div>
                            </div>
                            <div class="card-footer">
                                <a href="{{route('admin.sub-planos.edit',['produto'=>$plano->id,'sub_plano'=>$p->id])}}"
                                   class="btn btn-outline-info float-right" data-toggle="tooltip" title="Editar"><i class="icon-pencil"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
