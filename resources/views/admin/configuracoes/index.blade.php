@extends('layouts.admin')
@section('style')

@endsection
@section('content')
	<div class="rq-tips-tricks">
        <div class="row">
            <h2 class="nh-title">Configurações do Sistema</h2>
            <div class="panel panel-default">
            	<div class="panel-body">
                    <div class="col-md-8">
                		<form method="post" action="{{route('admin.configuracoes.store')}}">
                			@csrf
                			<input type="hidden" name="tipo" value="rendimento">
                			<div class="form-group">
                				<label for="name">Porcentagem de Ganhos</label>
                				<input type="text" name="porcentagem_ganhos_diarios" class="rq-form-control" 
                                    value="{{$configuracao->porcentagem_ganhos_diarios}}">
                			</div>
                            <div class="form-group">
                                <label for="name">Porcentagem de Bônus Recomendação</label>
                                <input type="text" name="porcentagem_indicacao_direta" class="rq-form-control"
                                    value="{{$configuracao->porcentagem_indicacao_direta}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Porcentagem de Bônus Consultoria</label>
                                <input type="text" name="bonus_residual" class="rq-form-control"
                                    value="{{$configuracao->bonus_residual}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Limite de Saque R$</label>
                                <input type="text" name="limite_saque" class="rq-form-control"
                                    value="{{$configuracao->limite_saque}}">
                            </div>                			
    			            <div class="form-group">
    			            	<button type="submit" class="rq-btn rq-btn-transparent">Salvar</button>
    			            </div>
                		</form>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')

@endsection