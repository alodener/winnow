@extends('layouts.admin')
@section('title','Saques')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.saques.index')}}">Saques</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pedidos de Saques</li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
        <div class="row layout-top-spacing">
            <div class="col-lg">
                <h2 class="nh-title">Pedido de Saque</h2>
                <div class="table-responsive">
                    <table class="table table-hover ">
                        <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Valor $</th>
                            <th>Data</th>
                            <th>Tipo</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td>{{$saque->id}}</td>
                            <td>{{$saque->users->name}}</td>
                            <td>{{number_format($saque->valor,2,',','.')}}</td>
                            <td>{{$saque->created_at->format('d/m/Y H:i')}}</td>
                            <td>{{$saque->tipo}}</td>
                            <td class="d-inline-flex">
                                @if($saque->ativo == 0)
                                    <form id="aprovar" action="{{route('admin.saques.aprovar',$saque->id)}}" method="post">
                                        @csrf
                                        <button class="btn btn-info mr-2">Aprovar</button>
                                    </form>
                                    <form id="reprovar" action="{{route('admin.saques.reprovar',$saque->id)}}" method="post">
                                        @csrf
                                        <button class="btn btn-danger mr-2">Reprovar</button>
                                    </form>
                                    <form id="estornar" action="{{route('admin.saques.estornar',$saque->id)}}" method="post">
                                        @csrf
                                        <button class="btn btn-warning">Estornar</button>
                                    </form>
                                @elseif($saque->ativo == 1)
                                    <span class="badge">Saque Efetuado</span>
                                @elseif($saque->ativo == 3)
                                    <span class="badge">Saque Reprovado</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                Tipo: <span class="text-uppercase">{{$saque->conta->conta['tipo']}}</span> <br>
                                Chave: {{$saque->conta->conta['hash']}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

@endsection
@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
    document.querySelector('#aprovar').addEventListener('submit',function(e) {
        var form = this;
        e.preventDefault();
        swal({
            title: "Deseja Aprovar este Saque!",
            text: "",
            icon: "warning",
            buttons: ['Não!', 'Sim!'],
            dangerMode: !0,
        }).then(function (isConfirm) {
            if (isConfirm) {
                form.submit()
            } else {
                //swal("Cancelado","Ação Cancelada","error")
            }
        })
    })
    document.querySelector('#reprovar').addEventListener('submit',function(e) {
        var form = this;
        e.preventDefault();
        swal({
            title: "Deseja Reprovar este Saque!",
            text: "",
            icon: "warning",
            buttons: ['Não!', 'Sim!'],
            dangerMode: !0,
        }).then(function (isConfirm) {
            if (isConfirm) {
                form.submit()
            } else {
                //swal("Cancelado","Ação Cancelada","error")
            }
        })
    })
    document.querySelector('#estornar').addEventListener('submit',function(e) {
        var form = this;
        e.preventDefault();
        swal({
            title: "Deseja Estornar este Saque!",
            text: "",
            icon: "warning",
            buttons: ['Não!', 'Sim!'],
            dangerMode: !0,
        }).then(function (isConfirm) {
            if (isConfirm) {
                form.submit()
            } else {
                //swal("Cancelado","Ação Cancelada","error")
            }
        })
    })
    </script>
@endpush
