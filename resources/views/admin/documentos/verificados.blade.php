@extends('layouts.admin')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Documentos Verificados</li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
<section class="probootstrap-section">
    <div class="container">
        <div class="row">
            <div class="col-lg">
                <h2 class="nh-title">Documentos Verificados</h2>
                <div class="panel bg-dark">
                    <div class="panel-body">
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th>Comprovante</th>
                                <th>Usuário</th>
                                <th>Tipo</th>
                                <th>Data</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($documentos as $d)
                                <tr>
                                    <td>
                                        <a href="/imagem/documentos/{{$d->img}}" target="_blank">
                                            <img src="/imagem/documentos/{{$d->img}}" style="width: 150px">
                                        </a>
                                    </td>
                                    <td>
                                        {{$d->users->name}} <br>
                                    </td>
                                    <td>{{$d->tipo}}</td>
                                    <td>{{$d->created_at->diffForHumans()}}</td>
                                    <td>
                                        <form action="{{route('admin.documentos.aprovarDocumento',$d->id)}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="pagamento_id" value="{{$d->pagamento_id}}">
                                            <input type="hidden" name="user_id" value="{{$d->user_id}}">
                                            <input type="hidden" name="status" value="3">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-warning fluid-btn">Reprovar</button>
                                            </div>
                                        </form>
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
</section>
@stop
@section('js')

@stop
