@extends('layouts.default')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection
@section('content')
    {{--@json($team)--}}

    <form @if(isset($product_detail->product_detail_id)) action="{{route('others.fuel-oil-requisition-post')}}"
          @else action="{{route('others.fuel-oil-requisition-post')}}" @endif method="post">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Fuel Oil Requisition</h4>

                        <hr>
                        @if(Session::has('message'))
                            <div
                                class="alert {{Session::get('m-class') ? Session::get('m-class') : 'alert-danger'}} show"
                                role="alert">
                                {{ Session::get('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="team_id" class="required">Vehicles </label>
                                <select class="custom-select select2 form-control" required id="vehicle_id"
                                        name="vehicle_id">
                                    <option value="">Select One</option>
                                    @if(isset($vehicles))
                                        @foreach($vehicles as $v)
                                            <option value="{{$v->vehicle_id}}"
                                                    @if(isset($vehicle->vehicle_id) &&
                                                    ($vehicle->vehicle_id == $v->vehicle_id))
                                                    selected
                                                @endif
                                            >{{$v->vehicle_name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 pr-0 d-flex justify-content-end">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary mr-1 mb-1">Search</button>
                                <input type="reset" class="btn btn-light-secondary mb-1" value="Reset"/>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </form>



    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">Fuel Oil Requisiton Report</h4>
                            <div class="card-content">

                                <div class="table-responsive">
                                    <table id="tbl_team_employee"
                                           class="table table-sm datatable mdl-data-table dataTable">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Boat Name</th>
                                            <th>Master Name</th>
                                            <th>Boat Millage</th>
                                            <th>Running Millage</th>
                                            <th>Fuel Qty</th>
                                            <th>Approved Qty</th>
                                            <th>Requisition By</th>
                                            <th>Requisition Date</th>
                                            <th>Approved By</th>
                                            <th>Approved Date</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($vehicle_requisitions) && count($vehicle_requisitions) > 0)

                                            @foreach($vehicle_requisitions as $vehicle_requisition)
                                                <tr id="{{$vehicle_requisition->vehicle_requisition_id}}">
                                                    <td> {{$loop->iteration}} </td>
                                                    <td> {{$vehicle_requisition->vehicle->vehicle_name}} </td>
                                                    <td> {{$vehicle_requisition->master_name}} </td>


                                                    <td> {{$vehicle_requisition->boat_millage}} </td>
                                                    <td> {{$vehicle_requisition->running_millage}} </td>

                                                    <td> {{$vehicle_requisition->requested_fuel_qty}} </td>
                                                    <td> {{$vehicle_requisition->delivered_fuel_qty}} </td>
                                                    <td>
                                                        @if(isset($vehicle_requisition->requisition_emp))
                                                            {{$vehicle_requisition->requisition_emp->emp_name}}
                                                        @endif
                                                    </td>

                                                    <td>  {{$vehicle_requisition->requisition_date}} </td>

                                                    <td>
                                                        @if(isset($vehicle_requisition->approved_emp))
                                                            {{$vehicle_requisition->approved_emp->emp_name}}
                                                        @endif
                                                    </td>


                                                    <td>  {{$vehicle_requisition->approved_date}} </td>
                                                    <td>

                                                        @if($vehicle_requisition->status == 'PENDING')

                                                            <span
                                                                class="badge badge-pill badge-danger">{{$vehicle_requisition->status}}</span>

                                                        @else
                                                            <span
                                                                class="badge badge-pill badge-success">{{$vehicle_requisition->status}}</span>

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

        $(function () {
            $(document).on("click","input[type='reset']", function(){
                // console.log('test');
                $( "#vehicle_id" ).val(0).trigger('change.select2').select2({
                    placeholder: "Select One",
                });
            });

        })

    </script>

@endsection

