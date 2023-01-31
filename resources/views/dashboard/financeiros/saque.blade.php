@extends('layouts.base')
@section('title','Saques')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
    <li class="breadcrumb-item active">Saques</li>
@endsection
@section('content')
<?php $config = \App\Models\Configuracao::first();?>
    <section class="container">
        <div class="row layout-top-spacing mb-3">
            <div class="col-md-12">
                <h2 class="nh-title">Saques</h2>
                <div class="row justify-content-center">
                    <div class="col-lg-8 mb-3">
                        <div class="p-3 bg-body rounded border">
                            <h6>Saldo</h6>
                            <h4 class="mb-3">R$ {{number_format($wallet->saldo,2,',','.')}}</h4>
                            <?php
                                $pagamento = \App\Models\Pagamento::where(['user_id'=>auth()->id(),'status'=>'1'])->orderBy('id','desc')->first();
                            ?>
                            @if($pagamento)
                                @if($wallet->saldo >= $config->limite_saque)
                                    <form action="{{ route('dashboard.fazerSaque') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="tipo" value="rendimento">
                                        @foreach($contas as $c)
                                            <div class="form-group">
                                                <input type="radio" name="conta_id" value="{{$c->id}}" required/>
                                                <label class="">
                                                    <b>PIX:</b> {{$c->conta['hash']}}
                                                </label>
                                            </div>
                                        @endforeach
                                        <div class="input-group mb-4">
                                            <span class="input-group-text">$</span>
                                            <input id="saques" name="saldo" type="text" class="form-control valor" required autocomplete="off"/>
                                            <button class="btn btn-success" type="submit">Sacar</button>
                                        </div>
                                        @error('saldo')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </form>
                                @endif
                            @else
                            <p>Adquira uma Plano para poder ter acessos aos Cursos e Bonificações! <a href="{{route('dashboard.produtos.index')}}">clique aqui.</a></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h5>Pedidos de Saques</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Valor R$</th>
                            <th>Status</th>
                            <th>Tipo</th>
                            <th>Data</th>
                        </tr>
                        </thead>
                        @foreach($saques as $c)
                            <tr>
                                <td>{{$c->id}}</td>
                                <td>{{number_format($c->valor,2,',','.')}}</td>
                                <td>
                                    @if($c->ativo == '3')
                                        Reprovado
                                    @elseif($c->ativo == '1')
                                        Pago
                                    @else
                                        Pendente
                                    @endif
                                </td>
                                <td>
                                    @if($c->tipo == 'rendimento')
                                        Rendimento
                                    @elseif($c->tipo == 'bonus_venda')
                                        Bonus de Venda
                                    @elseif($c->tipo == 'ganhos_afiliados')
                                        Ganhos de Afiliados
                                    @endif
                                </td>
                                <td>{{$c->created_at->format('d/m/Y H:i')}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>
@stop
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.valor').mask('999.999.999,00', {reverse: true});
        });
    </script>
@endpush
