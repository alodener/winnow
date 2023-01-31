@extends('layouts.base')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active">Rede de {{abreviarSobrenome($direto->name)}}</li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="row layout-top-spacing mb-3">
        <div class="col-lg-4 mb-1 layout-spacing">
            <div class="widget widget-card-four" style="padding: 15px 12px;">
                <div class="widget-content">
                    <div class="w-content">
                        <div class="w-info">
                            <h6 class="value">{{count($redeIndicados)}}</h6>
                            <p class="" style="font-size: 14px;">DIRETOS</p>
                        </div>
                        <div class="">
                            <div class="w-icon" style="background-color: #28a745;">
                                <i data-feather="users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-1 layout-spacing">
            <div class="widget widget-card-four" style="padding: 15px 12px;">
                <div class="widget-content">
                    <div class="w-content">
                        <div class="w-info">
                            <h6 class="value">{{$indiretosCoun}}</h6>
                            <p class="text-uppercase" style="font-size: 14px;">Total da Rede</p>
                        </div>
                        <div class="">
                            <div class="w-icon" style="background-color: #2196f3;">
                                <i data-feather="users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php
                function abreviarSobrenome($name){
                    $split_name = explode(" ",$name);
                    if(count($split_name) > 2){
                        for($i=1;(count($split_name) - 1) > $i; $i++){
                            if(strlen($split_name[$i]) > 3){
                                $split_name[$i] = substr($split_name[$i],0,1).".";
                            }
                        }
                    }
                    echo implode(" ",$split_name);
                }
            ?>
            <h2 class="nh-title">Rede de {{abreviarSobrenome($direto->name)}}</h2>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Login</th>
                    <th>Nome</th>
                    <th>Rede Total</th>
                    <th>Qualificação</th>
                    <th colspan="2">Data do Cadastro</th>
                </tr>
                </thead>
                <tbody>
                @forelse($redeIndicados as $d)
                    <tr>
                        <td>{{$d->username}}</td>
                        <td>{{abreviarSobrenome($d->name)}}</td>
                        <?php $redeCount = \App\Models\User::where('indicacao',$d->username)->count();?>
                        <td>{{$redeCount}}</td>
                        <td>
                            @if($d->ativo == 1)
                                Ativo
                            @else
                                Novo/Pendente
                            @endif
                        </td>
                        <td>{{$d->created_at->format('d/m/Y')}}</td>
                        <td><a href="{{route('dashboard.redes.redeDireto',$d->username)}}" class="btn btn-warning btn-sm">Visualizar Diretos</a></td>
                    </tr>
                @empty

                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
