@extends('layouts.admin')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Configurações de Planos</li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <style>
        .form-control {
            border: 1.5px solid #a07c33;
            height: 35px;
            padding: .24rem .50rem;
        }
        label {
            margin-bottom: .1rem;
        }
    </style>
    <section class="probootstrap-section">
        <div class="container">
            <div class="row">
                <div class="col-lg">
                    <h2 class="nh-title mb-3">Configurações de Planos</h2>
                    <div class="card">
                        <div class="card-body">
                            <form class="probootstrap-form" method="post" action="{{route('admin.configuracoes.planos.store')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nome do Plano</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                            @error('name')
                                            <span class="" style="color: red" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg">
                    <h2 class="nh-title mb-3">Planos Configurados</h2>
                    <div class="card mb-3">
                        <div class="card-body">
                            <table class="table table-hover table-bordered" style="font-size: 12px;">
                                <div class="table-sm">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Tipo</th>
                                        <th>Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($config as $c)
                                        <tr>
                                            <td>{{$c->name}}</td>
                                            <td>{{$c->tipo}}</td>
                                            <td><a class="btn btn-info btn-xs" href="{{route('admin.configuracoes.planos.edit',$c->id)}}"><span class="icon-pencil"></span></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </div>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')

@endpush
