@extends('layouts.admin')
@section('title','Admin')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Administração</li>
@endsection
@section('content')
            <div class="row layout-top-spacing">
                <div class="col-md-6 col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">Planos Vendidos</div>
                        <div class="card-body text-primary">
                            <h5 class="card-title text-right">{{$planosvendidos}}</h5>
                        </div>
                    </div>
                </div>
{{--                <div class="col-md-4 col-lg-3">--}}
{{--                    <div class="card border-dark mb-3">--}}
{{--                        <div class="card-header">Vouchers Ativo</div>--}}
{{--                        <div class="card-body text-primary">--}}
{{--                            <h5 class="card-title text-right">{{$planosvoucher}}</h5>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="col-md-6 col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">Total de Usuários</div>
                        <div class="card-body text-primary">
                            <h5 class="card-title text-right">{{$userCount}}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header"></div>
                        <div class="card-body text-primary">
                            <h5 class="card-title text-right"></h5>
                        </div>
                    </div>
                </div>
{{--                <div class="col-md-4 col-lg-3">--}}
{{--                    <div class="card border-danger mb-3">--}}
{{--                        <div class="card-header">--}}
{{--                            @if(date('w') == 1)--}}
{{--                            segunda--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                        <div class="card-body text-primary">--}}
{{--                            <h5 class="card-title text-right"></h5>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Entradas</h5>
                            <canvas id="chartjs1">Your browser does not support the canvas element.</canvas>
                        </div>
                    </div>
                </div>
{{--                <div class="col-lg-12">--}}
{{--                    <div class="card bg-dark mb-3">--}}
{{--                        <div class="card-body">--}}
{{--                            <h5 class="card-title">Produtos Mais Vendidos</h5>--}}
{{--                            <canvas id="chartjs4">Your browser does not support the canvas element.</canvas>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
            <div class="row">
                <div class="col-12">
                    <h2 class="nh-title mb-3">Pagamentos Pendentes</h2>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead >
                                    <tr>
                                        <th>ID</th>
                                        <th>Valor R$</th>
                                        <th>Usuário</th>
                                        <th>Data</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($pagPendentes as $p)
                                        <tr>
                                            <td>{{$p->id}}</td>
                                            <td>{{number_format($p->valor,2,',','.')}}</td>
                                            <td><a href="{{route('admin.users.edit',$p->user_id)}}">{{$p->users->name}}</a></td>
                                            <td>{{$p->created_at->diffForHumans()}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h2 class="nh-title mb-3">Usuários Recentes</h2>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Login</th>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Ativo/Novo</th>
                                        <th>Data</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $u)
                                        <tr>
                                            <td>{{$u->username}}</td>
                                            <td><a href="{{route('admin.users.edit',$u->id)}}">{{$u->name}}</a></td>
                                            <td>{{$u->email}}</td>
                                            <td>
                                            @if($u->ativo == '1')
                                                Ativo
                                            @else
                                                Pendente
                                            @endif
                                            </td>
                                            <td>{{$u->created_at->diffForHumans()}}</td>
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
@push('js')
    <script src="{{asset('js/chart.min.js')}}"></script>
    <script>
        {{--new Chart(document.getElementById("chartjs4"),--}}
        {{--    {--}}
        {{--        "type":"bar",--}}
        {{--        "data":{--}}
        {{--            "labels":[--}}
        {{--                @foreach($planos as $p)--}}
        {{--                    "{{substr($p->name,0,15)}}",--}}
        {{--                @endforeach--}}
        {{--            ],--}}
        {{--            "datasets":[--}}
        {{--                {--}}
        {{--                    "label":"My First Dataset",--}}
        {{--                    "data":[--}}
        {{--                        @foreach($planos as $p)--}}
        {{--                        <?php $count = \App\Models\Pagamento::where('plano_id', $p->id)->where('status','1')->count();?>--}}
        {{--                        {{$count}},--}}
        {{--                        @endforeach--}}
        {{--                    ],--}}
        {{--                    "backgroundColor":[--}}
        {{--                        @foreach($planos as $p)--}}
        {{--                            "rgb({{$p->id}}{{substr($p->valor, 0, 1)}}, {{substr($p->valor, 0, 2)}}, {{substr($p->valor, 0, 3)}})",--}}
        {{--                        @endforeach--}}
        {{--                        //"rgb(255, 99, 132)",--}}
        {{--                        //"rgb(54, 162, 235)",--}}
        {{--                        //"rgb(255, 205, 86)"--}}
        {{--                    ]--}}
        {{--                }--}}
        {{--            ]--}}
        {{--        }--}}
        {{--    });--}}

        new Chart(document.getElementById("chartjs1"),
            {
                "type":"line",
                "data":
                    {
                        "labels":[
                            @foreach($vendas as $v)
                                "{{$v->data}}",
                            @endforeach
                        ],
                        "datasets":
                            [
                                {
                                    "label":"Contratos",
                                    "data":[
                                        @foreach($vendas as $v)
                                        {{$v->valor}},
                                        @endforeach
                                    ],
                                    "fill":false,
                                    "borderColor":"#ffc107",
                                    "lineTension":0.1
                                }
                            ]
                    },
                "options":{}
            }
        );
    </script>
@endpush
