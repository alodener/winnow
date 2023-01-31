@extends('layouts.admin')
@section('styles')
    <style>
        .form-control{border:2px solid #000;height:35px;}
    </style>
@endsection
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Arquivos</li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <section class="probootstrap-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="nh-title">Arquivos</h2>
                    <button type="button" class="btn btn-warning float-right" data-toggle="modal" data-target="#adicionarArquivo">
                        <i class="fa fa-plus"></i> Adicionar Arquivo
                    </button>
                    <div class="modal fade" id="adicionarArquivo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Adicionar Arquivos</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" action="{{route('admin.arquivos.store')}}" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="span-input">Arquivo:</label>
                                                <input type="file" name="arquivo" class="form-control" required="">
                                            </div>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
            </div>
            <div class="row pt-3">
                <div class="col">
                    <div class="card bg-dark">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table border-primary">
                                    <thead class="">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Tipo</th>
                                        <th>Tamanho</th>
                                        <th colspan="3">Data</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    function filesize_formatted($file)
                                    {
                                        $bytes = $file;
                                        if ($bytes >= 1073741824) {
                                            return number_format($bytes / 1073741824, 2) . ' GB';
                                        } elseif ($bytes >= 1048576) {
                                            return number_format($bytes / 1048576, 2) . ' MB';
                                        } elseif ($bytes >= 1024) {
                                            return number_format($bytes / 1024, 2) . ' KB';
                                        } elseif ($bytes > 1) {
                                            return $bytes . ' bytes';
                                        } elseif ($bytes == 1) {
                                            return '1 byte';
                                        } else {
                                            return '0 bytes';
                                        }
                                    }
                                    ?>
                                    @forelse($arquivos as $a)
                                        <tr>
                                            <td>{{$a->name}}</td>
                                            <td>
                                                {{$a->tipo}}
                                            </td>
                                            <td>{{filesize_formatted($a->tamanho)}}</td>
                                            <td>{{$a->created_at->format('d/m/Y')}}</td>
                                            <td><a class="btn btn-warning btn-sm" href="{{route('admin.arquivos.show',$a->id)}}"><i class="fa fa-download"></i></a></td>
                                            <td>
                                                <form id="deletar{{$a->id}}" action="{{route('admin.arquivos.destroy',$a->id)}}" method="post">
                                                    <div class="form-row align-items-center">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="col-auto">
                                                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <script>
                                                    document.querySelector('#deletar{{$a->id}}').addEventListener('submit',function(e){var form=this;e.preventDefault();swal({title:"Deseja Deletar esse Arquivo?",text:"...",icon:"warning",buttons:['Não!','Sim!'],dangerMode:!0,}).then(function(isConfirm){if(isConfirm){form.submit()}else{swal("Cancelado","Ação Cancelada","error")}})})
                                                </script>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr><td>Sem Arquivo</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{$arquivos->render()}}
                </div>
            </div>
        </div>
    </section>
@stop
@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script
@endpush
