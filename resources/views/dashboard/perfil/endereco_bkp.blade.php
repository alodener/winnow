@extends('layouts.base')
@section('title','Endereço')
@section('styles')
    <style>
        ::placeholder{
            font-size: .875em;
        }
    </style>
@endsection
@section('content')
    <div class="row layout-top-spacing">

        <div class="col-lg-9">
            <p class="fw-bold">Endereço</p>
            <hr>
            <div class="card rounded-0">
                <div class="card-body">
                    @if($errors->any())
                        {!! implode('', $errors->all('<span class="text-danger">:message</span>')) !!}
                    @endif
                    <form action="{{route('dashboard.enderecos.store')}}" method="post" class="">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-lg-12 mb-3">
                                <label for="" class="">Nome completo do destinatário</label>
                                <input type="text" name="destinatario" class="form-control rounded-0" value="{{ $endereco == null ? old('destinatario') : $endereco->destinatario}}" required>
                            </div>
                            <div class="col-lg-12">
                                <label for="" class="">CPF</label>
                                <input type="text" name="cpf" id="cpf" class="form-control rounded-0" value="{{ $endereco == null ? old('cpf') : $endereco->cpf}}" required>
                                @error('cpf')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row g-3 mb-2">
                            <div class="col-lg-2 col-md-6 col-sm-2">
                                <div class="mb-2">
                                    <label for="ddd" class="">DDD</label>
                                    <input type="tel" maxlength="2" min="2" max="2" class="form-control rounded-0 ddd" name="ddd" value="{{ $endereco == null ? old('ddd') : $endereco->contato['ddd']}}" required>
                                    @error('ddd')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="mb-2">
                                    <label for="cel" class="">Celular</label>
                                    <input type="tel" maxlength="9" min="9" max="9" class="form-control rounded-0 cel" name="cel" value="{{ $endereco == null ? old('cel') : $endereco->contato['cel']}}" required>
                                    @error('cel')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 d-flex mb-2">
                                <input type="text" name="cep" class="form-control rounded-0 w-50" placeholder="CEP" id="cep" value="{{$endereco == null ? old('cep') : $endereco->cep}}" size="10" maxlength="9" required/>
                                <a href="#" class="color-global text-decoration-none fw-bold small my-auto mx-auto">NÃO SEI O MEU CEP</a>
                            </div>
                            <div class="col-lg-12 mb-2 d-inline-flex">
                                <input type="text" name="rua" class="form-control rounded-0 me-2 w-75" placeholder="RUA" id="rua" value="{{$endereco == null ? old('rua') : $endereco->rua}}" required/>
                                <input type="text" name="n" class="form-control rounded-0 w-25" placeholder="NÚMERO" id="n" value="{{$endereco == null ? old('n') :$endereco->numero}}" />
                            </div>
                            <div class="col-lg-12 mb-2">
                                <input type="text" name="bairro" class="form-control rounded-0" placeholder="BAIRRO" id="bairro" value="{{$endereco == null ? old('bairro') :$endereco->bairro}}" required/>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <input type="text" name="cidade" class="form-control rounded-0" placeholder="CIDADE" id="cidade" value="{{$endereco == null ? old('cidade') :$endereco->cidade}}" required/>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <input type="text" name="uf" class="form-control rounded-0" placeholder="ESTADO" id="uf" value="{{$endereco == null ? old('uf') :$endereco->uf}}" required/>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <input type="text" name="complemento" class="form-control rounded-0" value="{{$endereco == null ? old('complemento') :$endereco->complemento}}" placeholder="Complemento" id="complemento"/>
                            </div>
                        </div>
                        <div class="text-center pt-3">
                            <button type="submit" class="btn btn-dark rounded-0">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    </div>
@endsection
@push('js')
    <script src="/plugins/input-mask/jquery.inputmask.bundle.min.js"></script>
    <script src="/plugins/input-mask/input-mask.js"></script>
    <script>
        $(document).ready(function() {
            $('#cpf').inputmask("999.999.999-99");
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
