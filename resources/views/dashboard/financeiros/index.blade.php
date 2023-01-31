@extends('layouts.base')
@section('title','Pagamentos')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
    <li class="breadcrumb-item active">Pagamentos</li>
@endsection
@section('content')
    <section class="container">
    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <h2 class="nh-title">Pagamentos</h2>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Valor R$</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pagamentos as $p)
                        <tr>
                            <td>{{$p->id}}</td>
                            <td>{{number_format($p->valor,2,',','.')}}</td>
                            <td>{{$p->created_at->format('d/m/Y H:i')}}</td>
                            <td>
                                @if($p->status == "0")
                                    <span class="text-warning">Pagamento Pendente</span>
                                @elseif($p->status == "2")
                                    <span class="text-info">Licença Concluída</span>
                                @else
                                    <span class="text-success"> Pagamento Aprovado</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-info" href="{{route('dashboard.verPagamento',$p->id)}}">Ver</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </section>
@endsection
@section('js')

@stop
