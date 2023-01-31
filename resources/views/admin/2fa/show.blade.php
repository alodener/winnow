@extends('layouts.admin')

@section('content')
<style>
.badge {
    display: inline-block;
    padding: .5em; /* em unit */
    border-radius: 4%;
    font-size: 15px;
    text-align: center;
    background: #20c75c;
    color: #fefefe;
}
.swal-overlay--show-modal .swal-modal {
    will-change: auto !important;
}
</style>
    <div class="rq-tips-tricks">
        <div class="row">
            <h2 class="nh-title">Remover a Autenticação de Dois Fatores</h2>
            <div class="panel panel-default">
            	<div class="panel-body">
                    <table class="table table-hover ">
                        <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Data</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        <tr>
                            <td>{{$twofa->id}}</td>
                            <td>{{$twofa->user->name}}</td>
                            <td>{{$twofa->created_at->diffForHumans()}}</td> 
                            <td>
                            	<form id="remover" action="{{route('admin.2fa.delete',$twofa->id)}}" method="post">
                            		@csrf
                            		<button class="btn btn-info">Remover</button>
                            	</form>
                            </td>                           
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        document.querySelector('#remover').addEventListener('submit',function(e){
            var form=this;
            e.preventDefault();
            swal({
                title:"Deseja Remover o 2FA desta Conta?",
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
