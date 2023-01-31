@extends('layouts.base')
@section('title','Endereço')
@section('styles')

@endsection
@section('content')
    <section class="container">
        <div class="row">
        @include('dashboard.perfil.aside')
        <div class="col-md-8 offset-lg-1 pb-5 mb-2 mb-lg-4 pt-md-5 mt-n3 mt-md-0">
            <div class="ps-md-3 ps-lg-0 mt-md-2 py-md-4">
                <h1 class="h2 pt-xl-1 pb-3">Detalhes da Conta</h1>
                <!-- Basic info -->
                <h2 class="h5 text-primary mb-4">Endereço</h2>
                @if($errors->any())
                    {!! implode('', $errors->all('<span class="text-danger">:message</span>')) !!}
                @endif
                <form action="{{route('dashboard.enderecos.store')}}" method="post" class="">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 d-flex mb-2">
                            <input type="text" name="cep" class="form-control form-control-lg w-50" placeholder="CEP" id="cep" value="{{$endereco == null ? old('cep') : $endereco->cep}}" size="10" maxlength="9" required/>
                            <a href="#" class="color-global text-decoration-none fw-bold small my-auto mx-auto">NÃO SEI O MEU CEP</a>
                        </div>
                        <div class="col-lg-12 mb-2 d-inline-flex">
                            <input type="text" name="rua" class="form-control form-control-lg me-2 w-75" placeholder="RUA" id="rua" value="{{$endereco == null ? old('rua') : $endereco->rua}}" required/>
                            <input type="text" name="n" class="form-control form-control-lg w-25" placeholder="NÚMERO" id="n" value="{{$endereco == null ? old('n') :$endereco->numero}}" />
                        </div>
                        <div class="col-lg-12 mb-2">
                            <input type="text" name="bairro" class="form-control form-control-lg" placeholder="BAIRRO" id="bairro" value="{{$endereco == null ? old('bairro') :$endereco->bairro}}" required/>
                        </div>
                        <div class="col-lg-12 mb-2">
                            <input type="text" name="cidade" class="form-control form-control-lg" placeholder="CIDADE" id="cidade" value="{{$endereco == null ? old('cidade') :$endereco->cidade}}" required/>
                        </div>
                        <div class="col-lg-12 mb-2">
                            <input type="text" name="uf" class="form-control form-control-lg" placeholder="ESTADO" id="uf" value="{{$endereco == null ? old('uf') :$endereco->uf}}" required/>
                        </div>
                        <div class="col-lg-12 mb-2">
                            <input type="text" name="complemento" class="form-control form-control-lg" value="{{$endereco == null ? old('complemento') :$endereco->complemento}}" placeholder="Complemento" id="complemento"/>
                        </div>
                    </div>
                    <div class="pt-3">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"
    ></script>
    <script>
        $(document).ready(function() {
            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#rua").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#uf").val("");
                $("#ibge").val("");
            }

            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#rua").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#uf").val("...");
                        $("#ibge").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#rua").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#uf").val(dados.uf);
                                $("#ibge").val(dados.ibge);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });
    </script>
@endpush
