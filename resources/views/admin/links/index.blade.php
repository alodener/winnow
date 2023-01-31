@extends('layouts.admin')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item active"><a href="#">Links</a></li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <section class="probootstrap-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card bg-dark">
                        <div class="card-header">
                            <span class="h5">
                                Links
                            </span>
                            <button type="button" class="btn btn-warning float-right" data-toggle="modal" data-target="#exampleModal">
                                Adicionar
                            </button>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Nome</th>
                                    <th>Link</th>
                                    <th colspan="2">Data</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($links as $l)
                                    <tr>
                                        <td>{{$l->id}}</td>
                                        <td>{{$l->name}}</td>
                                        <td>{{$l->link}}</td>
                                        <td>{{$l->created_at->format('d/m/Y H:i')}}</td>
                                        <td>
                                            <a class="btn btn-info btn-sm editar" href="{{route('admin.links.edit',$l->id)}}">Editar</a>
                                            <button class="btn btn-danger btn-sm deletar" data-id="{{$l->id}}">Deletar</button>
                                        </td>
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar Links</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.links.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for=""class="form-control-label">Nome</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for=""class="form-control-label">Link</label>
                            <input type="text" name="link" class="form-control" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{asset('js/jquery.mask.js')}}" referrerpolicy="origin"></script>
    <script>
        $(document).ready(function(){
            $('.deletar').click(function(){
                var n_id = $(this).data('id');
                swal({
                    title:"Deseja deletar?",
                    text:"",
                    icon:"warning",
                    buttons:['Não!','Sim!'],
                    dangerMode:!0,
                }).then(function(isConfirm){
                    if(isConfirm){
                        $.ajax({
                            url: "/admin/links/deletar/"+n_id,
                            type: 'get',
                            success: function(response){
                                if(response == "success"){
                                    swal("Deletado!", "O Registro foi deletado.", "success");
                                    setTimeout(function() { window.location=window.location;},3000);
                                }
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);
                            }
                        });
                    }else{
                        swal("Cancelado","Ação Cancelada","error")
                    }
                })
            });
        });
    </script>
@endpush
