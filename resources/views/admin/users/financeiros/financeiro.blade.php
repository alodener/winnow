@extends('layouts.admin')
@section('title','Financeiro de '.$user->name)
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item "><a href="{{route('admin.users.index')}}">Todos os Usuários</a></li>
                <li class="breadcrumb-item active">Editar Usuário: {{$user->name}}</li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

            <div class="row layout-top-spacing">
                <div class="col-lg-12">
                    <h5 class="nh-title">Histórico Financeiro de <small>{{$user->username}}</small></h5>
                    @include('admin.users.menu_users')
                    <div class="card border-info">
                        <div class="card-body">
                            <p><b>Pagamento:</b> ${{number_format($pagamentos,2,'.','')}} <b>Ganhos:</b> ${{number_format($ganhos,2,'.','')}}</p>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#ID</th>
                                            <th>Tipo</th>
                                            <th>Valor $</th>
                                            <th>Descrição</th>
                                            <th>Bônus</th>
                                            <th>Data</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 14px">
                                    <?php
                                        $ganhosSum = 0;
                                        $pagamentosSum = 0;
                                    ?>
                                    @forelse($financeiros as $f)
                                        <?php
                                            if($f->tipo == '1'){
                                                $pagamentosSum += $f->valor;
                                            }elseif($f->tipo == '2'){
                                                $ganhosSum += $f->valor;
                                            }
                                        ?>
                                        <tr>
                                            <td>#{{$f->id}}</td>
                                            <td>
                                                @if($f->tipo == 2)
                                                    Ganho
                                                @else
                                                    Pagamento
                                                @endif
                                            </td>
                                            <td>{{number_format($f->valor,2,'.','')}}</td>
                                            <td>
                                                {{$f->descricao}} <br>
                                                @if($f->pagamento_id)
                                                    <a href="{{route('admin.pagamentos.show',$f->pagamento_id)}}" class="link-badge-info">Ganho sobre Fatura #{{$f->pagamento_id}}</a>
                                                @elseif($f->investimento_id)
                                                    <a href="{{route('admin.investimentos.show',$f->investimento_id)}}" class="link-badge-info">
                                                        Referente ao Contrato #{{$f->investimento_id}}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{$f->tipo_bonus}}</td>
                                            <td>{{$f->created_at->format('d/m/Y')}}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4">Sem Histórico</td></tr>
                                    @endforelse
                                    </tbody>
{{--                                    <tfoot>--}}
{{--                                    <tr>--}}
{{--                                        <td>Ganhos Totais ${{number_format($ganhosSum,2,'.','')}}</td>--}}
{{--                                        <td>Pagamentos Totais ${{number_format($pagamentosSum,2,'.','')}}</td>--}}
{{--                                    </tr>--}}
{{--                                    </tfoot>--}}
                                </table>
                                {{$financeiros->render()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

@stop
@push('js')

@endpush
