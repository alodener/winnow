@extends('layouts.app')

@section('content')
  <div class="rq-tips-tricks">
        <div class="row">
            <h2 class="nh-title">Veja quanto os seus investimentos podem render com a Mutual Group</h2>
            <div class="panel">
                <div class="panel-body">
                    <form method="post" >
                        @csrf
                        <input type="hidden" name="tipo" value="assinarcontrato">
                        <div class="col-md-10" style="margin-bottom: 50px;">
                        <label style="color: #12141c" class="simulacao_title"><b>Quanto você deseja investir?</b></label>
                            <input type="number" name="valor" id="valor" value="5000" min="250" max="50000" step="250" class="rq-form-control aaa" aria-label="BRL" style="font-size: 1.5em;">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="element-single">
                <div class="rq-facts-box">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <h2 class="h2-carteira">0.45% ao Dia</h2>
                            <p class="p-carteira">R$ <span id="dia">20,25</span></p>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <h2 class="h2-carteira">9.45% ao Mês</h2>
                            <p class="p-carteira">R$ <span id="semana">425,25</span></p>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <h2 class="h2-carteira">113.85% ao Ano</h2>
                            <p class="p-carteira">R$ <span id="ano">5.123,25</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')
    <script type="text/javascript">
        jQuery(function($) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on("change keyup blur", valor,  function(e){
                e.preventDefault();
                var valor = $("input[name=valor]").val();
                $.ajax({
                    type:'POST',
                    url:'/analise',
                    data:{valor:valor},
                    success:function(data){
                        document.getElementById("dia").innerHTML = data.dia;
                        document.getElementById("semana").innerHTML = data.semana;
                        document.getElementById("ano").innerHTML = data.ano;
                        //document.getElementById("valor").innerHTML = currentVal;
                    }
                });
            });
        });
    </script>
@stop