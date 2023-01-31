@extends('layouts.admin')
@section('title','Fatura ')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item "><a href="{{route('admin.users.index')}}">Todos os Usuários</a></li>
                <li class="breadcrumb-item active">Editar Usuário: </li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="col-lg-12">
            <h5 class="nh-title">Fatura de {{$pagamento->users->username}}</h5>
            <a class="btn btn-info mb-3" href="{{route('admin.users.faturas',$pagamento->user_id)}}">Voltar</a>

            <div class="row">
                <div class="col-md-8">
                    <form class="form-horizontal" action="{{route('admin.pagamentos.update',$pagamento->id)}}" method="post">
                        {{ csrf_field() }}
                        <div class="card border-info">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="span-input">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="0" @if($pagamento->status == '0') selected @endif>Nova/Pendente</option>
                                        <option value="1" @if($pagamento->status == '1') selected @endif>Paga</option>
                                        <option value="3" @if($pagamento->status == '3') selected @endif>Expirada</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="">Data</label>
                                    <input type="datetime" name="updated_at" id="updated_at" value="{{$pagamento->updated_at}}" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-info border-radius mt-3">Atualizar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.saldo').mask('999.999.999,99', {reverse: true});
        });

    </script>
@endpush
