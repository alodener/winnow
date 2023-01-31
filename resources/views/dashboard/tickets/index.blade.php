@extends('layouts.base')
@section('title', 'Ticket Support')
@section('content')
    <section class="container">
    <div class="row layout-top-spacing">
        @if(Session::has('status'))
            <div class="col-lg-12">
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        <div class="alert-title"><strong>Sucesso!</strong> {{session('status')}}</div>
                    </div>
                </div>
            </div>
        @endif
        @if(Session::has('status-warning'))
            <div class="col-lg-12">
                <div class="alert alert-warning alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        <div class="alert-title"><strong>Atenção!</strong> {{session('status-warning')}}</div>
                    </div>
                </div>
            </div>
        @endif
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">Todos os Tickets</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                <br>
                                <tr>
                                    <th>ID</th>
                                    <th>Assunto</th>
                                    <th>Criado</th>
                                    <th>Atualizado</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($tickets) > 0)
                                    @foreach($tickets as $ticket)
                                        <tr>
                                            <td>{{$ticket->id}}</td>
                                            <td>{{$ticket->subject}}</td>
                                            <td>{{$ticket->created_at->diffForHumans()}}</td>
                                            <td>{{$ticket->updated_at->diffForHumans()}}</td>
                                            @if($ticket->status == 0)
                                                <td><span class="badge bg-yellow">Pendente</span></td>
                                            @else
                                                <td><span class="badge bg-green">Respondido</span></td>
                                            @endif
                                            <td>
                                                <a href="{{route('showClientTicket', $ticket->id)}}"><i class="fa fa-eye font-16"></i></a> |
                                                <a href="{{route('removeClientTicket', $ticket->id)}}"><i class="fa fa-trash text-danger font-16"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table><!--end /table-->

                            {{$tickets->links()}}

                        </div><!--end /tableresponsive-->
                    </div><!--end card-body-->
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">Criar Ticket</div>
                    <div class="card-body">
                        <form method="post" action="{{route('createClientTicket')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="subject">Assunto</label>
                                <input type="text" class="form-control" name="subject" required="">
                            </div>
                            <div class="form-group mb-3">
                                <label for="message">Mensagem</label>
                                <textarea id="elm1" name="message" class="form-control my-editor" rows="5" required=""></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Criar</button>
                        </form>
                    </div>
                </div>
            </div>
    </div>
    </section>
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
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
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
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
@endpush
