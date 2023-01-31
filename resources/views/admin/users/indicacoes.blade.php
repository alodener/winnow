@extends('layouts.admin')
@section('title','Indicações de '.$user->name)
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item "><a href="{{route('admin.users.index')}}">Todos os Usuários</a></li>
                <li class="breadcrumb-item active">Editar Usuário: {{$user->name}}</li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <h5 class="nh-title">Rede de {{$user->username}} total de {{$indicacoesCount}} direto(s)</h5>
            @include('admin.users.menu_users')
            <div class="card border-info">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-dark">
                            <tr>
                                <th>Nome</th>
                                <th>Login</th>
                                <th>Status</th>
                                <th>Cadastro</th>
                            </tr>
                            </thead>
                            <tbody style="font-size: 14px">
                            @forelse($indicacoes as $i)
                                <tr>
                                    <td>{{$i->name}}</td>
                                    <td><a href="{{route('admin.users.edit',$i->id)}}">{{$i->username}}</a></td>
                                    <td>
                                        {{\App\Classes\VerificaUserAtivo::verificaPagamento($i->id)?'Ativo':'Inativo'}}
                                    </td>
                                    <td>{{$i->created_at->format('d/m/Y')}}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4">Sem Histórico</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{$indicacoes->render()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@push('js')

@endpush
