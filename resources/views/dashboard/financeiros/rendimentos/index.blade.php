@extends('layouts.app')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active">Extratos</li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <style>
        .card-body .rotate {
            z-index: 8;
            float: right;
            height: 100%;
        }

        .card-body .rotate .icon-users {
            color: rgba(20, 20, 20, 0.15);
            left: auto;
            bottom: 0;
            display: block;
            font-size: 4em;
        }
    </style>
    <section class="probootstrap-section">
        <div class="container">
            <div class="row mb-3">
                <div class="col-xl-6 col-sm-6 py-2 semline">
                    <div class="card bg-light h-100" >
                        <div class="card-body bg-secundary">
                            <span class="icon-wallet float-right" style="font-size: 5em"></span>
                            <h6 class="text-uppercase">Rendimento Copy Trader</h6>
                            <h1 class="display-6">$ {{number_format($rendimentosSumCP,2,'.','')}}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-6 py-2 semline">
                    <div class="card bg-light h-100">
                        <div class="card-body bg-secundary">
                            <span class="icon-wallet float-right" style="font-size: 5em"></span>
                            <h6 class="text-uppercase">Rendimento IV TUBO FREE</h6>
                            <h1 class="display-6">$ {{number_format($rendimentosSumXM,2,'.','')}}</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="nh-title">Bônus</h2>
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Valor</th>
                            <th>Descricao</th>
                            <th>Data</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($rendimentos as $h)
                            <tr>
                                <td>{{$h->tipo}}</td>
                                <td>$ {{number_format($h->valor,2,'.','')}}</td>
                                <td>{{$h->created_at->format('d/m/Y')}}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4">Sem Rendimento</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                    {{$rendimentos->render()}}
                </div>
            </div>
        </div>
    </section>
@endsection
