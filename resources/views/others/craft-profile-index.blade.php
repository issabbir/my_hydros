@extends('layouts.default')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection
@section('content')
    {{--@json($vehicles)--}}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">Craft Profiles</h4>
                            <div class="card-content">

                                <div class="table-responsive">
                                    <table id="tbl_team_employee"
                                           class="table table-sm datatable mdl-data-table dataTable">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Boat Name</th>
                                            <th>Type</th>
                                            <th>Engine Capacity</th>
                                            <th>Origin</th>
                                            <th>Model Year</th>
                                            <th>Fuel Type</th>
                                            <th>Active</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($vehicles) && count($vehicles) > 0)

                                            @foreach($vehicles as $vehicle)
                                                <tr id="{{$vehicle->vehicle_requisition_id}}">
                                                    <td> {{$loop->iteration}} </td>
                                                    <td> {{$vehicle->vehicle_name}} </td>
                                                    <td> {{$vehicle->vehicle_type->type_name}} </td>


                                                    <td> {{$vehicle->engine_capacity}} </td>
                                                    <td> {{$vehicle->origin}} </td>
                                                    <td> {{$vehicle->model_year}} </td>
                                                    <td> {{$vehicle->fuel_type}} </td>
                                                    <td>

                                                        @if($vehicle->active_yn == 'Y')

                                                            <span
                                                                class="badge badge-pill badge-success">Yes
                                                            </span>

                                                        @else
                                                            <span
                                                                class="badge badge-pill badge-danger">
                                                                No
                                                            </span>

                                                        @endif

                                                    </td>

                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td id="emptyRow" colspan="5">
                                                    No data found
                                                </td>
                                            </tr>
                                        @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection

@section('footer-script')
    <script type="text/javascript">


    </script>

@endsection

