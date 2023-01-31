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
                <li class="breadcrumb-item active">Lucro(Rendimento)</li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <section class="probootstrap-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="nh-title">Lucro(Rendimento)</h2>
                    <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#notificarUser">
                        <i class="fa fa-plus"></i> Adicionar Lucro
                    </button>
                    <div class="modal fade" id="notificarUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Lucro(Rendimento)</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" action="{{route('admin.configuracoes.bonusLucro.store')}}" method="post">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="span-input">Porcentagem(Ex: 4.5):</label>
                                                <input type="text" name="porcentagem" class="form-control" required="">
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
                    <div class="table-responsive">
                        <table class="table border-primary">
                            <thead class="table-dark">
                            <tr>
                                <th>Afiliado</th>
                                <th>Valor(R$)</th>
                                <th>Data</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($bonus as $b)
                                <tr>
                                    <td>{{$b->users->name}}</td>
                                    <td>{{number_format($b->valor,2,',','.')}}</td>
                                    <td>{{$b->created_at}}</td>
                                </tr>
                            @empty
                                <p>Sem Conta</p>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@push('js')

@endpush
