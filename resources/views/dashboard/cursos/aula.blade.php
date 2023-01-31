@extends('layouts.base')
@section('title',$aula->name)
@section('styles')
    <link rel="stylesheet" href="{{asset('css/plyr.css')}}" />
@endsection
@section('content')
    <section class="container">
        <div class="row">
            <div class="col-lg-12">
                <small>Cruso: {{$curso->name}}</small>
                <h2 class="h4">{{$aula->name}}</h2>
            </div>
            <div class="col-lg-8">
                <div id="player" data-plyr-provider="vimeo" data-plyr-embed-id="{{$aula->video}}"></div>
                <div class="clearfix"></div>
                <div class="card card-body pt-3">
                    {!! $aula->body !!}
                </div>
            </div>
            <div class="col-lg-4">
                <div class="list-group">
                    @foreach($aulas as $a)
                        <a href="{{route('dashboard.cursos.aula',['curso'=>$curso->slug,'aula'=>$a->slug])}}" class="list-group-item list-group-item-action {{$aula->id == $a->id?'active':''}}">
                           <div class="position-relative d-inline-flex">
                               <div class="me-2">
                                   @if($a->isView())
                                       <i class="bx bx-check-circle fw-bold"></i>
                                   @else
                                       <i class="bx bx-circle"></i>
                                   @endif
                               </div>
                               <div class="text-wrap">
                                   {{$a->name}}
                               </div>
                           </div>
                        </a>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="{{asset('js/plyr.polyfilled.js')}}"></script>
    <script>
        const player = new Plyr('#player');
        player.on('play', event => {
            var condition =  "start";
            $.ajax({
                type:'POST',
                url:'{{route('dashboard.cursos.play')}}',
                data:{condition:condition, aula_id:{{$aula->id}}, currentTime: player.currentTime}
            });
        });
        player.on('stop', event => {
            var condition = "stop";
            $.ajax({
                type:'POST',
                url:'{{route('dashboard.cursos.play')}}',
                data:{condition:condition, aula_id:{{$aula->id}}, currentTime: player.currentTime}
            });
        });
        player.on('ended', event => {
            var condition = "fim";
            $.ajax({
                type:'POST',
                url:'{{route('dashboard.cursos.play')}}',
                data:{condition:condition, aula_id:{{$aula->id}}},
                success: function (){
                    location.reload();
                }
            });
        });
        console.log(player.currentTime);
    </script>
@endpush
