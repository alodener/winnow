@extends('layouts.admin')
@section('title','Pagamento #'.$p->id)
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
            <h2 class="nh-title">Pagamento #{{$p->id}}</h2>
            <div class="card">
                <h5 class="card-header">Status: @if($p->status == '1') <span class="text-success">Aprovado</span> @else <span class="text-warning">Pendente</span> @endif</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
{{--                                <th>Comprovante</th>--}}
{{--                                <th>Ações</th>--}}
                                <th>Usuário</th>
                                <th>Valor R$</th>
                                <th colspan="3">Data</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $comprovantes = \App\Models\Comprovante::where('pagamento_id', $p->id)->get();?>
                            <tr>
{{--                                @forelse($comprovantes as $c)--}}
{{--                                    <td>--}}
{{--                                        <a href="/imagem/comprovantes/{{$c->img_comprovante}}" target="_blank">--}}
{{--                                            @if($c->tipo == 'pdf')--}}
{{--                                                {{$c->img_comprovante}}--}}
{{--                                            @else--}}
{{--                                                <img src="/imagem/comprovantes/{{$c->img_comprovante}}" style="width: 150px;">--}}
{{--                                            @endif--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        @if($p->status != '1')--}}
{{--                                            <form action="{{route('admin.pagamentos.aprovarComprovante',$c->id)}}" method="POST">--}}
{{--                                                @csrf--}}
{{--                                                <input type="hidden" name="comprovante" value="{{$c->id}}">--}}
{{--                                                <input type="hidden" name="pagamento_id" value="{{$c->pagamento_id}}">--}}
{{--                                                <input type="hidden" name="user_id" value="{{$c->user_id}}">--}}
{{--                                                <input type="hidden" name="status" value="1">--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <button type="submit" class="btn btn-primary fluid-btn">Aprovar</button>--}}
{{--                                                </div>--}}
{{--                                            </form>--}}
{{--                                            <form action="{{route('admin.pagamentos.aprovarComprovante',$c->id)}}" method="POST">--}}
{{--                                                @csrf--}}
{{--                                                <input type="hidden" name="comprovante" value="{{$c->id}}">--}}
{{--                                                <input type="hidden" name="pagamento_id" value="{{$c->pagamento_id}}">--}}
{{--                                                <input type="hidden" name="user_id" value="{{$c->user_id}}">--}}
{{--                                                <input type="hidden" name="status" value="3">--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <button type="submit" class="btn btn-warning fluid-btn">Reprovar</button>--}}
{{--                                                </div>--}}
{{--                                            </form>--}}
{{--                                            <form action="{{route('admin.pagamentos.aprovarComprovante',$c->id)}}" method="POST">--}}
{{--                                                @csrf--}}
{{--                                                <input type="hidden" name="comprovante" value="{{$c->id}}">--}}
{{--                                                <input type="hidden" name="pagamento_id" value="{{$c->pagamento_id}}">--}}
{{--                                                <input type="hidden" name="user_id" value="{{$c->user_id}}">--}}
{{--                                                <input type="hidden" name="status" value="5">--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <button type="submit" class="btn btn-danger fluid-btn">Excluír</button>--}}
{{--                                                </div>--}}
{{--                                            </form>--}}
{{--                                        @endif--}}
{{--                                    </td>--}}
{{--                                @empty--}}
{{--                                    <td colspan="2"></td>--}}
{{--                                @endforelse--}}
                                <td>{{$p->users->username}}</td>
                                <td>{{number_format($p->valor,2,'.','')}}</td>
                                <td>{{$p->qtd}}</td>
                                <td>{{$p->created_at->format('d/m/Y H:i')}}</td>
                                <td>
                                    @if($p->status == '0')
                                        <form id="aprovar" action="{{route('admin.pagamentos.ativarFatura',$p->id)}}" method="post" class="mb-3">
                                            @csrf
                                            <button class="btn btn-success">Ativar Fatura</button>
                                        </form>
                                        <form id="aprovarVoucher" action="{{route('admin.pagamentos.ativarPorVoucher',$p->id)}}" method="post" class="mb-3">
                                            @csrf
                                            <button class="btn btn-warning">Ativação por Voucher</button>
                                        </form>
                                        <form id="excluirFatura" action="{{route('admin.pagamentos.delete',$p->id)}}" method="post">
                                            @csrf
                                            <button class="btn btn-danger">Excluir Fatura</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @if($p->descricao)
                                <tr>
                                    <td colspan="5">
                                        {{$p->descricao}}
                                    </td>
                                </tr>
                            @endif
                            <?php $fatura = \App\Models\Fatura::where('pagamento_id',$p->id)->first();?>
                            @if($fatura)
                                <tr>
                                    <td colspan="5">
                                        <h5 class="mb-0">Pagamento via Api</h5>
                                    </td>
                                </tr>
                                <tr>
                                <td colspan="5">
                                    <span class="d-block">TransaçãoID: {{$fatura->transactionID}}</span>
                                    <span class="d-block">valor: {{number_format($fatura->valor,2,',','.')}}</span>
                                    <span class="d-block">Status: {{$fatura->status}}</span>
                                    <span class="d-block">Pix: {{$fatura->pixKey}}</span>
                                    <span class="d-block">Data: {{$fatura->created_at->format('d/m/Y H:i')}}</span>
                                </td>
                            </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
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
                title:"Deseja Ativar essa Fatura!",
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
        document.querySelector('#aprovarVoucher').addEventListener('submit',function(e){
            var form=this;
            e.preventDefault();
            swal({
                title:"Deseja Aprovar por Voucher!",
                text:"",
                icon:"warning",
                buttons:['Não!','Sim!'],
                dangerMode:!0,}).then(function(isConfirm){
                if(isConfirm){
                    form.submit()
                }else{
                    //swal("Ação Cancelada","","error")
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
                    //swal("Ação Cancelada","","error")
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
                    //swal("Ação Cancelada","","error")
                }
            })
        })
        document.querySelector('#excluirFatura').addEventListener('submit',function(e){
            var form=this;
            e.preventDefault();
            swal({
                title:"Deseja excluir essa Fatura!",
                text:"",
                icon:"warning",
                buttons:['Não!','Sim!'],
                dangerMode:!0,}).then(function(isConfirm){
                if(isConfirm){
                    form.submit()
                }else{
                    //swal("Ação Cancelada","","error")
                }
            })
        })
    </script>
@endpush
