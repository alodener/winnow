@extends('layouts.base')
@section('title','Perfil')
@section('content')
    <section class="container">
        <div class="row">
            @include('dashboard.perfil.aside')
            <div class="col-md-8 offset-lg-1 pb-5 mb-2 mb-lg-4 pt-md-5 mt-n3 mt-md-0">
                <div class="ps-md-3 ps-lg-0 mt-md-2 py-md-4">
                    <h1 class="h2 pt-xl-1 pb-3">Detalhes da Conta</h1>
                    <?php ?>
                    <h2 class="h5 text-primary mb-4">Informações Básicas</h2>
                    <form action="{{route('dashboard.perfil.update')}}" method="post" class="needs-validation border-bottom pb-3 pb-lg-4" novalidate>
                        {{ csrf_field() }}
                        <div class="row pb-2">
                            <div class="col-sm-8 mb-4">
                                <label for="name" class="form-label fs-base">Nome Completo</label>
                                <input type="text" name="name" id="name" class="form-control form-control-lg" value="{{Auth::user()->name}}" required>
                                <div class="invalid-feedback">Por favor insira seu nome completo</div>
                            </div>
                            <div class="col-sm-6 mb-4">
                                <label for="cpf" class="form-label fs-base">CPF <small class="text-muted">(obrigatório)</small></label>
                                <input type="text" name="cpf" id="cpf" class="form-control form-control-lg cpf" value="{{Auth::user()->cpf}}" required>
                            </div>
                            <div class="col-sm-8 mb-4">
                                <label for="email" class="form-label fs-base">Email</label>
                                <input type="email" id="email" class="form-control form-control-lg" value="{{Auth::user()->email}}" required>
                                <div class="invalid-feedback">Please provide a valid email address!</div>
                            </div>
                            <div class="col-sm-6 mb-4">
                                <label for="phone" class="form-label fs-base">Tel</label>
                                <input type="text" name="celular" id="phone" class="form-control form-control-lg celular" value="{{Auth::user()->celular}}" required>
                            </div>
                            <div class="col-sm-8 mb-3">
                                <label for="password" class="form-label fs-base">Senha</label>
                                <input id="password" type="password" class="form-control form-control-lg"
                                       name="password" autocomplete="new-password">

                            </div>
                            <div class="col-sm-8 mb-3">
                                <label for="password-confirm" class="form-label fs-base">Repita a Senha</label>
                                <input id="password-confirm" type="password" class="form-control form-control-lg"
                                       name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <button type="submit" class="btn btn-primary float-end">Salvar</button>
                        </div>
                    </form>

                    <!-- Delete account -->
                    <h2 class="h5 text-primary pt-1 pt-lg-3 mt-4">Exclusão de Conta</h2>
                    <p>
                        Ao excluir sua conta, seu perfil público será desativado imediatamente. Se mudar de ideia antes dos 14 dias, faça login com seu e-mail e senha e enviaremos um link para reativar sua conta.
                    </p>
                    <div class="form-check mb-4">
                        <input type="checkbox" id="delete-account" class="form-check-input">
                        <label for="delete-account" class="form-check-label fs-base">Sim, quero deletar minha conta</label>
                    </div>
                    <button type="button" class="btn btn-danger">Deletar Conta</button>
                </div>
            </div>
        </div>
    </section>
@stop
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.celular').mask('99 9 9999-9999', {reverse: true});
            $('.cpf').mask('999.999.999-99', {reverse: true});
        });
        function numbers(e) {
            var charCode = e.charCode ? e.charCode : e.keyCode;
            if (charCode != 8 && charCode != 9) {
                if (charCode < 48 || charCode > 57) {
                    return false;
                }
            }
        }
    </script>
@endpush
