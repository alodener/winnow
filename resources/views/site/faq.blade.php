@extends('site.base')
@section('styles')

@endsection
@section('content')
    <section class="probootstrap-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="nh-title">Perguntas frequentes</h2>
                    <p class="text-justify">
                        Reunimos as principais perguntas e as disponibilizamos abaixo, caso ainda não tenha esclarecido a sua dúvida, entre em contato conosco.
                    </p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg">
                    <div class="accordion" id="accordionExample">
                        @foreach($faqs as $f)
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#faq{{$f->id}}" aria-expanded="true" aria-controls="collapseOne">
                                        {{$f->titulo}}
                                    </button>
                                </h2>
                            </div>
                            <div id="faq{{$f->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    {!! $f->body !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')


@endpush
