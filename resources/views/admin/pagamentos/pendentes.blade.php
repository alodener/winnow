@extends('layouts.admin')
@section('title','Pagamentos Pendentes')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pagamentos</li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="row layout-top-spacing">
            <div class="col-lg">
                <h2 class="nh-title">Pagamentos Pendentes</h2>
                <div class="">
                    <div class="table-responsive">
                        <table class="table table-hover">
                        <!--<form action="{{route('admin.comprovantes.search')}}" method="POST" role="search">
                        {{ csrf_field() }}
                            <div class="input-group" style="width: 200px; float: right;">
                                <input type="text" class="rq-form-control" name="q" placeholder="Pesquisar Usuário">
                                <button type="submit" class="btn btn-success">
                                    <span class="fa fa-search"></span>
                                </button>
                            </div>
                        </form>-->
                            <thead class="thead-dark">
                            <tr>
                                <th>Comprovante</th>
                                <th>Valor R$</th>
                                <th>Usuário</th>
                                <th colspan="2">Data</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pendentes as $p)
                                <tr>
                                    <td>
                                        <?php $comprovante = \App\Models\Comprovante::where('pagamento_id',$p->id)->first();?>
                                        @if($comprovante)
                                            @if($comprovante->tipo == 'pdf')
                                                {{$comprovante->img_comprovante}}
                                            @else
                                                <img src="/imagem/comprovantes/{{$comprovante->img_comprovante}}" style="width: 50px;">
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{number_format($p->valor,2,',','.')}}</td>
                                    <td>{{$p->users->username}}</td>
                                    <td>{{$p->updated_at->format('d/m/Y H:i')}}</td>
                                    <td>
                                        <a href="{{route('admin.pagamentos.show',$p->id)}}" class="btn btn-info">Ver</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{$pendentes->links()}}
                </div>
            </div>

        </div>
@stop
@section('js')

@stop
