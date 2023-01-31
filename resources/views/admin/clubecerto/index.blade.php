@extends('layouts.admin')
@section('title','Usuários Clube Certo')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item active"><a href="#">Usuários Clube Certo</a></li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <section class="probootstrap-section">
        <div class="container">
            <div class="row layout-top-spacing">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <span class="h5">
                                Usuários Clube Certo
                            </span>
                        </div>
                        <div class="card-body p-0">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Status</th>
                                    <th colspan="2">Data</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $u)
                                    <tr>
                                        <td>{{$u->users->name}}</td>
                                        <td>
                                            @if($u->status == '0')
                                                Novo
                                            @elseif($u->status == '1')
                                                Ativo
                                            @elseif($u->status == '3')
                                                Inativo
                                            @endif
                                        </td>
                                        <td>{{$u->updated_at->format('d/m/Y H:i')}}</td>
                                        <td>
                                            @if($u->status == '1')
                                                <form id="from{{$u->id}}" action="{{route('admin.clubecerto.inativar',$u->user_id)}}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Inativar</button>
                                                </form>
                                                <script>
                                                    document.querySelector('#from{{$u->id}}').addEventListener('submit',function(e){var form=this;e.preventDefault();swal({title:"Deseja Inativar este Usuário?",text:"",icon:"warning",buttons:['Não!','Sim!'],dangerMode:!0,}).then(function(isConfirm){if(isConfirm){form.submit()}})})
                                                </script>
                                            @elseif($u->status == '3')
                                                <form id="from{{$u->id}}" action="{{route('admin.clubecerto.ativar',$u->user_id)}}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Ativar</button>
                                                </form>
                                                <script>
                                                    document.querySelector('#from{{$u->id}}').addEventListener('submit',function(e){var form=this;e.preventDefault();swal({title:"Deseja Ativar este Usuário?",text:"",icon:"success",buttons:['Não!','Sim!'],dangerMode:!0,}).then(function(isConfirm){if(isConfirm){form.submit()}})})
                                                </script>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$users->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endpush
