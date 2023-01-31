@extends('layouts.admin')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Configurações de Bônus</li>
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
                    <h2 class="nh-title mb-3">Configurações de Bônus</h2>
                    <div class="card">
                        <div class="card-body">
                            <form class="probootstrap-form" method="post" action="{{route('admin.configuracoes.bonus.store')}}" enctype="multipart/form-data">
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
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 1</label>
                                            <input type="text" name="nvl1" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 2</label>
                                            <input type="text" name="nvl2" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 3</label>
                                            <input type="text" name="nvl3" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 4</label>
                                            <input type="text" name="nvl4" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 5</label>
                                            <input type="text" name="nvl5" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 6</label>
                                            <input type="text" name="nvl6" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 7</label>
                                            <input type="text" name="nvl7" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 8</label>
                                            <input type="text" name="nvl8" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 9</label>
                                            <input type="text" name="nvl9" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 10</label>
                                            <input type="text" name="nvl10" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 11</label>
                                            <input type="text" name="nvl11" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 12</label>
                                            <input type="text" name="nvl12" class="form-control">
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
                    <h2 class="nh-title mb-3">Bônus Configurados</h2>
                    <div class="card mb-3">
                        <div class="card-body">
                            <table class="table table-hover table-bordered" style="font-size: 12px;">
                                <div class="table-sm">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Nvl 1</th>
                                        <th>Nvl 2</th>
                                        <th>Nvl 3</th>
                                        <th>Nvl 4</th>
                                        <th>Nvl 5</th>
                                        <th>Nvl 6</th>
                                        <th>Nvl 7</th>
                                        <th>Nvl 8</th>
                                        <th>Nvl 9</th>
                                        <th>Nvl 10</th>
                                        <th>Nvl 11</th>
                                        <th>Nvl 12</th>
                                        <th>Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($bonus as $c)
                                        <tr>
                                            <td>{{$c->name}}</td>
                                            <td>{{$c->config['nvl1']}}</td>
                                            <td>{{$c->config['nvl2']}}</td>
                                            <td>{{$c->config['nvl3']}}</td>
                                            <td>{{$c->config['nvl4']}}</td>
                                            <td>{{$c->config['nvl5']}}</td>
                                            <td>{{$c->config['nvl6']}}</td>
                                            <td>{{$c->config['nvl7']}}</td>
                                            <td>{{$c->config['nvl8']}}</td>
                                            <td>{{$c->config['nvl9']}}</td>
                                            <td>{{$c->config['nvl10']}}</td>
                                            <td>{{@$c->config['nvl11']}}</td>
                                            <td>{{@$c->config['nvl12']}}</td>
                                            <td><a class="btn btn-info btn-xs" href="{{route('admin.configuracoes.bonus.edit',$c->id)}}"><span class="icon-pencil"></span></a></td>
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
