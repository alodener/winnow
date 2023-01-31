@extends('layouts.admin')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pou-Up's</li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
<section class="probootstrap-section">
    <div class="container">
        <div class="row">
            <div class="col-lg">
                <h2 class="nh-title">Pou-Up's</h2>
                <div class="card panel-default">
                    <div class="card-body">
                        <a href="{{route('admin.pop-ups.create')}}" class="btn btn-primary border-radius" style="float:right;">
                            Inserir Pop-Up
                        </a>
                        <table class="table table-hover ">
                            <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Titulo</th>
                                <th>Conteúdo</th>
                                <th>Imagem</th>
                                <th>Status</th>
                                <th>Tipo</th>
                                <th>Data</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($popups as $f)
                                <tr>
                                    <td>{{$f->id}}</td>
                                    <td>{{$f->title}}</td>
                                    <td>{!! \Str::limit($f->body ,100) !!}</td>
                                    <td>
                                    @if($f->img)
                                        <img src="/imagem/popups/{{$f->img}}" class="img-fluid" alt="" width="250">
                                    @endif
                                    </td>
                                    <td>
                                        @if($f->status == '1')
                                            ativo
                                        @else
                                            desativada
                                        @endif
                                    </td>
                                    <td>{{$f->tipo}}</td>
                                    <td>{{$f->created_at->format('d/m/Y H:i')}}</td>
                                    <td>
                                        <a href="{{route('admin.pop-ups.edit',$f->id)}}" class="btn btn-success" data-toggle="tooltip" title="Editar"><i class="fa fa-pen"></i></a>
                                        <a href="{{route('admin.pop-ups.destroy',$f->id)}}" class="btn btn-danger" data-toggle="tooltip" title="Excluir"
                                           onclick="event.preventDefault();
                            				document.getElementById('excluir-faq').submit();">
                                            <i class="fa fa-trash"></i>
                                            <form id="excluir-faq" action="{{route('admin.pop-ups.destroy',$f->id)}}" method="POST" class="d-none">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE" />
                                            </form>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@stop
@push('js')
	<script>
        $('#excluir').on('submit', function(e){
            var form = this;
            e.preventDefault();
            swal({
                title: "Deseja Excluir?",
                //text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((result) => {
                if (result) {
                    //console.log('aqui');
                    swal("ok!", {
                        icon: "success",
                    });
                    return form.submit();
                    //location.reload();
                }
            })
        });
    </script>
@endpush
