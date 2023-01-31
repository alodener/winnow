@extends('layouts.app')
@section('title', 'Ticket #'.$ticket->id.'')
@section('content')
    <section class="container">
        @if(Session::has('status'))
            <div class="row mb-3">
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
            </div>
        @endif
        @if(Session::has('status-warning'))
            <div class="row mb-3">
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
            </div>
        @endif
        <div class="row mb-3">
            <div class="col-lg-12 mb-3">
                <a href="{{route('clientTickets')}}" class="btn btn-warning btn-square btn-skew waves-effect waves-light">
                    <span><i class="fa fw fa-arrow-left"></i> Voltar</span>
                </a>
            </div>
            <div class="col-lg-8 offset-2">
                <div class="card bg-dark">
                    <div class="card-body">
                        <div class="col-sm-12 text-white bg-light" style="padding: 15px;">
                            <div class="media">
                                <div class="media-body align-self-center">
                                    <h4 class="mt-0 mb-2 font-16">Ticket Assunto: <span class="badge badge-danger">{{$ticket->subject}}</span></h4>
                                    <ul class="list-inline mb-0 text-muted">
                                        <li class="list-inline-item mr-2">
                                            <span class="text-warning">{!! $ticket->message  !!}</span>
                                        </li>
                                    </ul>
                                </div><!--end media-body-->
                            </div><!--end media-->
                        </div><!--end col-->
                        <br>
                        <div id="ticketMessages">
                            @foreach($ticketResponses as $ticketResponse)
                                @if($ticketResponse->messageBy == 'admin')
                                    <div class="col-sm-12">
                                        <div class="media">
                                            <div class="media-body align-self-center">
                                                <h4 class="mt-0 mb-2 font-16 badge badge-warning">Administrador</h4>
                                                <ul class="list-inline mb-0 text-muted">
                                                    <li class="list-inline-item mr-2">
                                                        <span>{!! $ticketResponse->message  !!}</span>
                                                    </li>
                                                </ul>
                                            </div><!--end media-body-->
                                        </div><!--end media-->
                                    </div><!--end col-->
                                    <br>
                                @else
                                    <div class="col-sm-12">
                                        <div class="media">
                                            <div class="media-body align-self-center">
                                                <h4 class="mt-0 mb-2 font-16 badge badge-primary">Você</h4>
                                                <ul class="list-inline mb-0 text-muted">
                                                    <li class="list-inline-item mr-2">
                                                        <span>{!! $ticketResponse->message  !!}</span>
                                                    </li>
                                                </ul>
                                            </div><!--end media-body-->
                                        </div><!--end media-->
                                    </div><!--end col-->
                                    <br>
                                @endif
                            @endforeach

                            <script>
                                var objDiv = document.getElementById("ticketMessages");
                                objDiv.scrollTop = objDiv.scrollHeight;
                            </script>
                        </div>
                        <hr>
                        <form method="post" action="{{route('replyClientTicket')}}">
                            @csrf
                            <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                            <div class="form-group">
                                <label for="reply">Adicionar Resposta</label>
                                <textarea id="elm1" name="message" rows="5" class="form-control my-editor"></textarea>
                            </div>

                            <button type="submit" class="btn btn-warning">Responder</button>
                        </form>

                    </div><!--end card-body-->
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
