@extends('voyager::master')
@section('page_title')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-lock"></i> Certification
        </h1>
        
        <a href="#" class="btn btn-success btn-add-new">
            <i class="voyager-plus"></i> <span>Add</span>
        </a>
    </div>
@stop


@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Test</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@stop