@extends('layouts.base')
@section('title','Rede')
@section('styles')
    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="/assets2/css/components/tabs-accordian/custom-accordions.css" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
    <li class="breadcrumb-item active">Rede</li>
@endsection
@section('content')
    <section class="container">
    <div class="row layout-top-spacing">
        <div class="col-lg-6 mb-1 layout-spacing">
            <div class="p-3 bg-body shadow-sm rounded border border-1">
                <div class="d-flex justify-content-between">
                    <div class="float-start">
                        <h5 class="value">{{$ativosCount}}</h5>
                        <p class="mb-0" style="font-size: 14px;">DIRETOS ATIVOS</p>
                    </div>
                    <div class="float-end d-inline-block bg-success shadow-success rounded-3 p-3">
                        <i class="fa fa-users d-block text-white" style="font-size: 2rem"></i>
                    </div>
                </div>
            </div>
        </div>
{{--        <div class="col-lg-4 mb-1 layout-spacing">--}}
{{--            <div class="p-3 bg-body shadow-sm rounded border border-1">--}}
{{--                <div class="d-flex justify-content-between">--}}
{{--                    <div class="float-start">--}}
{{--                        <h5 class="value">{{$pendentesCount}}</h5>--}}
{{--                        <p class="mb-0" style="font-size: 14px;">DIRETOS ATIVOS</p>--}}
{{--                    </div>--}}
{{--                    <div class="float-end d-inline-block bg-warning shadow-warning rounded-3 p-3">--}}
{{--                        <i class="fa fa-users d-block text-white" style="font-size: 2rem"></i>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="col-lg-6 mb-1 layout-spacing">
            <div class="p-3 bg-body shadow-sm rounded border border-1">
                <div class="d-flex justify-content-between">
                    <div class="float-start">
                        <h5 class="value">{{$indiretosCoun}}</h5>
                        <p class="mb-0 text-uppercase" style="font-size: 14px;">Total da Rede</p>
                    </div>
                    <div class="float-end d-inline-block bg-info shadow-info rounded-3 p-3">
                        <i class="fa fa-users d-block text-white" style="font-size: 2rem"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <h2 class="text-white">Diretos</h2>
            <?php
                $indicados = \App\Models\User::select('id','name','username','email','indicacao','ativo')->where('indicacao',auth()->user()->username)->get();
                $nivel_dois = [];
                $nivel_tres = [];
                $nivel_quatro = [];
                $nivel_cinco = [];
                $nivel_seis = [];
                $nivel_sete = [];
                $nivel_oito = [];
            ?>
            <div id="toggleAccordion">
                <div class="card bg-body border border-1">
                    <div class="card-header" id="nivel1">
                        <section class="mb-0 mt-0 bg-body">
                            <div role="menu" class="collapsed fw-bold text-dark" data-bs-toggle="collapse" data-bs-target="#defaultAccordionOne" aria-expanded="true" aria-controls="defaultAccordionOne">
                                Nível #1  <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                            </div>
                        </section>
                    </div>

                    <div id="defaultAccordionOne" class="collapse p-0" aria-labelledby="nivel1" data-parent="#toggleAccordion">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table rounded mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Login</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($indicados as $i)
                                        <tr>
                                            <td>{{$i->name}}</td>
                                            <td>{{$i->username}}</td>
                                            <td>{{$i->email}}</td>
                                            <td>{{\App\Classes\VerificaUserAtivo::verificaPagamento($i->id)?'Ativo':'Inativo'}}</td>
                                        </tr>
                                        <?php
                                            $nivel2 = \App\Models\User::select('id','name','username','email','indicacao','ativo')->where('indicacao',$i->username)->get();
                                            foreach ($nivel2 as $n){
                                                $nivel_dois[] = ['id'=>$n->id,'name'=>$n->name,'username'=>$n->username,'email'=>$n->email,'indicacao'=>$n->indicacao,'ativo'=>$n->ativo];
                                            }
                                        ?>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-body border border-1">
                    <div class="card-header" id="nivel2">
                        <section class="mb-0 mt-0 bg-body">
                            <div role="menu" class="collapsed fw-bold text-dark" data-bs-toggle="collapse" data-bs-target="#defaultAccordionTwo" aria-expanded="true" aria-controls="defaultAccordionTwo">
                                Nível #2  <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                            </div>
                        </section>
                    </div>

                    <div id="defaultAccordionTwo" class="collapse p-0" aria-labelledby="nivel2" data-parent="#toggleAccordion">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table rounded mb-0">
                                    <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Login</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $nivel2Array = json_decode(json_encode($nivel_dois),true); ?>
                                    @foreach($nivel2Array as $i)
                                        <tr>
                                            <td>
                                                {{$i['name']}}
                                                <span class="d-block small">Patrocinador: {{$i['indicacao']}}</span>
                                            </td>
                                            <td>{{$i['username']}}</td>
                                            <td>{{$i['email']}}</td>
                                            <td>{{\App\Classes\VerificaUserAtivo::verificaPagamento($i['id'])?'Ativo':'Inativo'}}</td>
                                        </tr>
                                            <?php
                                            $nivel3 = \App\Models\User::select('id','name','username','email','indicacao','ativo')->where('indicacao',$i['username'])->get();
                                            foreach ($nivel3 as $i){
                                                $nivel_tres[] = ['id'=>$i->id,'name'=>$i->name,'username'=>$i->username,'email'=>$i->email,'indicacao'=>$i->indicacao,'ativo'=>$i->ativo];
                                            }
                                            ?>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-body border border-1">
                    <div class="card-header" id="nivel3">
                        <section class="mb-0 mt-0 bg-body">
                            <div role="menu" class="collapsed fw-bold text-dark" data-bs-toggle="collapse" data-bs-target="#defaultAccordionTree" aria-expanded="true" aria-controls="defaultAccordionTree">
                                Nível #3  <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                            </div>
                        </section>
                    </div>

                    <div id="defaultAccordionTree" class="collapse p-0" aria-labelledby="nivel3" data-parent="#toggleAccordion">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table rounded mb-0">
                                    <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Login</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $nivel3Array = json_decode(json_encode($nivel_tres),true); ?>
                                    @foreach($nivel3Array as $i)
                                        <tr>
                                            <td>
                                                {{$i['name']}}
                                                <span class="d-block small">Patrocinador: {{$i['indicacao']}}</span>
                                            </td>
                                            <td>{{$i['username']}}</td>
                                            <td>{{$i['email']}}</td>
                                            <td>{{\App\Classes\VerificaUserAtivo::verificaPagamento($i['id'])?'Ativo':'Inativo'}}</td>
                                        </tr>
                                            <?php
                                            $nivel4 = \App\Models\User::select('id','name','username','email','indicacao','ativo')->where('indicacao',$i['username'])->get();
                                            foreach ($nivel4 as $i){
                                                $nivel_quatro[] = ['id'=>$i->id,'name'=>$i->name,'username'=>$i->username,'email'=>$i->email,'indicacao'=>$i->indicacao,'ativo'=>$i->ativo];
                                            }
                                            ?>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-body border border-1">
                    <div class="card-header" id="nivel4">
                        <section class="mb-0 mt-0 bg-body">
                            <div role="menu" class="collapsed fw-bold text-dark" data-bs-toggle="collapse" data-bs-target="#defaultAccordionFour" aria-expanded="true" aria-controls="defaultAccordionFour">
                                Nível #4  <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                            </div>
                        </section>
                    </div>

                    <div id="defaultAccordionFour" class="collapse p-0" aria-labelledby="nivel4" data-parent="#toggleAccordion">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table rounded mb-0">
                                    <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Login</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $nivel4Array = json_decode(json_encode($nivel_quatro),true); ?>
                                    @foreach($nivel4Array as $i)
                                        <tr>
                                            <td>
                                                {{$i['name']}}
                                                <span class="d-block small">Patrocinador: {{$i['indicacao']}}</span>
                                            </td>
                                            <td>{{$i['username']}}</td>
                                            <td>{{$i['email']}}</td>
                                            <td>{{\App\Classes\VerificaUserAtivo::verificaPagamento($i['id'])?'Ativo':'Inativo'}}</td>
                                        </tr>
                                            <?php
                                            $nivel5 = \App\Models\User::select('id','name','username','email','indicacao','ativo')->where('indicacao',$i['username'])->get();
                                            foreach ($nivel5 as $i){
                                                $nivel_cinco[] = ['id'=>$i->id,'name'=>$i->name,'username'=>$i->username,'email'=>$i->email,'indicacao'=>$i->indicacao,'ativo'=>$i->ativo];
                                            }
                                            ?>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-body border border-1">
                    <div class="card-header" id="nivel5">
                        <section class="mb-0 mt-0 bg-body">
                            <div role="menu" class="collapsed fw-bold text-dark" data-bs-toggle="collapse" data-bs-target="#defaultAccordionFive" aria-expanded="true" aria-controls="defaultAccordionFive">
                                Nível #5  <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                            </div>
                        </section>
                    </div>

                    <div id="defaultAccordionFive" class="collapse p-0" aria-labelledby="nivel5" data-parent="#toggleAccordion">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table rounded mb-0">
                                    <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Login</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $nivel5Array = json_decode(json_encode($nivel_cinco),true); ?>
                                    @foreach($nivel5Array as $i)
                                        <tr>
                                            <td>
                                                {{$i['name']}}
                                                <span class="d-block small">Patrocinador: {{$i['indicacao']}}</span>
                                            </td>
                                            <td>{{$i['username']}}</td>
                                            <td>{{$i['email']}}</td>
                                            <td>{{\App\Classes\VerificaUserAtivo::verificaPagamento($i['id'])?'Ativo':'Inativo'}}</td>
                                        </tr>
                                            <?php
                                            $nivel6 = \App\Models\User::select('id','name','username','email','indicacao','ativo')->where('indicacao',$i['username'])->get();
                                            foreach ($nivel6 as $i){
                                                $nivel_seis[] = ['id'=>$i->id,'name'=>$i->name,'username'=>$i->username,'email'=>$i->email,'indicacao'=>$i->indicacao,'ativo'=>$i->ativo];
                                            }
                                            ?>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-body border border-1">
                    <div class="card-header" id="nivel6">
                        <section class="mb-0 mt-0 bg-body">
                            <div role="menu" class="collapsed fw-bold text-dark" data-bs-toggle="collapse" data-bs-target="#defaultAccordionSix" aria-expanded="true" aria-controls="defaultAccordionSix">
                                Nível #6  <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                            </div>
                        </section>
                    </div>

                    <div id="defaultAccordionSix" class="collapse p-0" aria-labelledby="nivel6" data-parent="#toggleAccordion">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table rounded mb-0">
                                    <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Login</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $nivel6Array = json_decode(json_encode($nivel_seis),true); ?>
                                    @foreach($nivel6Array as $i)
                                        <tr>
                                            <td>
                                                {{$i['name']}}
                                                <span class="d-block small">Patrocinador: {{$i['indicacao']}}</span>
                                            </td>
                                            <td>{{$i['username']}}</td>
                                            <td>{{$i['email']}}</td>
                                            <td>{{\App\Classes\VerificaUserAtivo::verificaPagamento($i['id'])?'Ativo':'Inativo'}}</td>
                                        </tr>
                                            <?php
                                            $nivel7 = \App\Models\User::select('id','name','username','email','indicacao','ativo')->where('indicacao',$i['username'])->get();
                                            foreach ($nivel7 as $i){
                                                $nivel_sete[] = ['id'=>$i->id,'name'=>$i->name,'username'=>$i->username,'email'=>$i->email,'indicacao'=>$i->indicacao,'ativo'=>$i->ativo];
                                            }
                                            ?>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-body border border-1">
                    <div class="card-header" id="nivel7">
                        <section class="mb-0 mt-0 bg-body">
                            <div role="menu" class="collapsed fw-bold text-dark" data-bs-toggle="collapse" data-bs-target="#defaultAccordionSeven" aria-expanded="true" aria-controls="defaultAccordionSeven">
                                Nível #7  <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                            </div>
                        </section>
                    </div>

                    <div id="defaultAccordionSeven" class="collapse p-0" aria-labelledby="nivel7" data-parent="#toggleAccordion">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table rounded mb-0">
                                    <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Login</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $nivel7Array = json_decode(json_encode($nivel_sete),true); ?>
                                    @foreach($nivel7Array as $i)
                                        <tr>
                                            <td>
                                                {{$i['name']}}
                                                <span class="d-block small">Patrocinador: {{$i['indicacao']}}</span>
                                            </td>
                                            <td>{{$i['username']}}</td>
                                            <td>{{$i['email']}}</td>
                                            <td>{{\App\Classes\VerificaUserAtivo::verificaPagamento($i['id'])?'Ativo':'Inativo'}}</td>
                                        </tr>
                                            <?php
                                            $nivel8 = \App\Models\User::select('id','name','username','email','indicacao','ativo')->where('indicacao',$i['username'])->get();
                                            foreach ($nivel8 as $i){
                                                $nivel_oito[] = ['id'=>$i->id,'name'=>$i->name,'username'=>$i->username,'email'=>$i->email,'indicacao'=>$i->indicacao,'ativo'=>$i->ativo];
                                            }
                                            ?>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-body border border-1">
                    <div class="card-header" id="nivel8">
                        <section class="mb-0 mt-0 bg-body">
                            <div role="menu" class="collapsed fw-bold text-dark" data-bs-toggle="collapse" data-bs-target="#defaultAccordionEight" aria-expanded="true" aria-controls="defaultAccordionEight">
                                Nível #8  <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                            </div>
                        </section>
                    </div>

                    <div id="defaultAccordionEight" class="collapse p-0" aria-labelledby="nivel8" data-parent="#toggleAccordion">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table rounded mb-0">
                                    <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Login</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $nivel8Array = json_decode(json_encode($nivel_oito),true); ?>
                                    @foreach($nivel8Array as $i)
                                        <tr>
                                            <td>
                                                {{$i['name']}}
                                                <span class="d-block small">Patrocinador: {{$i['indicacao']}}</span>
                                            </td>
                                            <td>{{$i['username']}}</td>
                                            <td>{{$i['email']}}</td>
                                            <td>{{\App\Classes\VerificaUserAtivo::verificaPagamento($i['id'])?'Ativo':'Inativo'}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </section>
@endsection
@push('js')
    <script src="/assets2/js/components/ui-accordions.js"></script>
@endpush
