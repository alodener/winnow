@extends('layouts.app')

@section('content')
    <div class="rq-tips-tricks">
        <div class="row">
            <h2 class="nh-title">Rentabilidade Diária</h2>
            <div class="panel">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Valor</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($ganhos as $g)
                            <tr>
                                <td>R$ {{number_format($g->valor,2,',','.')}}</td>
                                <td>{{$g->created_at->diffForHumans()}}</td>                                
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$ganhos->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

@stop
