@extends('site.base')
@section('styles')
    <style>
        .radio-list--item{background-color:#fff;margin-bottom:12px;position:relative}
        .radio-list--item label{-webkit-transition:all .2s ease;transition:all .2s ease;font-family:Roboto,Helvetica,Arial,sans-serif;font-size:1rem;padding:0 15px;cursor:pointer;margin:0;color:#18191a;width:100%;border:1px solid #ffd20c}
        .radio-list--item span{display:block;line-height:1.6}
        .radio-list--item--title{padding-top:20px;font-weight:400;text-align:center;line-height:1.7;padding-bottom:20px}
        .radio-list--item input[type=radio]{display:none}
        .radio-list--item input[type=radio]:checked~label{background-color:#ffd20c;border:1px solid #ffd20c}
        input[type=range]{height:34px;-webkit-appearance:none;margin:10px 0;width:100%}
        input[type=range]:focus{outline:0}
        input[type=range]::-webkit-slider-runnable-track{width:100%;height:2px;cursor:pointer;animate:.2s;box-shadow:0 0 0 #000;background:#ffd20c;border-radius:2px;border:0 solid #010101}
        input[type=range]::-webkit-slider-thumb{box-shadow:1px 1px 1px #2d3109;border:0 solid #1e1b08;height:26px;width:26px;border-radius:17px;background:#ffd20c;cursor:pointer;-webkit-appearance:none;margin-top:-12.5px}
        input[type=range]:focus::-webkit-slider-runnable-track{background:#d1be5e}
        input[type=range]::-moz-range-track{width:100%;height:2px;cursor:pointer;animate:.2s;box-shadow:0 0 0 #000;background:#ffd20c;border-radius:2px;border:0 solid #010101}
        input[type=range]::-moz-range-thumb{box-shadow:1px 1px 1px #2d3109;border:1px solid #1e1b08;height:26px;width:26px;border-radius:17px;background:#f0ff21;cursor:pointer}
        input[type=range]::-ms-track{width:100%;height:2px;cursor:pointer;animate:.2s;background:0 0;border-color:transparent;color:transparent}
        input[type=range]::-ms-fill-lower{background:#ffd20c;border:0 solid #010101;border-radius:4px;box-shadow:0 0 0 #000}
        input[type=range]::-ms-fill-upper{background:#ffd20c;border:0 solid #010101;border-radius:4px;box-shadow:0 0 0 #000}
        input[type=range]::-ms-thumb{margin-top:1px;box-shadow:1px 1px 1px #2d3109;border:1px solid #1e1b08;height:26px;width:26px;border-radius:17px;background:#ffd20c;cursor:pointer}
        input[type=range]:focus::-ms-fill-lower{background:#ffd20c}
        input[type=range]:focus::-ms-fill-upper{background:#ffd20c}
        .valor{color:#000;font-family:Roboto Slab,Arial,sans-serif;font-size:3.33333rem;font-weight:300}
        .range{padding-top: 35px;}
        .button-simulador{border-radius:2px;line-height:1.29;font-family:Roboto,Helvetica,Arial,sans-serif;font-weight:400;text-align:center;-webkit-transition:background-color .3s ease-in-out,border-color .3s ease-in-out;transition:background-color .3s ease-in-out,border-color .3s ease-in-out;font-size:1rem;display:inline-block;border:2px solid #000}
        .button-simulador, .button-simulador:hover{background-color: #000;text-decoration: none;color: #ffc709;}
        .button-simular-novamente{border-radius:2px;line-height:1.29;font-family:Roboto,Helvetica,Arial,sans-serif;font-weight:400;text-align:center;-webkit-transition:background-color .3s ease-in-out,border-color .3s ease-in-out;transition:background-color .3s ease-in-out,border-color .3s ease-in-out;font-size:1rem;display:inline-block;border:2px solid #000}
        .button-simular-novamente, .button-simular-novamente:hover{background-color: #000;text-decoration: none;color: #ffc709;}
        .button-simulador--disabled {border-color: #9ca6ac;background: #999;color: #454543;pointer-events: none;}
        @media screen and (min-width:768px){.button-simulador{padding:19px 40px}.button-simular-novamente{padding:19px 40px}}
        @media screen and (max-width: 960px) { .probootstrap-cover{height: 720px !important;}.info-seperator:before {display: none} }
        .info-seperator:before {position: absolute;content: "";top: 5px;bottom: 5px;left: 0;width: 1px;background: #f8f9fa;}
        @media (max-width: 575.98px){.probootstrap-cover{height: 750px !important;}.probootstrap-text {margin-top: 215px;}}
        @media (max-width: 767.98px){.probootstrap-cover{height: 750px !important;}.probootstrap-text {margin-top: 215px;}}
        /**@media (max-width: 991.98px) { body{color:#298fe2; }}
        @media (max-width: 1199.98px) { body{color:#777777; }}
        @media (max-width: 1399.98px){ body{color:#f0ff21; }}*/
        .card-facebook{ background: linear-gradient(145deg,#1877F2 0%,#3578E5 100%);}
        .card-facebook h2 {color: #fff}
        .card-instagram{ background: linear-gradient(145deg,#c40092 0%,#e40031 100%);}
        .card-instagram h2 {color: #fff}
        .card-youtube {background: linear-gradient(145deg, #ff4e45 0%, #c00 100%);}
        .card-youtube h2 {color: #fff}
        .card-whatsapp {background: linear-gradient(145deg, #01e675 0%, #1ebea5 100%);}
        .card-whatsapp h2 {color: #fff}
        .card-telegram {background: linear-gradient(145deg, #2e87ca 0%, #0088cc 100%);}
        .card-telegram h2 {color: #fff}
    </style>
@endsection
@section('content')

    <section class="probootstrap-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="nh-title">Contatos</h2>
                    <p class="text-justify">
                        Nossos canais: Fique por dentro de todos os meios que disponibilizamos para entrarem em contato conosco!
                    </p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-2">
                    <div class="card border card-facebook">
                        <div class="card-body text-center" style="padding: 0.25rem;">
                            <a class="text-white" href="https://www.facebook.com/EloiAlberOficial" target="_blank">
                                <h2><i class="fab fa-facebook"></i> /EloiAlberOficial</h2>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-2 card-instagram">
                        <div class="card-body text-center" style="padding: 0.25rem;">
                            <a href="https://www.instagram.com/ivcompanyoficial" target="_blank">
                                <h2><i class="fab fa-instagram"></i> /ivcompanyoficial</h2>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-2 card-youtube">
                        <div class="card-body text-center" style="padding: 0.25rem;">
                            <a href="https://www.youtube.com/channel/UCh_b9qm83CIjEJuoVDSmj7A" target="_blank">
                                <h2><i class="fab fa-youtube"></i> IV COMPANY</h2>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-2 card-whatsapp">
                        <div class="card-body text-center" style="padding: 0.25rem;">
                            <a href="https://wa.me/message/E334RZ3L6QKWI1" target="_blank">
                                <h2><i class="fab fa-whatsapp"></i> +55 12 98172-3656</h2>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-2 card-telegram">
                        <div class="card-body text-center" style="padding: 0.25rem;">
                            <a href="ttps://t.me/IVCOMPANYCANAL" target="_blank">
                                <h2><i class="fab fa-telegram"></i> Canal Exclusivo</h2>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')


@endpush
