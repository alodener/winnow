@extends('layouts.admin')
@section('breadcrumb')
<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <div class="container">
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.produtos.index')}}">Produtos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Criar Produto</li>
        </div>
    </ol>
  </nav>
@endsection
@section('content')
<style>
    .tox-notifications-container{
        display: none;
    }
</style>
<section class="probootstrap-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form class="probootstrap-form" method="post" action="{{route('admin.produtos.update',$plano->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome do Plano</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $plano->name }}" required>
                                @error('name')
                                <span class="" style="color: red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Valor R$</label>
                                <input type="text" class="form-control valor" id="valor" name="valor" value="{{ number_format($plano->valor,2,',','.')}}" required>
                                @error('valor')
                                <span class="" style="color: red" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea name="body" id="basic-example">{{ $plano->body }}</textarea>
                                @error('descricao')
                                <span class="" style="color: red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Imagem</label>
                                <img src="/imagem/planos/{{ $plano->imagem }}" width="150px" alt="">
                                <input type="file" class="form-control" id="imagem" name="imagem">
                                @error('imagem')
                                <span class="" style="color: red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection
@push('js')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="{{asset('js/jquery.mask.js')}}" referrerpolicy="origin"></script>
<script>
    $(document).ready(function(){
        $('.valor').mask('999.999.999,99', {reverse: true});
    });
    tinymce.init({
        selector: 'textarea#basic-example',
        height: 500,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
  </script>

@endpush
