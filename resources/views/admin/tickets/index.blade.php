@extends('layouts.admin')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item active"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Tickets Suporte</li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <section class="probootstrap-section">
        <div class="container">
    @if(Session::has('status'))
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        <div class="alert-title"><strong>Success!</strong> {{session('status')}}</div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(Session::has('status-warning'))

        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-warning alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        <div class="alert-title"><strong>Warning!</strong> {{session('status-warning')}}</div>
                    </div>
                </div>
            </div>
        </div>

    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="card bg-dark">
                <div class="card-header">Todos os Tickets</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Usário</th>
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
                                        <td><a href="{{route('admin.users.edit', $ticket->users->id)}}">{{$ticket->users->name}}</a></td>
                                        <td>{{$ticket->subject}}</td>
                                        <td>{{$ticket->created_at->diffForHumans()}}</td>
                                        <td>{{$ticket->updated_at->diffForHumans()}}</td>
                                        <td>
                                            @if($ticket->status == 0)
                                                <button type="button" class="btn btn-warning">Pendente</button>
                                            @else
                                                <button type="button" class="btn btn-success">Respondido</button>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('admin.adminShowTicket', $ticket->id)}}"><i class="fa fw fa-eye font-16"></i></a>
                                            |
                                            <a href="{{route('admin.adminRemoveTicket', $ticket->id)}}"><i class="fa fw fa-trash text-danger font-16"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table><!--end /table-->

                        {{$tickets->links()}}

                    </div><!--end /tableresponsive-->
                </div>
            </div>
        </div>
    </div>
        </div>
    </section>
@endsection
