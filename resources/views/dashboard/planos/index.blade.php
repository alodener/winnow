@extends('layouts.base')
@section('title','Planos')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
    <li class="breadcrumb-item active">Planos</li>
@endsection
@section('content')
    <section class="container py-5 my-md-2 my-lg-4 my-xl-5">
        <h2 class="h1 text-center pb-3 pb-md-4">Adquirir Plano</h2>
        <div class="price-switch-wrapper mb-n2">
            <div class="row justify-content-center">
                <?php
                    $pagamento = \App\Models\Pagamento::where('user_id',auth()->id())->orderBy('id','desc')->first();
                    if($pagamento){
                        $now = \Carbon\Carbon::now();
                        $created_at = \Carbon\Carbon::parse($pagamento->updated_at->format('Y-m-d H:i:s'));
                        $diffDays = $created_at->diffInDays($now->format('Y-m-d H:i:s'));
                    }
                ?>
                @foreach($planos as $p)
                    @if(!$pagamento)
                        @if($p->tipo == 'adesao')
                            <div class="col-lg-5">
                                <div class="card bg-light position-relative border-primary shadow-primary shadow-dark-mode-none p-xxl-3" style="min-width: 18rem;">
                                    <div class="card-body">
                                        <div class="d-table bg-faded-primary rounded-circle mx-auto p-4 mb-3">
                                            <i class="bx bx-money-withdraw text-primary display-4 fw-normal lh-1 p-1 p-sm-2"></i>
                                        </div>
                                        <div class="text-center border-bottom pb-3 mb-3">
                                            <h3 class="h5 fw-normal text-muted mb-1">{{$p->name}}</h3>
                                                <?php $valor_array = explode('.',trim(number_format($p->valor,2,'.','')));?>
                                            <span class="h2 mb-0" data-monthly-price="">R$ {{$valor_array[0]}}<sup><small>,{{$valor_array[1]}}</small></sup></span>
                                        </div>
                                        <form action="{{route('dashboard.produtos.addPlano')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="plano_id" id="plano_id" value="{{$p->id}}">
                                            <button type="submit" class="btn btn-primary shadow-primary w-100">Adquirir</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @elseif($pagamento)
                        @if(($pagamento->tipo == 'adesao' && $diffDays >= 60) || ($pagamento->tipo == 'renovacao' && $diffDays >= 30))
                            @if($p->tipo == 'renovacao')
                                <div class="col-lg-5">
                                    <div class="card bg-light position-relative border-primary shadow-primary shadow-dark-mode-none p-xxl-3" style="min-width: 18rem;">
                                        <div class="card-body">
                                            <div class="d-table bg-faded-primary rounded-circle mx-auto p-4 mb-3">
                                                <i class="bx bx-money-withdraw text-primary display-4 fw-normal lh-1 p-1 p-sm-2"></i>
                                            </div>
                                            <div class="text-center border-bottom pb-3 mb-3">
                                                <h3 class="h5 fw-normal text-muted mb-1">{{$p->name}}</h3>
                                                    <?php $valor_array = explode('.',trim(number_format($p->valor,2,'.','')));?>
                                                <span class="h2 mb-0" data-monthly-price="">R$ {{$valor_array[0]}}<sup><small>,{{$valor_array[1]}}</small></sup></span>
                                            </div>
                                            <form action="{{route('dashboard.produtos.addPlano')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="plano_id" id="plano_id" value="{{$p->id}}">
                                                <button type="submit" class="btn btn-primary shadow-primary w-100">Adquirir</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endif
                    @if($p->tipo == 'teste')
                        <div class="col-lg-5">
                            <div class="card bg-light position-relative border-primary shadow-primary shadow-dark-mode-none p-xxl-3" style="min-width: 18rem;">
                                <div class="card-body">
                                    <div class="text-center border-bottom pb-3 mb-3">
                                        <h3 class="h5 fw-normal text-muted mb-1">{{$p->name}}</h3>
                                        <span class="h2 mb-0" data-monthly-price="">R$ {{$p->valor}}<sup><small>,00</small></sup></span>
                                    </div>
                                    <form action="{{route('dashboard.produtos.addPlano')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="plano_id" id="plano_id" value="{{$p->id}}">
                                        <button type="submit" class="btn btn-primary shadow-primary w-100">Adquirir</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach


            </div>

        </div>
    </section>
@endsection
@push('js')

@endpush
