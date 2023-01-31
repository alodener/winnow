@extends('layouts.admin')
@section('breadcrumb')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <div class="container">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                <li class="breadcrumb-item active"><a href="#">Links</a></li>
            </div>
        </ol>
    </nav>
@endsection
@section('content')
    <section class="probootstrap-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card bg-dark">
                        <div class="card-header">
                            <span class="h5">
                                Editar Link {{$link->name}}
                            </span>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.links.update',$link->id)}}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for=""class="form-control-label">Nome</label>
                                    <input type="text" name="name" class="form-control" value="{{$link->name}}" required>
                                </div>
                                @error('name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                                <div class="form-group">
                                    <label for=""class="form-control-label">Link</label>
                                    <input type="text" name="link" class="form-control" value="{{$link->link}}" required>
                                </div>
                                <button type="submit" class="btn btn-success">Editar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
