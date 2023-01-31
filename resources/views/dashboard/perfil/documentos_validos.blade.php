@extends('layouts.base')
@section('title','Validação de Documentos')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
    <li class="breadcrumb-item active">Validação de Documentos</li>
@endsection
@section('content')
    <div class="row layout-top-spacing">
        <div class="col-lg">
            <h5 class="nh-title">Validação de Documentos</h5>
            <div class="row">
                <div class="col-md-6">
                    <p class="text-danger">
                    <?php
                    $cpf = \App\Models\ImgDocumento::select('tipo')->where(['user_id'=>Auth::id(),'tipo'=>'CPF'])->first();
                    $rgfrente = \App\Models\ImgDocumento::select('tipo')->where(['user_id'=>Auth::id(),'tipo'=>'RG FRENTE'])->first();
                    $rgverso = \App\Models\ImgDocumento::select('tipo')->where(['user_id'=>Auth::id(),'tipo'=>'RG VERSO'])->first();
                    //$comprovante = \App\Models\ImgDocumento::select('tipo')->where(['user_id'=>Auth::id(),'tipo'=>'COMPROVANTE DE RESIDÊNCIA'])->first();
                    $selfie = \App\Models\ImgDocumento::select('tipo')->where(['user_id'=>Auth::id(),'tipo'=>'SELFIE'])->first();
                    $cnh = \App\Models\ImgDocumento::select('tipo')->where(['user_id'=>Auth::id(),'tipo'=>'CNH'])->first();

                    if(!$cpf && !$cnh){
                        echo "Falta o CPF </br>";
                    }
                    if($cpf){
                        if($rgfrente == null)
                            echo "Falta o RG FRENTE </br>";
                        if($rgverso == null)
                            echo "Falta o RG VERSO </br>";
                    }
                    /*if(!$comprovante)
                        echo "Falta o COMPROVANTE DE RESIDÊNCIA </br>";*/

                    if(!$selfie)
                        echo "Falta o Selfie </br>";
                    ?>
                    </p>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Documentos</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($img_doc as $c)
                            <tr>
                                <td>
                                    <img src="/imagem/documentos/{{$c->img}}" style="width: 150px;">
                                </td>
                                <td>{{$c->tipo}}</td>
                                <td>
                                    @if($c->status == '1')
                                        <p class="badge badge-success">Aprovado</p>
                                    @else
                                        <p class="badge badge-warning">Aguardando Aprovação</p>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <p class="font-weight-bold">Documentos Obrigatórios</p>
                    <form action="{{route('dashboard.validacaoDocumentosStore')}}" method="POST" enctype="multipart/form-data" class="rq-checkout-form" style="padding-top:0px;margin-bottom:0px;">
                        {{ csrf_field() }}
                        <?php
                        //$img_docs = \App\Models\ImgDocumento::where(['user_id'=>auth()->id(),'status'=>"0"])->get();
                        $tipos_dosc = ['CPF','RG FRENTE','RG VERSO','CNH','SELFIE'];
                        ?>
                        <div class="form-group">
                            <label class="span-input">Inserir Documento</label>
                            <select class="form-control" name="tipo" id="">
                                @foreach($tipos_dosc as $key => $value)
                                    <option value="{{$value}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <span id="output"></span>
                            <label class="span-input">Inserir Comprovante</label>
                            <input type="file" id="file" name="imagem" class="form-control small">
                            @error('imagem')
                            <style>
                                .invalid-feedback {display: block;}
                            </style>
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="login-button">
                            <button type="submit" class="btn btn-primary btn-large">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
<script>
  function handleFileSelectSingle(evt) {
    var file = evt.target.files; // FileList object
    var f = file[0]
      // Only process image files.
      if (!f.type.match('image.*')) {
        alert("Image only please....");
      }
      var reader = new FileReader();
      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          // Render thumbnail.
          var span = document.createElement('span');
          span.innerHTML = ['<img class="img-thumbnail" src="', e.target.result,
                            '" title="', escape(theFile.name), '"/>'].join('');
          document.getElementById('output').innerHTML = "";
          document.getElementById('output').insertBefore(span, null);
        };
      })(f);
      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }

  document.getElementById('file').addEventListener('change', handleFileSelectSingle, false);
    function handleFileSelectMulti(evt) {
    var files = evt.target.files; // FileList object
    document.getElementById('outputMulti').innerHTML = "";
    for (var i = 0, f; f = files[i]; i++) {

      // Only process image files.
      if (!f.type.match('image.*')) {
        alert("Image only please....");
      }

      var reader = new FileReader();

      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          // Render thumbnail.
          var span = document.createElement('span');
          span.innerHTML = ['<img class="img-thumbnail" src="', e.target.result,
                            '" title="', escape(theFile.name), '"/>'].join('');
          document.getElementById('outputMulti').insertBefore(span, null);
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
  }
</script>
@endpush
