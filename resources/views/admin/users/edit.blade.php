@extends('layouts.admin')
@section('title','Editar Usuário')
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
                    <h5 class="nh-title">{{$user->name}} <small>(login: {{$user->username}})</small></h5>
                    @include('admin.users.menu_users')
{{--                    @if ($errors->any())--}}
{{--                        <div class="alert alert-danger">--}}
{{--                            <ul>--}}
{{--                                @foreach ($errors->all() as $error)--}}
{{--                                    <li>{{ $error }}</li>--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    @endif--}}
                        <div class="row">
                            <div class="col-md-8">
                                <form class="form-horizontal" action="{{route('admin.users.update',$user->id)}}" method="post">
                                {{ csrf_field() }}
                                @method('PUT')
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="span-input">Nome Completo</label>
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$user->name}}" required="">
                                                @error('name')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="span-input">Email</label>
                                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{$user->email}}" required="">
                                                @error('email')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="span-input">CPF</label>
                                                <input type="text" name="cpf" class="form-control cpf @error('cpf') is-invalid @enderror" value="{{$user->cpf}}" onkeypress="return numbers(event)" required>
                                                @error('cpf')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="span-input">Celular</label>
                                                <input type="text" name="celular" class="form-control celular @error('celular') is-invalid @enderror" value="{{$user->celular}}" onkeypress="return numbers(event)" required>
                                                @error('celular')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="span-input">Senha</label>
                                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                                                @error('password')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="span-input">Patrocinador</label>
                                                <input type="text" name="indicacao" class="form-control @error('indicacao') is-invalid @enderror" value="{{$user->indicacao}}" required="">
                                                @error('indicacao')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @endif
                                            </div>

                                            <button type="submit" class="btn btn-primary border-radius mt-3">Salvar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <a class="btn btn-secondary mb-2" href="{{route('admin.users.logar',$user->id)}}"><i class="fa fa-sign-in-alt"></i> Logar no Usuário</a>
                                        <a class="btn btn-danger" href="{{route('admin.users.inativar',$user->id)}}"><i class="fa fa-user-slash"></i> Inativar Usuário</a>
                                        <hr>

                                        <?php $indicacao = \App\Models\User::where('username',$user->indicacao)->first();?>
                                        @if($indicacao)
                                        <p class="mb-0">Patrocinador: <a href="{{route('admin.users.edit',$indicacao->id)}}">{{$user->indicacao}}</a></p>
                                        @else
                                            <p>Sem Patrocinador</p>
                                        @endif
                                        <p class="mb-0">Status: {{\App\Classes\VerificaUserAtivo::verificaPagamento($user->id)?'Ativo':'Inativo'}}</p>
                                        <hr>
                                        <p>Último Login: @if($user->last_login != null) {{$user->last_login->diffForHumans()}} @endif </p>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal">
                                            <i class="fa fa-envelope-open-text"></i> Enviar Mensagem
                                        </button>

                                        <div class="modal fade text-left" id="modal">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">
                                                            <strong id="exampleModalLabel" class="modal-title">
                                                                Enviar Mensagem
                                                            </strong>
                                                        </h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="POST" action="{{route('admin.contato.users')}}">
                                                        <div class="modal-body">
                                                            {!! csrf_field() !!}
                                                            <input type="hidden" name="user_id" value="{{$user->id}}">
                                                            <div class="form-group">
                                                                <label for="subject">Assunto</label>
                                                                <input type="text" name="subject" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="message">Mensagem</label>
                                                                <textarea name="message" class="form-control" id="" cols="30" rows="10"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                <button type="subimit" class="btn btn-primary">Enviar</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="">
                                        <form id="excluir" action="{{route('admin.users.destroy',$user->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Deletar Usuário</button>
                                        </form>
                                    </div>
                                </div>
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
        $('.celular').mask('99 9 9999-9999', {reverse: true});
        $('.cpf').mask('999.999.999-99', {reverse: true});
    });
    document.querySelector('#excluir').addEventListener('submit',function(e){
        var form=this;
        e.preventDefault();
        swal({
            title:"Deseja Excluir o Usuário?",
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
