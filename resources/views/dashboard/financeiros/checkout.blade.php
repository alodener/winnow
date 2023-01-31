<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pagamento</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 mt-3 text-center">
                <div class="p-1 border rounded shadow-sm bg-body">
                    <img src="/imagem/logo/logo_full.png" width="250" class="img-fluid" alt="">
                    <div class="pg" style="display: block">
                        <h4>Pagar R$ {{number_format($fatura->valor,2,',','.')}} EDU PASS via Pix</h4>
                        <p class="d-none d-sm-block mb-1" style="font-size: 0.8em">Abra o app do seu banco, escaneie a imagem ou cole o código QR Code</p>
                        <img src="{{$fatura->qrCodeImage}}" class="mx-auto border border-success border-5 d-none d-sm-block mb-3" style="width: 18rem" alt="">
                        <button class="btn btn-primary mb-1" id="copy" data-clipboard-target="#pix">
                            <i class="far fa-copy"></i> COPIAR CÓDIGO QR CODE
                        </button>
                        <p class="mt-2 mb-0 font-weight-bold">Prazo de Pagamento</p>
                        <span><i class="fa fa-clock" style="color: #0ba360"></i> <span id="demo"></span></span>
                        <h5 class="font-weight-bold mt-2">Detalhes da Transação</h5>
                    </div>
                    <div class="expirado" style="display: none">
                        <i class="fa fa-exclamation-circle" style="font-size: 12rem;color: red"></i>
                        <h3 class="font-weight-bold">Cobrança expirada</h3>
                        <p class="mb-0">O prazo para pagamento dessa cobrança expirou.</p>
                        <p class="font-weight-bold mb-1">Valor</p>
                        <p>R$ {{number_format($fatura->valor,2,',','.')}}</p>
                    </div>
                    <p class="font-weight-bold mb-0">Destinatário</p>
                    <span>SMART PAY INTERMEDIAÇOES</span>
                    <p class="font-weight-bold mt-2 mb-0">Identificador</p>
                    <span>{{$fatura->transactionID}}</span>

                    <h5 class="mt-3 font-weight-bold">Como funciona?</h5>
                    <ul class="text-left" style="font-size: 0.8em">
                        <li>1º - Abra o app do seu banco</li>
                        <li>2º - Escolha pagar via Pix</li>
                        <li>3º - Copie e cole o código do pagamento ou escaneie o QR Code</li>
                    </ul>
                    <span class="text-muted">Pagamento 100% seguro via OpenPix</span>
                    <p class="mb-0 text-break" id="pix" style="opacity: 0;">{{$fatura->brCode}}</p>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets2/js/libs/jquery-3.1.1.min.js"></script>
    <script src="/bootstrap/js/popper.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script defer src="/js/all.js"></script>
    <script src="{{asset('js/clipboard.min.js')}}"></script>
    <script>
        new ClipboardJS('#copy');
        var countDownDate = new Date("{{$fatura->expires_at->isoFormat('MM D, YYYY HH:mm:ss')}}").getTime();
        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countDownDate - now;
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo").innerHTML = "EXPIRADO";
                $(".pg").css("display", "none");
                $(".expirado").css("display", "block");
            }else{
                $(".pg").css("display", "block");
                $(".expirado").css("display", "none");
                document.getElementById("demo").innerHTML ='' +
                    minutes+'m '+seconds + 's';
            }
        }, 1000);
        function charger() {
            setTimeout( function(){
                $.ajax({
                    url : "{{route('dashboard.pagamentos.checkStatus',$fatura->transactionID)}}",
                    type : "GET",
                    success : function(data){
                        //console.clear();
                        //console.log(data);
                        if(data == 1){
                            window.location.href = "{{route('dashboard.verPagamento',$fatura->pagamento_id)}}";
                        }
                    }
                });
                charger();
            },5000);
        }
        charger();
    </script>
</body>
</html>
