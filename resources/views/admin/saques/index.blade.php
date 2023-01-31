@extends('layouts.admin')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pedidos de Saques</li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="row layout-top-spacing">
        <div class="col-lg">
            <h2 class="nh-title">Pedidos de Saques</h2>
            <div class="table-responsive">
                <table class="table table-hover ">
                    <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Valor $</th>
                        <th colspan="2">Data</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($saques as $s)
                        <tr>
                            <td>{{$s->id}}</td>
                            <td>{{$s->users->username}}</td>
                            <td>{{number_format($s->valor,2,'.','')}}</td>
                            <td>{{$s->created_at->format('d/m/Y H:i')}}</td>
                            <td>
                                <a href="{{route('admin.saques.show',$s->id)}}" class="btn btn-info">Exibir</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{$saques->links()}}
        </div>
    </div>
@endsection
@section('js')

@stop
