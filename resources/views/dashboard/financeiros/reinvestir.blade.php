@extends('layouts.base')
@section('title','Reinvestir')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
    <li class="breadcrumb-item active">Reinvestir</li>
@endsection
@section('content')
    <div class="row layout-top-spacing mb-3">
        <div class="col-md-12">
            <div id="pricing-portion" class="element-single">
                <h2 class="nh-title">Reinvestir</h2>
                <div class="card bg-primary">
                    <div class="card-body">
                        <div class="price">
                            <h2><span>Saldo Disponível</span></h2>
                            <h2>R$ {{number_format($wallet->saldo,2,',','.')}}</h2>
                            <p>
                                Valor Mínimo de Reinvestimento R$ 100,00
                            </p>
                        </div>
                        <div class="pricing-details">
                            @if($wallet->saldo >= 100)
                                <form id="reinvestir" action="{{ route('dashboard.financeiros.reinvestir.store') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control valor" id="saques" name="valor" placeholder="Ex.: 100,00"
                                               type="text" required autocomplete="off"/>
                                    </div>
                                    <button class="btn btn-outline-white float-right" type="submit">Reinvestir</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h5>Reinvestimentos</h5>
            <div class="table-responsive">
                <table class="table table-striped custab">
                    <thead>
                    <tr>
                        <th>Valor R$</th>
                        <th>Data</th>
                    </tr>
                    </thead>
                    <?php $total = 0; ?>
                    @foreach($reinvestimentos as $c)
                        <tr>
                            <td>{{number_format($c->valor,2,',','.')}}</td>
                            <td>{{$c->created_at->format('d/m/Y H:i')}}</td>
                        </tr>
                        <?php $total += $c->valor; ?>
                    @endforeach
                    <tr>
                       <td colspan="2">Total de Reinvestimentos: $ {{number_format($total,2,',','.')}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@stop
@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{asset('js/jquery.mask.js')}}" referrerpolicy="origin"></script>
    <script>
        $(document).ready(function() {
            $('.valor').mask('999.999.999,99', {reverse: true});
        });
        document.querySelector('#reinvestir').addEventListener('submit',function(e){
            var form=this;
            e.preventDefault();
            swal({
                title:"Deseja Reinvestir?",
                text:"",
                icon:"warning",
                buttons:['Não!','Sim!'],
                dangerMode:!0,}).then(function(isConfirm){
                if(isConfirm){
                    form.submit()
                }else{
                    //swal("Ação Cancelada","","error")
                }
            })
        })
    </script>
@endpush
