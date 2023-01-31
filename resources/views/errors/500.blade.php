<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Erro 500 - {{ config('app.name', 'Laravel') }}</title>
    <meta name="theme-color" content="#050D1D">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/pages/error/style-500.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <style>
        body.error500{
            background-color: #0e1726 !important;
            background-image: none;
        }
        .error500 .error-number {
            font-size: 141px;
        }
    </style>
</head>
<body class="error500 text-center">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 mr-auto mt-5 text-md-left text-center">
                <a href="{{route('home')}}" class="ml-md-5">
                    <img alt="image-500" src="/imagem/logo/RolloverFinal.png" class="theme-logo">
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid error-content">
        <div class="">
            <h1 class="error-number">Error 500</h1>
            <p class="mini-text">Ooops!</p>
            <p class="error-text">Houve um problema Interno!</p>
            <p class="error-text">
                @if(isset($msg))
                    {{$msg}}
                @endif
            </p>
            <a href="{{route('home')}}" class="btn btn-secondary mt-5">Voltar!</a>
        </div>
    </div>

<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="/assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="/bootstrap/js/popper.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->
</body>
</html>
