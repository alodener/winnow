@extends('site.base')
@section('styles')
    <style>
        .card-empresa{
            border-style: solid;
            border-width: 0px 0px 0px 4px;
            border-color: #a07c33;
            box-shadow: 0px 0px 20px 0px rgb(0 0 0 / 10%);
        }
        .card-empresa2{
            border-style: solid;
            border-width: 2px 5px 2px 5px;
            border-color: #a07c33;
            box-shadow: 0px 0px 20px 0px rgb(0 0 0 / 10%);
        }
        .nh-title-empresa {
            line-height: 2.625rem;
            position: relative;
            color: #000;
            font-family: Roboto Slab,Arial,sans-serif;
            font-weight: 300;
            font-size: 2rem;
            text-decoration: underline #a07c33;
            text-underline-position: under;
        }
    </style>
@endsection
@section('content')
    <section class="probootstrap-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="nh-title pt-5 mb-4">Sobre Nós</h2>
                    <div class="card card-empresa mb-5">
                        <div class="card-body">
                            <h5>A Empresa</h5>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mb-4">
                    <div class="card card-empresa2">
                        <div class="card-body">
                            <h6 class="nh-title-empresa text-center mb-3">Política de Qualidade</h6>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')


@endpush
