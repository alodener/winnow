@extends('layouts.base')
@section('title','Históricos de Transações')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
    <li class="breadcrumb-item active">Históricos de Transações</li>
@endsection
@section('content')
    <div class="row layout-top-spacing mb-3">
        <div class="col-lg-4 mb-1 layout-spacing">
            <div class="widget widget-card-four" style="padding: 15px 12px;">
                <div class="widget-content">
                    <div class="w-content">
                        <div class="w-info">
                            <h6 class="value">R$ {{number_format($wallet->saldo,2,',','.')}}</h6>
                            <p class="" style="font-size: 14px;">Rendimento</p>
                        </div>
                        <div class="">
                            <div class="w-icon" style="background-color: #28a745;">
                                <i data-feather="dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-1 layout-spacing">
            <div class="widget widget-card-four" style="padding: 15px 12px;">
                <div class="widget-content">
                    <div class="w-content">
                        <div class="w-info">
                            <h6 class="value">R$ {{number_format($wallet->saldo_indicacao,2,',','.')}}</h6>
                            <p class="" style="font-size: 14px;">Ganhos de Afiliados</p>
                        </div>
                        <div class="">
                            <div class="w-icon" style="background-color: #28a745;">
                                <i data-feather="dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-1 layout-spacing">
            <div class="widget widget-card-four" style="padding: 15px 12px;">
                <div class="widget-content">
                    <div class="w-content">
                        <div class="w-info">
                            <h6 class="value">R$ {{number_format($totaldeganhos,2,',','.')}}</h6>
                            <p class="" style="font-size: 14px;">Total de Ganhos</p>
                        </div>
                        <div class="">
                            <div class="w-icon" style="background-color: #2196f3;">
                                <i data-feather="dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="nh-title">Históricos de Transações</h2>
                    <form action="" method="post">
                        @csrf
                        <div class="row mb-3 ">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="date" name="inicio" min="2021-01-01"  max="{{date('Y-m-d')}}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="date" name="fim"  min="2021-01-01" max="{{date('Y-m-d')}}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-secondary">Pesquisar</button>
                            </div>
                        </div>
                    </form>
                    <table class="table table-hover bg-info">
                        <thead>
                        <tr>
                            <th>Total Antes</th>
                            <th>Total Depois</th>
                            <th>Tipo</th>
                            <th>Data</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($historicos as $h)
                            <tr>
                                <td>R$ {{number_format($h->total_antes,2,',','.')}}</td>
                                <td>R$ {{number_format($h->total_depois,2,',','.')}}</td>
                                <td>
                                    @if($h->tipo == 'rendimento')
                                        Rendimento
                                    @else
                                        Ganhos de Afiliados
                                    @endif
                                </td>
                                <td>{{$h->created_at->format('d/m/Y H:i:s')}}</td>
                            </tr>
                        @empty
                        <tr><td colspan="4">Sem Histórico</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

@endsection
