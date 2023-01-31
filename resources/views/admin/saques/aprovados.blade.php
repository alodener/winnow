@extends('layouts.admin')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pedidos de Saques Efetuados</li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
<section class="probootstrap-section">
    <div class="container">
        <div class="row">
            <div class="col-lg">
                <h2 class="nh-title">Pedidos de Saques Efetuados</h2>
                <div class="card bg-dark">
                    <div class="card-body">
                        <table class="table table-hover ">
                            <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Valor $</th>
                                <th>Tipo</th>
                                <th>Data</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($saques as $s)
                                <tr>
                                    <td>{{$s->id}}</td>
                                    <td>{{$s->users->name}}</td>
                                    <td>{{$s->tipo}}</td>
                                    <td>{{number_format($s->valor,2,'.','')}}</td>
                                    <td>{{$s->created_at->format('d/m/Y H:i')}}</td>
                                    <td>
                                        <a href="{{route('admin.saques.show',$s->id)}}" class="btn btn-success">Exibir</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

@stop
