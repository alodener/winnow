@extends('layouts.base')
@section('title','Inicio')
@section('styles')
    <style>
        .widget-card-four .progress { margin-top: 16px;}
    </style>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><i class="bx bx-home-alt fs-lg me-1"></i>Inicio</li>
@endsection
@section('content')
    <?php
        $indicacao_direta = \App\Models\Financeiro::where(['user_id'=>Auth::id(),'tipo_bonus'=>'indicacao_direta'])->sum('valor');
        $indicacao_indireta = \App\Models\Financeiro::where(['user_id'=>Auth::id(),'tipo_bonus'=>'indicacao_indireta'])->sum('valor');
        $total = $indicacao_direta+$indicacao_indireta;
        $ganhosTotais = $total + $wallet->saldo_venda;
        $config = \App\Models\Configuracao::first();
        $pagamento = \App\Models\Pagamento::select('tipo','updated_at')->where(['user_id'=>auth()->id(),'status'=>'1'])->orderBy('id','desc')->first();
        if($pagamento){
            $now = \Carbon\Carbon::now();
            $created_at = \Carbon\Carbon::parse($pagamento->updated_at->format('Y-m-d H:i:s'));
            $diffDays = $created_at->diffInDays($now->format('Y-m-d H:i:s'));
        }

    ?>
<section class="container">
    <div class="row layout-top-spacing mb-3">
        <div class="col-lg-12 mb-2">
            <h5>Bem-vindo {{auth()->user()->name}}</h5>
        </div>

        <div class="col-lg-6 mb-1">
            <div class="p-3 bg-body shadow-sm rounded border border-1">
                <div class="d-flex justify-content-between">
                    <div class="float-start">
                        <h5 class="value">$ {{number_format($wallet->saldo,2,'.','')}}</h5>
                        <p class="mb-0" style="font-size: 14px;">Saldo Disponível</p>
                    </div>
                    <div class="float-end d-inline-block bg-success shadow-success rounded-3 p-3">
                        <i class="fa fa-dollar-sign d-block text-white" style="font-size: 2rem"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-1 layout-spacing">
            <div class="p-3 bg-body shadow-sm rounded border border-1">
                <div class="d-flex justify-content-between">
                    <div class="float-start">
                        <h5 class="value">$ {{number_format($totaldeganhos,2,'.','')}}</h5>
                        <p class="mb-0" style="font-size: 14px;">Total de Ganhos</p>
                    </div>
                    <div class="float-end d-inline-block bg-info shadow-info rounded-3 p-3">
                        <i class="fa fa-dollar-sign d-block text-white" style="font-size: 2rem"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row analytics">
        <div class="col-lg-12 mb-3 col-12">
            <h5 class="p-3 bg-body shadow-sm rounded border">
                Link de Indicação: <a id="url" href="{{url('/register')}}?u={{Auth::user()->username}}" target="_blank">{{url('/register')}}?u={{Auth::user()->username}}</a>
                <button class="btn btn-outline-info btn-icon rounded-circle me-2 bs-tooltip"
                        id="copy" data-clipboard-target="#url" title="Copiar Link de Indicação"
                        data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover">
                    <i class="bx bx-copy"></i>
                </button>
            </h5>
        </div>
        <div class="col-lg-6 mb-lg-0 mb-md-3">
            <div class="card bg-body shadow-sm rounded border-1">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-auto my-0">
                            <span class="icon-users"></span>
                        </div>
                        <div class="col-auto text-center">
                            <span class="uTitle">Indicados Ativos</span>
                            <p class="mb-0" style="font-size: 1.75em">{{$afiliadosCount}} indicação(oes)</p>
                        </div>
                        <?php
                        $ind_ativos = \App\Models\User::select('id','name','username')->where(['indicacao'=>Auth::user()->username,'ativo'=>'1'])->orderBy('id','desc')->limit(5)->get();
                        ?>
{{--                        <div class="col-12 text-center">--}}
{{--                            <div class="avatar--group pt-3">--}}
{{--                                @foreach($ind_ativos as $a)--}}
{{--                                    <span class="bg-gradient-primary rounded-circle flex-shrink-0 p-3 text-white" data-original-title="{{$a->name}}">{{$a->getNameInitials()}}</span>--}}
{{--                                @endforeach--}}
{{--                                @if($ind_ativos->count() < $afiliadosCount)--}}
{{--                                    <div class="position-relative ms-2">--}}
{{--                                        <div class="badge bg-info position-absolute top-0 start-100 translate-middle-x ms-n5 mt-n5">--}}
{{--                                            <a href="{{route('dashboard.redes.diretos')}}" class="badge badge-info badge-pill">+{{$afiliadosCount - $ind_ativos->count()}} indicações</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="d-flex align-items-center justify-content-center pb-2 pt-lg-2 pb-xl-0 mb-3">
                            <div class="d-flex me-3">
                                @foreach($ind_ativos as $a)
                                <div class="d-flex align-items-center justify-content-center bg-gradient-primary text-white rounded-circle ms-n3" style="width: 52px; height: 52px;">
                                    <span data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" title="{{$a->name}}" data-bs-content="{{$a->username}}">
                                        {{$a->getNameInitials()}}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @if($ind_ativos->count() < $afiliadosCount)
                            <span class="fs-sm d-block text-center"><a href="{{route('dashboard.redes.diretos')}}" class="link-primary fw-semibold text-decoration-none">
                                    +{{$afiliadosCount - $ind_ativos->count()}} indicações</a>
                                </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card bg-body shadow-sm rounded border">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="row justify-content-center">
                            <div class="col-auto my-0">
                                <span class="icon-users"></span>
                            </div>
                            <div class="col-auto text-center">
                                <span class="uTitle">Total de afiliados</span>
                                <p class="mb-0" style="font-size: 1.75em">{{$indiretosCoun}} afiliados</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('js')
    <script src="{{asset('js/clipboard.min.js')}}"></script>
    <script src="/plugins/apex/apexcharts.min.js"></script>
    <script>
        var d_2options2 = {
            chart: {
                id: 'sparkline1',
                group: 'sparklines',
                type: 'area',
                height: 280,
                sparkline: {
                    enabled: true
                },
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            fill: {
                opacity: 1,
            },
            series: [{
                name: 'Ganhos',
                data: [
                    @foreach($ganhos as $v)
                        {{number_format($v->valor,2,'.','')}},
                    @endforeach
                ]
            }],
            labels: [@foreach($ganhos as $v)
                    '{{$v->created_at->format('d/m/Y')}}',
                @endforeach],
            yaxis: {
                min: 0
            },
            grid: {
                padding: {
                    top: 125,
                    right: 0,
                    bottom: 36,
                    left: 0
                },
            },
            fill: {
                type:"gradient",
                gradient: {
                    type: "vertical",
                    shadeIntensity: 1,
                    inverseColors: !1,
                    opacityFrom: .40,
                    opacityTo: .05,
                    stops: [45, 100]
                }
            },
            tooltip: {
                x: {
                    show: false,
                },
                theme: 'dark'
            },
            colors: ['#fff']
        }
        var d_2C_2 = new ApexCharts(document.querySelector("#total-orders"), d_2options2);
        d_2C_2.render();
        new ClipboardJS('#copy');
    </script>
@endpush
