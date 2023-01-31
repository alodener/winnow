@extends('layouts.admin')

@section('content')
<style>
.info, p{
	margin: 0 0 0px;
}
.swal-overlay--show-modal .swal-modal {
    will-change: auto !important;
}
</style>
    <div class="rq-registration-content-single small-bottom-margin">
        <div class="container">
            <div class="rq-login-form no-border">
                <h2 class="nh-title">{{$user->name}} <small>(Código de Usuario: {{$user->username}})</small></h2>
                <div class="col-md-3">
					@include('admin.users.menu_informacoes')                	
                </div>
                <div class="col-md-9 info">
                	<?php $indicacao = \App\Models\User::find($user->indicacao);?>
                	@if($indicacao)
                	<p><b>Indicação:</b> {{$indicacao->name}} (ID: {{$user->indicacao}})</p>
                	@endif
                	<p><b>Nome:</b> {{$user->name}}</p>
                	<p><b>CPF:</b> @if(isset($documento->cpf)) <span class="cpf">{{$documento->cpf}}</span> @endif</p>
                	<p><b>RG:</b> @if(isset($documento->rg)) {{$documento->rg}} @endif</p>
                	<p><b>Nascimento:</b> @if(isset($documento->nascimento)) {{$documento->nascimento->format('d/m/Y')}} @endif</p>
                	<p><b>Nome da Mãe:</b> @if(isset($documento->dados_pessoais['nome_mae'])) {{$documento->dados_pessoais['nome_mae']}} @endif</p>
                	<p><b>Nome do Pai:</b> @if(isset($documento->dados_pessoais['nome_pai'])) {{$documento->dados_pessoais['nome_pai']}} @endif</p>
                	<p><b>Gênero:</b> @if(isset($documento->dados_pessoais['genero'] )) {{$documento->dados_pessoais['genero']}} @endif</p>
                	<p><b>Nacionalidade:</b> @if(isset($documento->dados_pessoais['nacionalidade'])) {{$documento->dados_pessoais['nacionalidade']}} @endif</p>
                	<p><b>Estado Nascimento:</b> @if(isset($documento->dados_pessoais['estado_nascimento'])) {{$documento->dados_pessoais['estado_nascimento']}} @endif </p>
                	<p><b>Cidade Nascimento:</b> @if(isset($documento->dados_pessoais['cidade_nascimento'])) {{$documento->dados_pessoais['cidade_nascimento']}} @endif </p>
                	<p><b>Cônjuge:</b> @if(isset($documento->dados_pessoais['conjuge'])) {{$documento->dados_pessoais['conjuge']}} @endif</p>
                </div>
                <form id="remover" action="{{route('admin.users.destroy',$user->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Remover <i class="fa fa-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
@stop
@section('js')
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        document.querySelector('#remover').addEventListener('submit',function(e){
            var form=this;
            e.preventDefault();
            swal({
                title:"Deseja Remover o Usuário {{$user->name}} ?",
                text:"",
                icon:"warning",
                buttons:['Não!','Sim!'],
                dangerMode:!0,}).then(function(isConfirm){
                    if(isConfirm){
                        form.submit()
                    }else{
                        swal("Cancelado","Ação Cancelada","error")
                    }
                })
            })
        </script>

    
@stop
