@extends('layouts.base')
@section('title','Carteira')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
    <li class="breadcrumb-item active">Carteira</li>
@endsection
@section('content')
<style>
    .swal-overlay--show-modal .swal-modal {
        will-change: auto !important;
    }
</style>
    <section class="container">
        <div class="row justify-content-center layout-top-spacing mb-3">
            <div class="col-lg-8">
                <h2 class="nh-title">Carteira</h2>
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal" action="{{route('dashboard.contaBancariaSalvar')}}" method="post">
                            {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="col-form-label">Tipo de Conta PIX</label>
                                    <select name="tipo" id="tipo" class="form-control" required>
                                        <option>Selecionar</option>
                                        <option value="cpf">CPF</option>
                                        <option value="cnpj">CNPJ</option>
                                        <option value="email">Email</option>
                                        <option value="celular">Nº Celular</option>
                                        <option value="chave">Chave Aleatória</option>
                                    </select>
                                </div>
                            <div class="form-group">
                                <label class="col-form-label">Chave</label>
                                <input type="text" name="hash" class="form-control" aria-describedby="pixHelp" required/>
                                <div id="pixHelp" class="form-text">Verifique sua Chave PIX se está correta antes de salvar e deverá ser do titular da conta!</div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary border-radius float-end">Salvar <i class="arrow_right"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 mt-3">
            <h2 class="nh-title">Contas Cadastradas</h2>
            <div class="card">
                <div class="card-body">
                    @foreach($contas as $c)
                    <form id="from{{$c->id}}" action="{{route('dashboard.deletarcontabancaria')}}" method="post">
                        @csrf
                        <p>
                            <input type="hidden" name="conta_id" value="{{$c->id}}">
                            <label class="col-form-label d-block">
                                Tipo: {{$c->conta['tipo']}}
                            </label>
                            <label class="form-control-label">
                                <b>PIX:</b> {{$c->conta['hash']}}
                            </label>
                            <button class="btn btn-danger btn-sm float-end">Remover Carteira</button>
                        </p>
                    </form>
                    <script>
                        document.querySelector('#from{{$c->id}}').addEventListener('submit',function(e){var form=this;e.preventDefault();swal({title:"Deseja Remover esta Carteira?",text:"Se você remover essa Carteira em uso, poderá ter problemas futuros!",icon:"warning",buttons:['Não!','Sim!'],dangerMode:!0,}).then(function(isConfirm){if(isConfirm){form.submit()}})})
                    </script>
                    <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endpush
