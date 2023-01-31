@extends('layouts.base')
@section('title','Extratos')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <style>
        select {
            font-family: 'FontAwesome', 'sans-serif';
        }
    </style>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
    <li class="breadcrumb-item active">Extratos</li>
@endsection
@section('content')
    <div class="row layout-top-spacing mb-3">
        <div class="col-lg-6 mb-1 layout-spacing">
            <div class="widget widget-card-four" >
                <div class="widget-content">
                    <div class="w-content">
                        <div class="w-info">
                            <h6 class="value">$ {{number_format($wallet->saldo,2,'.','')}}</h6>
                            <p class="" style="font-size: 14px;">Saldo Disponível</p>
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
        <div class="col-lg-6 mb-1 layout-spacing">
            <div class="widget widget-card-four">
                <div class="widget-content">
                    <div class="w-content">
                        <div class="w-info">
                            <h6 class="value">$ {{number_format($totaldeganhos,2,'.','')}}</h6>
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
                    <h2 class="nh-title">
                        Extratos
                        <div class="float-right">
                            <form action="" method="post">
                                @csrf
                                <?php
                                    $anos = \App\Models\Financeiro::where(['user_id'=>Auth::id()])->select(DB::raw('YEAR(created_at) year'))->orderBy('year')->groupBy('year')->get();
                                ?>
                                <div class="form-group">
                                    <select name="ano" id="ano" class="form-control font-awesome">
                                        @foreach($anos as $a)
                                            @if($a->year == $get)
                                            <option value="{{$a->year}}" selected>&#xf133; {{$a->year}}</option>
                                            @else
                                            <option value="{{$a->year}}">&#xf133; {{$a->year}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                    </h2>

{{--                    <form action="" method="post">--}}
{{--                        @csrf--}}
{{--                        <div class="row mb-3 ">--}}
{{--                            <div class="col-md-3">--}}
{{--                                <div class="form-group">--}}
{{--                                    <input type="date" name="inicio" min="2021-01-01"  max="{{date('Y-m-d')}}" class="form-control" required>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-3">--}}
{{--                                <div class="form-group">--}}
{{--                                    <input type="date" name="fim"  min="2021-01-01" max="{{date('Y-m-d')}}" class="form-control" required>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-2">--}}
{{--                                <button type="submit" class="btn btn-warning">Pesquisar</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Valor $</th>
                                <th>Descricao</th>
{{--                                <th>Bônus</th>--}}
                                <th>Data</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($historicos as $h)
                                <tr>
                                    <td>
                                        @if($h->tipo == 1)
                                            Pagamento
                                        @elseif($h->tipo == 2)
                                            Ganho
                                        @elseif($h->tipo == 3)
                                            Saques
                                        @endif
                                    </td>
                                    <td>{{number_format($h->valor,2,'.','')}}</td>
                                    <td>{{$h->descricao}}</td>
{{--                                    <td>{{$h->tipo_bonus}}</td>--}}
                                    <td>{{$h->created_at->format('d/m/Y')}}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4">Sem Histórico</td></tr>
                            @endforelse
                            </tbody>
                            {{--                        <tfoot>--}}
                            {{--                        <tr>--}}
                            {{--                            <td colspan="4"></td>--}}
                            {{--                            <td class="font-weight-bold">Total: {{$historicosSum}} TRX</td>--}}
                            {{--                        </tr>--}}
                            {{--                        </tfoot>--}}
                        </table>
                    </div>
                </div>
            </div>

@endsection
@push('js')
    <script>
        $(document).ready(function(e) {
            $("[name='ano']").on('change', function() {
                this.form.submit();
            });
        });
    </script>
@endpush
