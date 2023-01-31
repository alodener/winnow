@extends('layouts.base')
@section('title','Forma de Pagamento')
@section('styles')
    <style>
        .hide {
            display: none!important;
        }
        #copy-me {
            /*display:none*/
        }
        .sumir{
            opacity: 1;
            transition: opacity .5s linear;
        }
        #mensagem.hide {
            opacity: 0;
            pointer-events: none;
        }
    </style>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{route('dashboard.pagamentos.index')}}">Pagamentos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Forma de Pagamento</li>
@endsection
@section('content')
    <section class="container">
        <div class="row justify-content-center layout-top-spacing">
            <div class="col-lg-8">
                <h2 class="nh-title">Forma de Pagamento</h2>
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-lg-12 mb-3">
                                <h6 class="text-uppercase mb-3">
                                    <span class="float-start">Fatura #{{$pagamento->id}}</span>
                                    <span class="text-uppercase float-end">
                                    @if($pagamento->status == '0')
                                            <span class="text-warning">Aguradando Pagamento</span>
                                        @elseif($pagamento->status == '1')
                                            <span class="text-success">Paga</span>
                                        @elseif($pagamento->status == '3')
                                            <span class="text-danger">Expirada</span>
                                    @endif
                                    </span>
                                </h6>
                                <div class="clearfix"></div>
                                <p class="mb-0 mt-3">Valor: R$ {{number_format($pagamento->valor,2,',','.')}}</p>
                                <p>Data da Transação: {{$pagamento->created_at->format('d/m/Y H:i')}}</p>
                            </div>
                            @if($pagamento->status == '0')
                            <a class="btn btn-success" href="{{route('dashboard.pagamentos.checkout',$pagamento->id)}}">Checkout</a>
{{--                            <button class="btn btn-success" onclick="displayOpenPixModal()">--}}
{{--                                Checkout--}}
{{--                            </button>--}}
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#TransaçãoID</th>
                                                <th>Valor</th>
                                                <th>Status</th>
                                                <th>Pix</th>
                                                <th>Data</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $fatura = \App\Models\Fatura::where(['user_id'=>auth()->id(),'pagamento_id'=>$pagamento->id])->first(); ?>
                                        @if($fatura)
                                            <tr>
                                                <td>{{$fatura->transactionID}}</td>
                                                <td>{{number_format($fatura->valor,2,',','.')}}</td>
                                                <td>{{$fatura->status}}</td>
                                                <td>{{$fatura->pixKey}}</td>
                                                <td>{{$fatura->updated_at->format('d/m/Y H:i')}}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@push('js')
    <script src="{{asset('js/clipboard.min.js')}}"></script>
    <script>
        new ClipboardJS('#copy');
    </script>
@endpush
