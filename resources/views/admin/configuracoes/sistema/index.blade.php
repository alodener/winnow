@extends('layouts.admin')
@section('title','Configurações')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Configurações do Sistema</li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="row layout-top-spacing">
        <div class="col-lg">
            <h2 class="nh-title mb-3">Configurações do Sistema</h2>
            <div class="card">
                <div class="card-body">
                    <form class="" method="post" action="{{route('admin.configuracoes.sistema.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Saque Minimo</label>
                                    <input type="text" class="form-control" id="limite_saque" name="limite_saque" value="{{ $config->limite_saque }}" required>
                                    @error('name')
                                    <span class="" style="color: red" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="taxa_saque" class="form-label">Taxa de Saque %</label>
                                    <input type="text" class="form-control" id="taxa_saque" name="taxa_saque" value="{{ $config->taxa_saque }}" required>
                                    @error('taxa_saque')
                                    <span class="" style="color: red" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-secondary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')

@endpush
