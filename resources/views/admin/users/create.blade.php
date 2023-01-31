@extends('layouts.admin')
@section('title','Criar Usuario')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item active"><a href="{{route('admin.index')}}">Home</a></li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <form action="{{route('admin.users.store')}}" method="post">
        @csrf
        <div class="row layout-top-spacing">
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-header">Cadastrar Usuario</div>
                    <div class="card-body text-primary">
                        <div class="mb-3">
                            <label for="">Nome Completo</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror " value="{{old('name')}}" required>
                            @error('name')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror " value="{{old('email')}}" required>
                            @error('email')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="">WhatsApp</label>
                            <input type="text" name="celular" class="form-control @error('whatsapp') is-invalid @enderror whatsapp" value="{{old('cpf')}}" required>
                        </div>
                        <div class="mb-3">
                            <label for="">CPF</label>
                            <input type="text" name="cpf" class="form-control @error('cpf') is-invalid @enderror cpf" value="{{old('cpf')}}" required>
                        </div>
                        <div class="mb-3">
                            <label for="">Login</label>
                            <input type="text" name="username" class="form-control @error('Login') is-invalid @enderror " value="{{old('Login')}}" required>
                            @error('login')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="">Senha</label>
                            <input type="text" name="password" class="form-control @error('password') is-invalid @enderror " required>
                            @error('password')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        Financeiro
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo" value="20" id="flexRadioDefault1" required>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    20%
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo" value="7" id="flexRadioDefault2" required>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    7%
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="">Investimento R$</label>
                            <input type="text" name="investimento" class="form-control valor" value="{{old('investimento')}}" required>
                        </div>
                        <div class="mb-3">
                            <label for="">Validade</label>
                            <input type="date" name="validade" class="form-control" value="{{old('validade')}}">
                        </div>
                        <div class="mb-3">
                            <label for="">Rendimentos R$</label>
                            <input type="text" name="rendimento" class="form-control valor" value="{{old('rendimento')}}" required>
                        </div>
                        <div class="mb-3">
                            <label for="">Saldo Disponivel R$</label>
                            <input type="text" name="saldo" class="form-control valor" value="{{old('saldo')}}" required>
                        </div>
                        <div class="mb-3">
                            <label for="">Ganhos de Afiliados R$</label>
                            <input type="text" name="saldo_indicacao" class="form-control valor" value="{{old('saldo_indicacao')}}" required>
                        </div>
                        <div class="mb-3">
                            <label for="">Ganho Total R$</label>
                            <input type="text" name="ganho_total" class="form-control valor" value="{{old('ganho_total')}}" required>
                        </div>
                        <div class="float-right">
                            <button type="submit" class="btn btn-success">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('js')
    <script src="/js/jquery.mask.js"></script>
    <script>
        (function( $ ) {
            $(function() {
                $('.whatsapp').mask('(00) 0 0000-0000');
                $('.cpf').mask('000.000.000-00', {reverse: true});
                $('.valor').mask('999.999.999,00', {reverse: true});
            });
        })(jQuery);
    </script>
@endpush
