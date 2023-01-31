@extends('layouts.admin')
@section('title','Comprovantes')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.pagamentos.pendentes')}}">Pagamentos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Comprovantes</li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="row layout-top-spacing">
            <div class="col-lg">
                <h2 class="nh-title">Comprovantes</h2>
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th>Comprovante</th>
                                <th>Usuário</th>
                                <th>ID Pagamento</th>
                                <th>Valor R$</th>
                                <th>Data</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($comprovantes as $c)
                                <tr>
                                    <td class="text-break">
                                        <a href="/imagem/comprovantes/{{$c->img_comprovante}}" target="_blank">
                                            @if($c->tipo == 'pdf')
                                                {{$c->img_comprovante}}
                                            @else
                                                <img src="/imagem/comprovantes/{{$c->img_comprovante}}" style="width: 150px;">
                                            @endif
                                        </a>
                                    </td>
                                    <td>{{$c->users->username}}</td>
                                    <td>{{$c->pagamento_id}}</td>
                                    <td>{{ number_format($c->pagamentos->valor,2,',','.')}}</td>
                                    <td>{{$c->created_at->format('d/m/Y H:i')}}</td>
                                    <td>
                                        <form id="aprovar" action="{{route('admin.pagamentos.aprovarComprovante',$c->id)}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="comprovante" value="{{$c->id}}">
                                            <input type="hidden" name="pagamento_id" value="{{$c->pagamento_id}}">
                                            <input type="hidden" name="user_id" value="{{$c->user_id}}">
                                            <input type="hidden" name="status" value="1">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary fluid-btn">Aprovar</button>
                                            </div>
                                        </form>
                                        <form id="reprovar" action="{{route('admin.pagamentos.aprovarComprovante',$c->id)}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="comprovante" value="{{$c->id}}">
                                            <input type="hidden" name="pagamento_id" value="{{$c->pagamento_id}}">
                                            <input type="hidden" name="user_id" value="{{$c->user_id}}">
                                            <input type="hidden" name="status" value="3">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-warning fluid-btn">Reprovar</button>
                                            </div>
                                        </form>
                                        <form id="excluir" action="{{route('admin.pagamentos.aprovarComprovante',$c->id)}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="comprovante" value="{{$c->id}}">
                                            <input type="hidden" name="pagamento_id" value="{{$c->pagamento_id}}">
                                            <input type="hidden" name="user_id" value="{{$c->user_id}}">
                                            <input type="hidden" name="status" value="5">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-danger fluid-btn">Excluír</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@stop
@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        document.querySelector('#aprovar').addEventListener('submit',function(e){
            var form=this;
            e.preventDefault();
            swal({
                title:"Deseja Aprovar o Comprovante!",
                text:"",
                icon:"warning",
                buttons:['Não!','Sim!'],
                dangerMode:!0,}).then(function(isConfirm){
                if(isConfirm){
                    form.submit()
                }else{
                    swal("Ação Cancelada","","error")
                }
            })
        })
        document.querySelector('#reprovar').addEventListener('submit',function(e){
            var form=this;
            e.preventDefault();
            swal({
                title:"Deseja Reprovar o Comprovante!",
                text:"",
                icon:"warning",
                buttons:['Não!','Sim!'],
                dangerMode:!0,}).then(function(isConfirm){
                if(isConfirm){
                    form.submit()
                }else{
                    swal("Ação Cancelada","","error")
                }
            })
        })
        document.querySelector('#excluir').addEventListener('submit',function(e){
            var form=this;
            e.preventDefault();
            swal({
                title:"Deseja Excluir o Comprovante!",
                text:"",
                icon:"warning",
                buttons:['Não!','Sim!'],
                dangerMode:!0,}).then(function(isConfirm){
                if(isConfirm){
                    form.submit()
                }else{
                    swal("Ação Cancelada","","error")
                }
            })
        })
    </script>
@endpush
