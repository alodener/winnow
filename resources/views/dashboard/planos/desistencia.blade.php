@extends('layouts.app')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active">DESISTÊNCIA</li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <section class="probootstrap-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p>MULTA DE DESISTÊNCIA DE 40% DO CAPITAL</p>
                    @if($pagamento->status == '1')
                    <form id="desistir" action="{{route('dashboard.produtos.desistenciaStore',$pagamento->id)}}" method="post" class="mb-3">
                        @csrf
                        <div class="mb-3 pt-3">
                            <input id="optionsRadios2" type="radio" value="option2" name="optionsRadios" required>
                            <label for="optionsRadios2">Eu aceito os  <a href="{{route('site.termos')}}" target="_blank">Termos e Condições</a></label>
                        </div>
                        <button class="btn btn-warning">Desistir</button>
                    </form>
                    @elseif($pagamento->status == '5')
                        <p>Já Solicitado a Desistência da Licença</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        document.querySelector('#desistir').addEventListener('submit',function(e){
            var form=this;
            e.preventDefault();
            swal({
                title:"Deseja DESISTIR da sua Licença!",
                text:"{{$pagamento->planos->name}}",
                icon:"warning",
                buttons:['Não!','Sim!'],
                dangerMode:!0,}).then(function(isConfirm){
                if(isConfirm){
                    form.submit()
                }else{
                    swal("Cancelado","Ação Cancelada","error")
                }
            })
        });
    </script>
@endpush
