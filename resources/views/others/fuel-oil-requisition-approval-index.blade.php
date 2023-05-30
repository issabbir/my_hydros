@extends('layouts.default')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection
@section('content')
    {{--@json($team)--}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Fuel Oil Requisition</h4>
                        <hr>
                        <div class="col-md-12 pr-0 d-flex justify-content-start">
                            <div class="form-group">
                                <a href="{{externalLoginUrl($url, $route)}}" target="_blank"><button type="button" class="btn btn-primary mr-1 mb-1">Go To Approval Management</button></a>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


@endsection


