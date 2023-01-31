@extends('layouts.base')
@section('title','Inicio')
@section('styles')

@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Inicio</li>
@endsection
@section('content')
    <section class="container">
        <div class="row mb-5">
            <div class="col-lg-12 text-center mb-3">
                <?php $pagamentos = \App\Models\Pagamento::where('user_id',auth()->id())->orderBy('id','desc')->first(); ?>
                @if(!$pagamentos)
                    <a href="{{route('dashboard.produtos.index')}}" class="btn btn-primary text-uppercase">Adquira a Assinatura Premium!</a>
                @elseif($pagamentos)
                    @if($pagamentos->status == "0")
                        <a href="{{route('dashboard.verPagamento',$pagamentos->id)}}" class="btn btn-warning text-uppercase">Você tem uma fatura Pendente, clique aqui!</a>
                    @elseif($pagamentos->status == "3")
                        <a href="{{route('dashboard.produtos.index')}}" class="btn btn-primary text-uppercase">Faça a Renovação para poder ter acessos aos Produtos e Ganhos!</a>
                    @endif
                @endif
            </div>
        </div>
    </section>
    <section class="container pb-5 mb-2 mb-md-4 mb-lg-5">
        <div class="bg-secondary rounded-3 py-5 px-3 px-md-0">
            <div class="row justify-content-center mb-2 py-md-2 py-lg-4">
                <div class="col-lg-10 col-md-11">
                    <h2 class="pb-3">Beneficios por ter uma Assinatura Premium</h2>
                    <div class="row row-cols-1 row-cols-md-2 g-4">

                        <!-- Item -->
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm p-md-2 p-lg-4">
                                <div class="card-body d-flex align-items-center">
                                    <div class="bg-primary shadow-primary rounded-3 flex-shrink-0 p-1">
                                        <i class="bx bxs-videos d-block m-1 text-white" style="font-size: 57px"></i>
                                    </div>
                                    <div class="ps-1 ms-lg-3">
                                        <h3 class="display-5 mb-1">{{$cursosCount}}+</h3>
                                        <p class="mb-0"><span class="fw-semibold">Acesso</span> à Cursos</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Item -->
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm p-md-2 p-lg-4">
                                <div class="card-body d-flex align-items-center">
                                    <div class="bg-primary shadow-primary rounded-3 flex-shrink-0 p-2">
                                        <i class="bx bxs-badge-dollar d-block m-1 text-white" style="font-size: 57px"></i>
                                    </div>
                                    <div class="ps-1 ms-lg-3">
                                        <h3 class="display-5 mb-1">30+</h3>
                                        <p class="mb-0">Comércios com <span class="fw-semibold">Desconto</span></p>
                                    </div>
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
    <script>
        new ClipboardJS('#copy');
    </script>
@endpush
