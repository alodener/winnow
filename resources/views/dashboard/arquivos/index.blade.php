@extends('layouts.base')
@section('title','Arquivos')
@section('styles')

@endsection
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active">Arquivos</li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')

        <div class="row layout-top-spacing">
            <div class="col-lg-12">
                <h2 class="nh-title">Arquivos</h2>
            </div>
            @forelse($arquivos as $a)
                <div class="col-md-4 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            @if($a->tipo == 'png' OR $a->tipo == 'jpg' OR $a->tipo == 'jpeg' )
                                <i class="far fa-file-image" style="font-size: 8em"></i>
                            @elseif($a->tipo == 'pdf')
                                <i class="far fa-file-pdf" style="font-size: 8em"></i>
                            @elseif($a->tipo == 'docx')
                                <i class="far fa-file-word" style="font-size: 8em"></i>
                            @endif
                            <h5 class="card-title pt-3 mb-3">{{$a->name}}</h5>
                            <p class="card-text"><a class="btn btn-outline-success" href="{{route('dashboard.arquivos.show',$a->id)}}"><i data-feather="download"></i> Download</a></p>
                        </div>
                    </div>
                </div>
            @empty
                <tr><td>Sem Arquivo</td></tr>
            @endforelse
            {{$arquivos->render()}}
        </div>

@stop
@push('js')

@endpush
