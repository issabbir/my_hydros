@extends('layouts.default')

@section('title')

@endsection


@section('content')

    <div class="row">
        <div class="col-12">
            {{--@json($boat_employees)
            --}}
            <div class="card">
                <!-- Table Start -->
                <div class="card-body">
                    <h4 class="card-title">Duty Roaster Setup</h4>
                    <hr>
                    @if(Session::has('message'))
                        <div class="alert {{Session::get('m-class') ? Session::get('m-class') : 'alert-danger'}} show"
                             role="alert">
                            {{ Session::get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form id="frm_duty_roaster" action="{{route('schedule.duty-roster-employee')}}" method="post">

                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="vehicle_id" class="required">Boat Name</label>
                                    <select class="custom-select select2 form-control" id="vehicle_id"
                                            name="vehicle_id" required>
                                        <option value="">Select One</option>
                                        @if(isset($vehicles))
                                            @foreach($vehicles as $vehicle)
                                                <option value="{{$vehicle->vehicle_id}}"
                                                        @if(isset($vehicle_id) &&
                                                        ($vehicle_id == $vehicle->vehicle_id))
                                                        selected
                                                    @endif
                                                >{{$vehicle->vehicle_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            {{--<div class="col-sm-4">
                                <div class="form-group">
                                    <label for="team_id" class="required">Month </label>
                                    <select class="custom-select select2 form-control" id="month_id"
                                            name="month_id" required>
                                        <option value="">Select One</option>
                                        @if(isset($months))
                                            @foreach($months as $month)
                                                <option value="{{$month->month_id}}"
                                                        @if(isset($month_id) &&
                                                        ($month_id == $month->month_id))
                                                        selected
                                                    @endif
                                                >{{$month->month_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="team_id" class="required">Year </label>
                                    <select class="custom-select select2 form-control" id="year_id"
                                            name="year_id" required>
                                    </select>
                                </div>
                            </div>--}}


                        </div>
                        <div class="col-md-12 pr-0 d-flex justify-content-end">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary mr-1 mb-1">Search</button>
                                <input type="reset" class="btn  mb-1" value="Reset"/>
                            </div>
                        </div>

                    </form>
                  {{--@if(isset($month_id) && isset($year_id))--}}
                  @if(isset($vehicle_id))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="card-title">All Employees List</h4>
                                    <div class="card-content">
                                        <div class="table-responsive">
                                            <table id="tbl_file_category"
                                                   class="table table-sm datatable mdl-data-table dataTable">
                                                <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    {{--<th>Zone Area Id</th>--}}
                                                    <th>All</th>
                                                    <th>Boat Name</th>
                                                    {{--<th>Month</th>
                                                    <th>Year</th>--}}
                                                    <th>Active Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(isset($boat_employees)&& count($boat_employees))

                                                    <tr>
                                                        <td> 1. </td>
                                                        <td> All Employees </td>
                                                        <td>{{$vehicle_dtl->vehicle_name}}</td>
                                                        {{--<td> {{$months_list->month_name}} </td>
                                                        <td> {{$year_id}} </td>--}}
                                                        @if($vehicles_status->active_yn=='Y')
                                                            <td>YES</td>
                                                        @else
                                                            <td>NO</td>
                                                        @endif
                                                        <td>
                                                           <a href="{{route('schedule.duty-roster-calender-boat',['id'=>$vehicle_dtl->vehicle_id /*,'month_id'=>$month_id,'year_id'=>$year_id*/])}}"
                                                            class="text-primary">Roaster</a></td>
                                                    </tr>

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
                    @endif
                </div>

                <!-- Table End -->
            </div>

        </div>
    </div>
    @if(isset($approval_status))
        {{--@if(isset($month_id) && isset($year_id))--}}
        @if(isset($vehicle_id))

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="card-title">Employee List</h4>
                                    <div class="card-content">
                                        <div class="table-responsive">
                                            <table id="tbl_file_category"
                                                   class="table table-sm datatable mdl-data-table dataTable">
                                                <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    {{--<th>Zone Area Id</th>--}}
                                                    <th>Emp Name</th>
                                                    <th>Designation</th>
                                                    <th>Active</th>
                                                    <th>Team Leader</th>
                                                    <th>Mobile No.</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(isset($boat_employees) && count($boat_employees) > 0)
                                                    @foreach($boat_employees as $boat_employee)

                                                        <tr id="{{$boat_employee->boat_employee_id}}">
                                                            <td> {{$loop->iteration}} </td>

                                                            <td> @if(isset($boat_employee->employee))
                                                                    {{$boat_employee->employee->emp_name}}
                                                                @endif

                                                            </td>
                                                            <td>
                                                                @if(isset($boat_employee->designation))

                                                                    {{$boat_employee->designation->designation}}
                                                                @endif
                                                            </td>
                                                            <td> {{$boat_employee->active_yn == 'Y' ? 'Yes':'No'}} </td>
                                                            <td> {{$boat_employee->team_leader_yn == 'Y'?'Yes':'No'}} </td>
                                                            <td> {{$boat_employee->mobile_number}} </td>

                                                            <td>
                                                                <a href="{{route('schedule.duty-roster-calender',['id'=>$boat_employee->boat_employee_id ,'month_id'=>$month_id,'year_id'=>$year_id])}}"
                                                                   class="text-primary">Roaster</a></td>
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

        @endif
    @endif

@endsection

@section('footer-script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

    <script>

        function populateYear() {
            var year = new Date().getFullYear();
            var till = 2099;
            var options = "";
            for (var y = year; y <= till; y++) {

                var year_id = '{{$year_id}}';



                if(y == year_id){
                    options += "<option selected>" + y + "</option>";
                }else{
                    options += "<option>" + y + "</option>";
                }



            }
            document.getElementById("year_id").innerHTML = options;
        }

        $(document).ready(function () {

            populateYear();

            $(document).on("click","input[type='reset']", function(){
                // console.log('test');
                $( "#vehicle_id" ).val(0).trigger('change.select2').select2({
                    placeholder: "Select One",
                });

                $( "#month_id" ).val(0).trigger('change.select2').select2({
                    placeholder: "Select One",
                });
                var year = new Date().getFullYear();
                $("#year_id").val(year).change();
            });



            var year = $('#year_id option:selected').text();
            console.log(year);

            $('#roaster-confirm').click(function (e) {
                e.preventDefault();


                var data = {};
                data.boat_employee_id = $('#boat_employee_id').val();
                data.schedule_comment = $('#schedule_comment').val();
                data.schedule_date = $('#schedule_date').val();
                data.schedule_end_date = $('#schedule_end_date').val();
                data.schedule_from_time = $('#schedule_from_time').val();
                data.schedule_to_time = $('#schedule_to_time').val();
                //data.end = $('#schedule_comment').val();

                console.log(data);
                /* alertify.confirm('Confirm Roaster', 'Are you sure?',
                     function () {

                         var product_order_id = $('#product_order_id').val();
                         var tentative_confirmation = $('#tentative_confirmation').val();
                         var description = $('#description').val();


                         var detail = {};
                         detail.product_order_id = product_order_id;
                         detail.tentative_confirmation = tentative_confirmation;
                         detail.description = description;
                         //
                         detail.confirmed_yn = '<?php echo e(\App\Enums\YesNoFlag::YES); ?>';

                        console.log(detail);
                        var url  = '';
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: detail,
                            success: function (resp) {
                                console.log(resp);

                                if (resp.o_status_code == 1) {

                                    $('#tbl_product_completed_list tr').each(function () {
                                        var id = $(this).attr('id');

                                        if (id == product_order_id) {
                                            $(this).closest('tr').find('.confirmed').html('Yes');
                                            //var cur_date = '<?php echo e(date('Y-m-d')); ?>';
                                            $(this).closest('tr').find('.confirmed_date').html('<span>' + tentative_confirmation + '<span>');
                                        }
                                    });
                                    alertify.success(resp.o_status_message);
                                } else {
                                    alertify.error(resp.o_status_message);
                                }
                            },
                            error: function (resp) {
                                alert('error');
                            }
                        });


                    }
                    , function () {
                        alertify.error('Cancel')
                    }
                );*/

            });


            $('.from-timepicker').wickedpicker({
                title: 'To',
                now: "9:00", //hh:mm 24 hour format only, defaults to current time
                twentyFour: true, //Display 24 hour format, defaults to false
            });

            $('#schedule_to_time').wickedpicker({
                title: 'To',
                now: "17:00", //hh:mm 24 hour format only, defaults to current time
                twentyFour: true, //Display 24 hour format, defaults to false
            });

        });

    </script>

@endsection
