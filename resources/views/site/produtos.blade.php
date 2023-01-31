@extends('site.base')
@section('content')
    <section class="probootstrap-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="nh-title">Produtos</h2>
                    <p class="pt-3"><a class="btn btn-lg btn-success" href="{{route('site.downloadArquivo')}}">Baixar Arquivo <i class="fa fa-download"></i></a></p>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')

@endpush
