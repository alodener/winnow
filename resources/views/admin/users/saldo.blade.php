@extends('layouts.admin')
@section('title','Saldo de '.$user->name)
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item "><a href="{{route('admin.users.index')}}">Todos os Usuários</a></li>
                <li class="breadcrumb-item active">Editar Usuário: {{$user->name}}</li>
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
            <h5 class="nh-title">{{$user->name}} <small>(login: {{$user->username}})</small></h5>
            @include('admin.users.menu_users')
            <div class="row">
                <div class="col-md-8">
                    <form class="form-horizontal" action="{{route('admin.users.saldoUpdate',$user->username)}}" method="post">
                        {{ csrf_field() }}

                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <div class="card border-info">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="span-input">Saldo</label>
                                    <input type="text" name="saldo" class="form-control saldo" value="{{number_format($user->wallet[0]['saldo'],2,',','.')}}" autocomplete="off" required>
                                </div>
                                <button type="submit" class="btn btn-info border-radius mt-3">Salvar</button>
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
