@extends('layouts.admin')
@section('title','Pagamentos Concluídos')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pagamentos Concluídos</li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="row layout-top-spacing">
            <div class="col-lg">
                <h2 class="nh-title">Pagamentos Ativos</h2>
                <div class=table-responsive>
                    <table class="table table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th>ID Pagamento</th>
                            <th>Comprovante</th>
                            <th>Valor R$</th>
                            <th>Usuário</th>
                            <th>Data Ativação</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ativos as $a)
                            <tr>
                                <td>{{$a->id}}</td>

                                <td class="text-break">
                                    <?php $comprovante = \App\Models\Comprovante::where('pagamento_id',$a->id)->first();?>
                                    @if($comprovante)
                                        @if($comprovante->tipo == 'pdf')
                                            {{$comprovante->img_comprovante}}
                                        @else
                                            <img src="/imagem/comprovantes/{{$comprovante->img_comprovante}}" style="width: 50px;">
                                        @endif
                                    @endif
                                </td>
                                <td>{{number_format($a->valor,2,',','.')}}</td>
                                <td>{{$a->users->name}}</td>
                                <td>{{$a->updated_at->format('d/m/Y H:i')}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$ativos->links()}}
                </div>
            </div>
        </div>
@stop
@section('js')

@stop
