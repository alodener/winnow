@extends('layouts.admin')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Pesquisa de Usuário</li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
<section class="probootstrap-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="nh-title mb-3">Pesquisa de Usuário</h2>
                <div class="card mb-3">
                    <div class="card-body" style="font-size: 12px">
                        <form action="{{route('admin.users.search')}}" method="POST" role="search">
                            {{ csrf_field() }}
                            <div class="input-group mb-3 float-right" style="width: 18.6rem">
                                <input type="text" name="q" class="form-control" placeholder="Pesquisar Usuário" aria-label="Pesquisar Usuário" aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-info" type="submit" id="button-addon2"><span class="fa fa-search"></span></button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-hover ">
                                <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Login</th>
                                    <th>Email</th>
                                    <th>Ativo</th>
                                    <th>Data</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($details))
                                    <p>Os resultados da sua pesquisa <b>{{$query}}</b>:</p>
                                    @foreach($details as $u)
                                        <tr>
                                            <td>{{$u->id}}</td>
                                            <td>{{$u->name}}</td>
                                            <td>{{$u->username}}</td>
                                            <td>{{$u->email}}</td>
                                            <td>
                                                @if($u->ativo == 1)
                                                    Ativo
                                                @else
                                                    Pendente/Novo
                                                @endif
                                            </td>
                                            <td>{{$u->created_at->format('d/m/Y H:i')}}</td>
                                            <td>
                                                <a href="{{route('admin.users.edit',$u->id)}}" class="btn btn-warning"><i class="fa fa-pen"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('js')

@stop
