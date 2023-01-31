@extends('layouts.admin')
@section('title','Faturas de '.$user->name)
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
            <h5 class="nh-title">Faturas de <small>{{$user->username}}</small></h5>
            @include('admin.users.menu_users')
            <div class="card border-info">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-dark">
                            <tr>
                                <th>#ID</th>
                                <th>Valor R$</th>
                                <th>Status</th>
                                <th>Tipo</th>
                                <th>Validade</th>
                                <th colspan="2">Data</th>
                            </tr>
                            </thead>
                            <tbody style="font-size: 14px">
                            @forelse($faturas as $f)
                                <tr>
                                    <td>{{$f->id}}</td>
                                    <td>{{number_format($f->valor,2,',','.')}}</td>
                                    <td>
                                        @if($f->status == "1")
                                            <span class="badge badge-success">Paga</span>
                                        @elseif($f->status == "2")
                                            <span class="badge badge-info">Licença Concluída</span>
                                        @elseif($f->status == "3")
                                            <span class="badge badge-danger">Expirada</span>
                                        @else
                                            <span class="badge badge-warning">Nova/Pendente</span>
                                        @endif
                                    </td>
{{--                                    <td>@if($f->voucher_id) Ativado com Voucher @endif</td>--}}
                                    <td>{{$f->tipo}}</td>
                                    <td>
                                        {{$f->validate_at?$f->validate_at->format('d/m/Y H:i'):''}}
                                    </td>
                                    <td>
                                        <span class="d-block">Criada: {{$f->created_at->format('d/m/Y H:i')}} </span>
                                        <span class="d-block">Atualizada: {{$f->updated_at->format('d/m/Y H:i')}} </span>
                                    </td>
                                    <td>
                                        <a class="btn btn-info" href="{{route('admin.pagamentos.edit',$f->id)}}">Editar</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4">Sem Histórico</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{$faturas->render()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@push('js')

@endpush
