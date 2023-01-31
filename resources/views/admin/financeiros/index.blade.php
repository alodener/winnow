@extends('layouts.admin')
@section('title','Últimos Registros')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item active"><a href="{{route('admin.index')}}">Home</a></li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="row layout-top-spacing">
                <div class="col-12">

                    <h2 class="nh-title mb-3">Últimos Registros</h2>
                    <a class="btn @if(Request::get('tipo') == null) {{request()->routeIs('admin.financeiros.index') ? 'btn-info':'btn-outline-info'}} @else btn-outline-info @endif mb-3" href="{{route('admin.financeiros.index')}}">Todos</a>
                    <a class="btn {{request()->routeIs('admin.financeiros.pagamentos') ? 'btn-info' : 'btn-outline-info'}} mb-3" href="{{route('admin.financeiros.pagamentos')}}"><i class="fa fa-dollar-sign"></i> Entradas</a>
                    <a class="btn @if(Request::get('tipo') == 'indicacao_direta') btn-info @else btn-outline-info @endif mb-3" href="{{route('admin.financeiros.index','tipo=indicacao_direta')}}">Indicação Direta</a>
                    <a class="btn @if(Request::get('tipo') == 'indicacao_indireta') btn-info @else btn-outline-info @endif mb-3" href="{{route('admin.financeiros.index','tipo=indicacao_indireta')}}">Indicação Indireta</a>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Usuário</th>
                                <th>Tipo</th>
                                <th>Valor R$</th>
                                <th>Descrição</th>
                                <th>Data</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($financeiros as $f)
                                <tr>
                                    <td>#{{$f->id}}</td>
                                    <td>
                                        <a href="{{route('admin.users.edit',$f->user_id)}}">
                                            Nome: {{$f->users->name}} </br>
                                            Login: {{$f->users->username}}
                                        </a>
                                    </td>
                                    <td>
                                        @if($f->tipo == "1")
                                            Pagamento
                                        @elseif($f->tipo == "2")
                                            Bonus: {{$f->tipo_bonus}}
                                        @endif
                                    </td>
                                    <td>{{number_format($f->valor,2,',','.')}}</td>
                                    <td>
                                        {{$f->descricao}} <br>
                                        @if($f->pagamento_id)
                                            <a href="{{route('admin.pagamentos.show',$f->pagamento_id)}}" class="link-badge-info">Ganho sobre Fatura #{{$f->pagamento_id}}</a>
                                        @elseif($f->investimento_id)
                                            <a href="{{route('admin.investimentos.show',$f->investimento_id)}}" class="link-badge-info">
                                                Referente ao Contrato #{{$f->investimento_id}}
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{$f->created_at->format('d/m/Y H:i')}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <style>
                        .pagination {
                            display: -ms-flexbox !important;
                            flex-wrap: wrap !important;
                        }
                    </style>
                    {{$financeiros->appends(['tipo'=>Request::get('tipo')])->links()}}
                </div>
            </div>
@endsection
@push('js')

@endpush
