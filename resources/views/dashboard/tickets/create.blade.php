@extends('layouts.app')
@section('title', 'Create Ticket')
@section('content')
    <div class="page-content">

        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="float-right">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Client</a></li>
                                <li class="breadcrumb-item active">Tickets</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Tickets</h4>
                    </div><!--end page-title-box-->
                </div><!--end col-->
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label for="subject">Subject</label>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">

                </div>
            </div>

        </div><!-- container -->

        <footer class="footer text-center text-sm-left">
           {{$settings->copyright}}
        </footer><!--end footer-->
    </div>
@endsection
