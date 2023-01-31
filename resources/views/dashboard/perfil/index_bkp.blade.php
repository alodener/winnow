@extends('layouts.base')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
    <li class="breadcrumb-item active">Editar Perfil: {{Auth::user()->name}}</li>
@endsection
@section('content')
    <section class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="nh-title">{{Auth::user()->name}} <small>(login: {{Auth::user()->username}})</small></h2>
                <!--@include('dashboard.perfil.menu_perfil')-->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="form-horizontal" action="/perfil" method="post">
                    {{ csrf_field() }}
                    <div class="mb-3">
                        <label class="label">Nome Completo</label>
                        <input type="text" name="name" class="form-control" value="{{Auth::user()->name}}" required="">
                    </div>
                    <div class="mb-3">
                        <label class="span-input">Email</label>
                        <input class="form-control" value="{{Auth::user()->email}}" disabled="">
                    </div>
                    <div class="mb-3">
                        <label class="span-input">CPF</label>
                        <input type="text" name="cpf" class="form-control cpf" value="{{Auth::user()->cpf}}" onkeypress="return numbers(event)" required>
                    </div>
                    <div class="mb-3">
                        <label class="span-input">Celular</label>
                        <input type="text" name="celular" class="form-control celular" value="{{Auth::user()->celular}}" placeholder="Celular" onkeypress="return numbers(event)" required>
                    </div>
                    <div class="mb-3">
                        <label class="span-input">Senha</label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="mb-3">
                        <label for="">Repita a Senha</label>
                        <input id="password-confirm" type="password" class="form-control"
                               name="password_confirmation" autocomplete="new-password" placeholder="Repita a Senha">
                    </div>
                    <button type="submit" class="btn btn-primary border-radius float-end">Salvar</button>
                </form>
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
