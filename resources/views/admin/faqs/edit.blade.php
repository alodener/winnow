@extends('layouts.admin')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.faqs.index')}}">FAQ's</a></li>
                <li class="breadcrumb-item active" aria-current="page">Editar Faq</li>
            </div>
        </ol>
    </nav>
@endsection
@section('style')
<style>
  .mce-notification-warning {display: none;}
</style>
@endsection
@section('content')
<section class="probootstrap-section">
    <div class="container">
        <div class="row">
            <div class="col-lg">
                <h2 class="nh-title">FAQ</h2>
                <div class="card bg-dark">
                    <div class="card-body">
                        <form method="post" action="{{route('admin.faqs.update',$faq->id)}}">
                            @csrf
                            <input type="hidden" name="_method" value="PUT"/>
                            <input type="hidden" name="tipo" value="rendimento">
                            <div class="form-group">
                                <label for="name">Titulo</label>
                                <input type="text" name="titulo" class="form-control reverse" value="{{$faq->titulo}}">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Categoria</label>
                                <select name="categoria" class="form-control">
                                    <option value="{{$faq->categoria}}">{{$faq->categoria}}</option>
                                    <option value="financas">Finanças</option>
                                    <option value="suporte-tecnico">Suporte Técnico</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Descrição</label>
                                <textarea name="body" class="form-control my-editor" rows="15">{{$faq->body}}</textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('js')

  <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>
    <script>
    var editor_config = {
      path_absolute : "/",
      selector: "textarea.my-editor",
      plugins: [
        "advlist autolink lists link charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
      relative_urls: false,
      file_browser_callback : function(field_name, url, type, win) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

        var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
        if (type == 'image') {
          cmsURL = cmsURL + "&type=Images";
        } else {
          cmsURL = cmsURL + "&type=Files";
        }

        tinyMCE.activeEditor.windowManager.open({
          file : cmsURL,
          title : 'Filemanager',
          width : x * 0.8,
          height : y * 0.8,
          resizable : "yes",
          close_previous : "no"
        });
      }
    };
    tinymce.init(editor_config);
    </script>
@endsection
