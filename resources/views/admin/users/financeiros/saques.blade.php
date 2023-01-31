@extends('layouts.admin')
@section('title','Saques de '.$user->name)
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
            <h5 class="nh-title">Histórico de Saques de <small>{{$user->username}}</small></h5>
            @include('admin.users.menu_users')
            <div class="card border-info">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-dark">
                            <tr>
                                <th>#ID</th>
                                <th>R$</th>
                                <th>Status</th>
                                <th>Tipo</th>
                                <th>Data</th>
                            </tr>
                            </thead>
                            <tbody style="font-size: 14px">
                            @forelse($saques as $s)
                                <tr>
                                    <td>{{$s->id}}</td>
                                    <td>{{number_format($s->valor,2,',','.')}}</td>
                                    <td>
                                    @if($s->ativo == 1)
                                        <span class="rounded bg-success py-1 px-1 text-white">Saque Aprovado</span>
                                    @elseif($s->ativo == 0)
                                        <span class="rounded bg-warning py-1 px-1 text-white">Saque Pendente</span>
                                    @elseif($s->ativo == 3)
                                        <span class="rounded bg-danger py-1 px-1 text-white">Reprovado</span>
                                    @endif
                                    </td>
                                    <td>
                                        {{$s->tipo}}
                                    </td>
                                    <td>{{$s->created_at->format('d/m/Y H:i')}}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4">Sem Histórico</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{$saques->render()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@push('js')

@endpush
