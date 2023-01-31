@extends('layouts.admin')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.configuracoes.bonus.index')}}">Bônus</a></li>
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
                    <h2 class="nh-title mb-3">Configuração do Bônus: {{$config->name}}</h2>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                <form class="probootstrap-form" method="post" action="{{route('admin.configuracoes.bonus.update',$config->id)}}" enctype="multipart/form-data">
                                    @csrf
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nome do Plano</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ $config->name }}" required>
                                            @error('name')
                                            <span class="" style="color: red" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 1</label>
                                            <input type="text" name="nvl1" value="{{$config->config['nvl1']}}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 2</label>
                                            <input type="text" name="nvl2" value="{{$config->config['nvl2']}}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 3</label>
                                            <input type="text" name="nvl3" value="{{$config->config['nvl3']}}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 4</label>
                                            <input type="text" name="nvl4" value="{{$config->config['nvl4']}}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 5</label>
                                            <input type="text" name="nvl5" value="{{$config->config['nvl5']}}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 6</label>
                                            <input type="text" name="nvl6" value="{{$config->config['nvl6']}}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 7</label>
                                            <input type="text" name="nvl7" value="{{$config->config['nvl7']}}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 8</label>
                                            <input type="text" name="nvl8" value="{{$config->config['nvl8']}}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 9</label>
                                            <input type="text" name="nvl9" value="{{$config->config['nvl9']}}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 10</label>
                                            <input type="text" name="nvl10" value="{{$config->config['nvl10']}}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 11</label>
                                            <input type="text" name="nvl11" value="{{@$config->config['nvl11']}}" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="nvl1">Nível 12</label>
                                            <input type="text" name="nvl12" value="{{@$config->config['nvl12']}}" class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Editar</button>
                                    </form>
                                    <form id="excluir" class="float-right mt-n3" action="{{route('admin.configuracoes.bonus.delete',$config->id)}}" method="post">
                                        @csrf
                                        <button class="btn btn-danger">Excluir</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        document.querySelector('#excluir').addEventListener('submit',function(e){
            var form=this;
            e.preventDefault();
            swal({
                title:"Deseja Excluir?",
                text:"",
                icon:"warning",
                buttons:['Não!','Sim!'],
                dangerMode:!0,}).then(function(isConfirm){
                if(isConfirm){
                    form.submit()
                }else{
                    swal("Cancelado","Ação Cancelada","error")
                }
            })
        })
    </script>
@endpush
