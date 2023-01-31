@extends('layouts.base')
@section('title','Extratos')
@section('styles')
    <style>
        select {
            font-family: 'FontAwesome', 'sans-serif';
        }
        .lista{
            max-width: 40rem;
        }
    </style>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
    <li class="breadcrumb-item active">Extratos</li>
@endsection
@section('content')
    <section class="container">
        <div class="row mb-3">
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
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-10">
                <h2 class="nh-title">
                    Extratos
                    <div class="float-end">
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
            </div>
            <div class="col-lg-8 col-md-10 col-sm-10 col-xl-6">
                @forelse($historicos as $h)
                    <?php
                        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
                        date_default_timezone_set('America/Sao_Paulo');
                        $mes = strftime('%B', strtotime($h->ano.'-'.$h->mes));
                    ?>
                    <h5 class="mb-3 text-primary">
                        <i class="fa fa-calendar-check"></i> {{$h->mes == '3' ?'março':$mes}}
                    </h5>
                    <div class="p-4 rounded bg-body rounded border">
                        <?php
                            $financeiros = \App\Models\Financeiro::select('id','tipo','valor','descricao','created_at')
                                                            ->where('user_id',auth()->id())
                                                            ->whereMonth('created_at',$h->mes)
                                                            ->get();
                        ?>
                        @foreach($financeiros as $f)
                            <p class="mb-2">
                                @if($f->tipo == 1)
                                    <span class="badge bg-warning rounded-pill me-2"> Pagamento </span>
                                @elseif($f->tipo == 2)
                                    <span class="badge bg-success rounded-pill me-2"> Ganho </span>
                                @elseif($f->tipo == 3)
                                    <span class="badge bg-danger rounded-pill me-2"> Saques </span>
                                @endif
                                R$ @if($f->tipo == 3)-@endif{{number_format($f->valor,2,',','.')}} {{$f->descricao}}, {{$f->created_at->format('d/m/Y H:i')}}
                                <span>#{{$f->id}}</span>
                            </p>
                        @endforeach
                    </div>
                @empty
                    <tr><td colspan="4">Sem Histórico</td></tr>
                @endforelse
            </div>
        </div>
    </section>
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
