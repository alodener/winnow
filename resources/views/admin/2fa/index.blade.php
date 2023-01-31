@extends('layouts.admin')

@section('content')
    <div class="rq-tips-tricks">
        <div class="row">
            <h2 class="nh-title">Usuários com Autenticação de Dois Fatores Ativado</h2>
            <div class="panel panel-default">
            	<div class="panel-body">
                    <table class="table table-hover ">
                        <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($two2fas as $t)
                        <tr>
                            <td>{{$t->id}}</td>
                            <td>{{$t->user->name}}</td>
                            <td>                            	
                            	Ativado
                            </td>
                            <td>{{$t->created_at->diffForHumans()}}</td> 
                            <td>
                            	<a href="{{route('admin.2fa.ver',$t->id)}}" class="btn btn-info">Exibir Usuário</a>
                            </td>                           
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@stop
