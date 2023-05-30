@extends('layouts.default')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->

    <link rel="stylesheet" href="{{ asset('assets/dutyRosterCalender/css/bootstrap.min.css') }}"/>
    <script src="{{ asset('assets/dutyRosterCalender/js/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/dutyRosterCalender/css/fullcalendar.css') }}"/>
    <script src="{{ asset('assets/dutyRosterCalender/js/moment.min.js') }}"
            integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
    {{--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"/>--}}
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>--}}
    {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css"/>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"--}}
{{--            integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>--}}
    <style>
        .wickedpicker {
            z-index: 1151 !important;
        }

        .event-full {
            color: #fff;
            vertical-align: middle !important;
            text-align: center;
            opacity: 1;
        }
    </style>
@endsection
@section('content')
{{--@json($boat_employees)--}}
    <div class="row">
        <div class="col-12">{{--
            @json($month_id)--}}
            {{--@json($boat_employee ?? ''s)
            --}}

{{--            @json($vehicle_dtl)--}}



            @if(isset($vehicle_dtl->vehicle_id))
                <input type="hidden" name="" id="vehicle_id" value="{{$vehicle_dtl->vehicle_id}}" />
                <input type="hidden" name="" id="month_id" value="{{$month_id}}" />
                <input type="hidden" name="" id="year_id" value="{{$year_id}}" />
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
                    <div class="row">

                        <input type="hidden" id="vehicle_id" value="{{isset($vehicle_dtl) ? $vehicle_dtl->vehicle_id:''}}">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="vehicle_id" class="required">Boat Name</label>
                                <input class="form-control" disabled type="text"
                                       value="{{isset($vehicle_dtl) ? $vehicle_dtl->vehicle_name:''}}">
                            </div>
                        </div>

                        {{--<div class="col-sm-4">
                            <div class="form-group">
                                <label for="vehicle_id" class="required">Month</label>
                                <input class="form-control" disabled type="text"
                                       value="{{date('F', mktime(0, 0, 0, $month_id, 10))}}">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="vehicle_id" class="required">Year</label>
                                <input class="form-control" disabled type="text"
                                       value="{{$year_id}}">
                            </div>
                        </div>--}}
                    </div>
                    {{--  <div class="col-md-12 pr-0 d-flex justify-content-end">
                          <div class="form-group">
                              <a href="{{route()}}">Back</a>
                          </div>
                      </div>--}}

                </div>
                <!-- Table End -->
            </div>
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
            @else
                <input type="hidden" name="" id="vehicle_id" value="" />
            <div class="card">
                <!-- Table Start -->
                <div class="card-body">
                    <h4 class="card-title">Duty Roaster Setup</h4>
                    <hr>
                    {{--@if(Session::has('message'))
                        <div class="alert {{Session::get('m-class') ? Session::get('m-class') : 'alert-danger'}} show"
                             role="alert">
                            {{ Session::get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif--}}
                    <div class="row">

                        <input type="hidden" id="boat_employee_id" value="{{isset($boat_employee)? $boat_employee->boat_employee_id : ''}}">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="vehicle_id" class="required">Boat Name</label>
                                <input class="form-control" disabled type="text"
                                       value="{{isset($boat_employee) ? $boat_employee->vehicle->vehicle_name:''}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="vehicle_id" class="required">Emp Name</label>
                                <input class="form-control" disabled type="text"
                                       value="{{isset($boat_employee) ? $boat_employee->employee->emp_name:''}}">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="vehicle_id" class="required">Designation</label>
                                <input class="form-control" disabled type="text"
                                       value="{{isset($boat_employee) ? $boat_employee->designation->designation:''}}">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="vehicle_id" class="required">Team Leader</label>
                                <input class="form-control" disabled type="text"
                                       value="{{isset($boat_employee) ? $boat_employee->team_leader_yn == 'Y'?'Yes':'No':''}}">
                            </div>
                        </div>


                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="vehicle_id" class="required">Mobile</label>
                                <input class="form-control" disabled type="text"
                                       value="{{isset($boat_employee)?$boat_employee ->mobile_number:''}}">
                            </div>
                        </div>

                        {{--<div class="col-sm-4">
                            <div class="form-group">
                                <label for="vehicle_id" class="required">Month</label>
                                <input class="form-control" disabled type="text"
                                       value="{{date('F', mktime(0, 0, 0, $month_id, 10))}}">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="vehicle_id" class="required">Year</label>
                                <input class="form-control" disabled type="text"
                                       value="{{$year_id}}">
                            </div>
                        </div>--}}
                    </div>
                    {{--  <div class="col-md-12 pr-0 d-flex justify-content-end">
                          <div class="form-group">
                              <a href="{{route()}}">Back</a>
                          </div>
                      </div>--}}

                </div>
                <!-- Table End -->
            </div>

                {{--@if($indvApprovalData>0)

                    <div class="card" id="show-div">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12" style="align-content: center">
                                    <b>SCHEDULE SUBMITTED FOR APPROVAL.</b>
                                </div>
                            </div>
                        </div>
                    </div>

                @else--}}
                    <form id="indivi_apprv" method="post" onsubmit="return chkSubmit()" action="{{route('schedule.individual-approval-request')}}">
                        @if(Session::has('message'))
                            <div class="alert {{Session::get('m-class') ? Session::get('m-class') : 'alert-danger'}} show"
                                 role="alert">
                                {{ Session::get('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <input type="hidden" name="boat_employee_id" value="{{isset($boat_employee)? $boat_employee->boat_employee_id : ''}}">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="trainer_id" class="required">Select Option</label>
                                            <select class="custom-select form-control select2" id="schedule_id_indv"
                                                    name="schedule_id">
                                                <option value="1">Schedule</option>
                                                <option value="2">Holiday</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="required">Start Date</label>
                                            <input type="text"
                                                   autocomplete="off"
                                                   class="form-control datetimepicker-input"
                                                   data-toggle="datetimepicker"
                                                   id="schedule_start_date"
                                                   data-target="#schedule_start_date"
                                                   name="schedule_start_date"
                                                   value=""
                                                   placeholder="YYYY-MM-DD"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="required">End Date</label>
                                            <input type="text"
                                                   autocomplete="off"
                                                   class="form-control datetimepicker-input"
                                                   data-toggle="datetimepicker"
                                                   id="schedule_end_date"
                                                   data-target="#schedule_end_date"
                                                   name="schedule_end_date"
                                                   value=""
                                                   placeholder="YYYY-MM-DD"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label id="dtl_time_from_label">Time From</label>
                                            <input type="text"
                                                   autocomplete="off"
                                                   class="form-control datetimepicker-input"
                                                   data-toggle="datetimepicker"
                                                   id="dtl_time_from"
                                                   data-target="#dtl_time_from"
                                                   name="dtl_time_from"
                                                   value=""
                                                   placeholder="HH-MM"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label id="dtl_time_to_label">Time To</label>
                                            <input type="text"
                                                   autocomplete="off"
                                                   class="form-control datetimepicker-input"
                                                   data-toggle="datetimepicker"
                                                   id="dtl_time_to"
                                                   data-target="#dtl_time_to"
                                                   name="dtl_time_to"
                                                   value=""
                                                   placeholder="HH-MM"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-sm-2" align="right">
                                        <div id="start-no-field">
                                            <label for="seat_to1">&nbsp;</label><br/>
                                            <button type="submit" id="append"
                                                    class="btn btn-primary mb-1">
                                                Add
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                {{--@endif--}}
                <div class="card">
                    <div class="card-body">
                        <section id="horizontal-vertical">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Pending Approval/Approved</h4>
                                        </div>
                                        <div class="card-content">
                                            <form method="post" onsubmit="return chkFrom()" action="{{route('schedule.batch-approval')}}" name="final-results-form" id="final-results-form">
                                                {{csrf_field()}}
                                            <div class="card-body card-dashboard">
                                                <div class="table-responsive">
                                                    <table id="pending_apprv_list" class="table table-sm datatable mdl-data-table dataTable">
                                                        <thead>
                                                        <tr>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Start Date</th>
                                                            <th>End Date</th>
                                                            <th>Time From</th>
                                                            <th>Time To</th>
                                                            <th>Holiday</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="comp_body">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                                <div class="d-flex justify-content-start pl-1 pb-1">
                                                    <button type="submit" class="btn btn btn-dark shadow btn-secondary"
                                                            name="file_server_upload" id="file_server_upload" >Approve
                                                    </button>&nbsp;
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            @endif




        </div>
    </div>
<form enctype="multipart/form-data" action="{{route('schedule.schedule-post-for-approval')}}" method="post" onsubmit="return chkTable()">
    @csrf
@if(isset($approvalData))
    @if($approvalData >'0')
        <div class="card" id="show-div">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12" style="align-content: center">
                        <b>SCHEDULE SUBMITTED FOR APPROVAL.</b>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card" id="hide-div">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="trainer_id" class="required">Select Option</label>
                            <select class="custom-select form-control select2" id="schedule_id"
                                    name="schedule_id">
                                <option value="1">Schedule</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="required">Start Date</label>
                            <input type="text"
                                   autocomplete="off"
                                   class="form-control datetimepicker-input"
                                   data-toggle="datetimepicker"
                                   id="start_date"
                                   data-target="#start_date"
                                   name="start_date"
                                   value=""
                                   placeholder="YYYY-MM-DD"
                            >
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="required">End Date</label>
                            <input type="text"
                                   autocomplete="off"
                                   class="form-control datetimepicker-input"
                                   data-toggle="datetimepicker"
                                   id="end_date"
                                   data-target="#end_date"
                                   name="end_date"
                                   value=""
                                   placeholder="YYYY-MM-DD"
                            >
                        </div>
                    </div>

                    <div class="col-sm-1" align="right">
                        <div id="start-no-field">
                            <label for="seat_to1">&nbsp;</label><br/>
                            <button type="button" id="append"
                                    class="btn btn-primary mb-1 add-row-trainer-assign">
                                ADD
                            </button>

                        </div>
                    </div>
                </div>
                <div class="col-sm-12 mt-1">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered"
                               id="table-exam-result">
                            <thead>
                            <tr>
                                <th role="columnheader" scope="col"
                                    aria-colindex="1" class="" width="5%">Action
                                </th>
                                <th role="columnheader" scope="col"
                                    aria-colindex="2" class="" width="20%">Schedule For
                                </th>
                                <th role="columnheader" scope="col"
                                    aria-colindex="3" class="" width="20%">Date From
                                </th>
                                <th role="columnheader" scope="col"
                                    aria-colindex="4" class="" width="20%">Date To
                                </th>
                            </tr>
                            </thead>

                            <tbody role="rowgroup" id="comp_body"></tbody>
                        </table>

                    </div>
                </div>
                <div class="col-12 d-flex justify-content-start">
                    <button type="button"
                            class="btn btn-primary mb-1 delete-row-trainer-assign">
                        Delete
                    </button>
                </div>
                <div class="col-md-12 mt-2 text-right" id="add">
                    <button type="submit" id="add"
                            class="btn btn-primary mb-1">Submit For Approval
                    </button>
                    <input type="hidden" id="vehicle_id_out" value="{{isset($vehicle_dtl) ? $vehicle_dtl->vehicle_id:''}}">
                    <input type="hidden" id="month_id_out" value="{{isset($month_id) ? $month_id:''}}">
                    <input type="hidden" id="year_out" value="{{isset($year_id) ? $year_id:''}}">
                </div>
            </div>
        </div>
    @endif
    @endif
</form>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="response"></div>
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Roaster Detail Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">


                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="file_category_name" class="required">Schedule Start Date</label>
                                <input disabled
                                       type="text"
                                       class="form-control"
                                       id="schedule_date"
                                       name="schedule_date"
                                >
                                <small class="text-muted form-text"></small>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="file_category_name" class="required">Schedule End Date</label>
                                <input disabled
                                       type="text"
                                       class="form-control"
                                       id="schedule_end_date"
                                       name="schedule_end_date"
                                >
                                <small class="text-muted form-text"></small>
                            </div>
                        </div>

                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="schedule_from_time" class="required">Schedule From Time</label>
                                <input type="text"
                                       autocomplete="off"
                                       class="form-control from-timepicker"
                                       id="schedule_from_time"
                                       name="schedule_from_time"
                                       placeholder="HH:mm"
                                       required
                                       value="{{old('schedule_from_time',isset
                                           ($team_employee->schedule_from_time) ?
                                           date('H:i',strtotime($team_employee->schedule_from_time)) : '')}}"/>
                                <small class="text-muted form-text"> </small>
                            </div>
                        </div>


                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="schedule_to_time" class="required">Schedule To Time</label>
                                <input type="text"
                                       autocomplete="off"
                                       class="form-control"
                                       id="schedule_to_time"
                                       name="schedule_to_time"
                                       placeholder="HH:mm"
                                       required
                                       value="{{old('schedule_to_time',isset
                                           ($team_employee->schedule_to_time) ?
                                           date('H:i',strtotime($team_employee->schedule_to_time)) : '')}}"/>
                                <small class="text-muted form-text"> </small>
                            </div>
                        </div>


                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="schedule_comment">Schedule Comment</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="schedule_comment"
                                    name="schedule_comment"
                                >
                                <small class="text-muted form-text"></small>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <div class="float-left">
                        <button id="roaster-holiday" type="button" class="btn btn-danger ">Holiday
                        </button>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="roaster-confirm" type="button" class="btn btn-primary">Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>--}}
    <script>

        function chkFrom() {
            var feed_back_count = 1;
            var array = []
            var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')

            for (var i = 0; i < checkboxes.length; i++) {
                array.push(checkboxes[i].value)
            }
            if(feed_back_count>array.length)
            {
                Swal.fire('Select a roaster to approve.');
                return false;
            }else{
                var txt;
                var r = confirm('Are you sure?');
                if (r == true) {
                    return true;
                } else {
                    return false;
                }


            }

        }

        $('#pending_apprv_list tbody').on('click', '.editButton', function () {
            var data_row = $('#pending_apprv_list').DataTable().row( $(this).parents('tr') ).data();
            var roaster_mst_id = data_row.roaster_mst_id;

            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Approve!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: '{{route('schedule.individual-approval')}}',
                        data: {roaster_mst_id: roaster_mst_id},
                        success: function (msg) {//alert(msg)
                            if (msg == 1) {
                                Swal.fire({
                                    title: 'Approved!',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(function () {
                                    location.reload();
                                    return false;
                                });
                            }else{
                                Swal.fire({
                                    title: 'Approval Failure.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                                //return false;
                            }
                        }
                    });
                    //alert(roaster_mst_id)
                }
            });
        });

        function chkSubmit() {
            if($('#schedule_id_indv').val()== 1){
                if ($('#schedule_start_date').val() === ''||$('#schedule_end_date').val() === ''||
                    $('#dtl_time_from').val() === ''||$('#dtl_time_to').val() === '') {
                    Swal.fire({
                        title: 'Please add Date and Time!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }else {
                    return true;
                }
            }else if($('#schedule_id_indv').val()== 2){
                if ($('#schedule_start_date').val() === ''||$('#schedule_end_date').val() === '') {
                    Swal.fire({
                        title: 'Please add Date!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }else {
                    return true;
                }
            }

        }

        function chkTable() {
            if ($('#comp_body tr').length === 0) {
                Swal.fire({
                    title: 'Please add schedule first!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return false;
            }else {
                return true;
            }
        }

        function dateCheck(from,to,check) {

            var fDate,lDate,cDate;
            fDate = Date.parse(from);
            lDate = Date.parse(to);
            cDate = Date.parse(check);

            if((cDate <= lDate && cDate >= fDate)) {
                return true;
            }
            return false;
        }

        $(".add-row-trainer-assign").click(function () {

            let schedule_id = $("#schedule_id option:selected").val();
            let schedule_name = $("#schedule_id option:selected").text();

            let start_date = $("#start_date").val();
            let end_date = $("#end_date").val();

            let vehicle_id_out = $("#vehicle_id_out").val();
            let month_id_out = $("#month_id_out").val();
            let year_out = $("#year_out").val();
            if(start_date){
                if(!dateCheck(start_date,end_date,start_date)){
                    Swal.fire('Please select date between Start and End Date.');
                    return false;
                }
            }else{
                Swal.fire('Please select');
                return false;
            }

            if (schedule_id != '' && start_date != '' && end_date != '') {

                let markup = "<tr role='row'>" +
                    "<td aria-colindex='1' role='cell' class='text-center'>" +
                    "<input type='checkbox' name='record' value='" + schedule_id  + "+" + "" + "'>" +
                    "<input type='hidden' name='schedule_id[]' value='" + schedule_id + "'>" +
                    "<input type='hidden' name='start_date[]' value='" + start_date + "'>" +
                    "<input type='hidden' name='end_date[]' value='" + end_date + "'>" +
                    "<input type='hidden' name='vehicle_id_out[]' value='" + vehicle_id_out + "'>" +
                    "<input type='hidden' name='month_id_out[]' value='" + month_id_out + "'>" +
                    "<input type='hidden' name='year_out[]' value='" + year_out + "'>" +
                    "</td><td aria-colindex='2' role='cell'>" + schedule_name + "</td>" +
                    "<td aria-colindex='4' role='cell'>" + start_date + "</td>" +
                    "<td aria-colindex='5' role='cell'>" + end_date + "</td></tr>";
                //$("#schedule_id").val('').trigger('change');
                $("#start_date").val("");
                $("#end_date").val("");
                $("#dtl_time_from").val("");
                $("#dtl_time_to").val("");
                $("#table-exam-result tbody").append(markup);

            } else {
                Swal.fire('Fill required value.');
            }
        });

        $(".delete-row-trainer-assign").click(function () {
            $("#table-exam-result tbody").find('input[name="record"]').each(function () {
                if ($(this).is(":checked")) {
                        $(this).parents("tr").remove();
                }
            });
        });

        function pendingAppvList(boat_emp_id) {
            var oTable = $('#pending_apprv_list').DataTable({
                processing: true,
                serverSide: true,
                bDestroy: true,
                pageLength: 20,
                bFilter: true,
                lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'All']],
                ajax: {
                    url: '{{route('schedule.pending-approval-datatable-list')}}',
                    async: false,
                    'type': 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function (d) {
                        d.boat_employee_id = boat_emp_id;
                    }
                },
                "columns": [
                    {data: 'selected', name: 'selected'},
                    {data: 'schedule_start_date', name: 'schedule_start_date'},
                    {data: 'schedule_end_date', name: 'schedule_end_date'},
                    {data: 'schedule_start_time', name: 'schedule_start_time'},
                    {data: 'schedule_end_time', name: 'schedule_end_time'},
                    {data: 'holiday', name: 'holiday'},
                    {data: 'action', name: 'action', searchable: false},
                ]
            });
            //oTable.columns( [6] ).visible( false );
            oTable.draw();
        }

        $('#pending_apprv_list tbody').on('click', '.roasterRemove', function () {
            let row_id = $(this).data("roastermstid");
            let removeItemEl = $(this);
            removeRosterData(row_id, removeItemEl);
        });

        function removeRosterData(row_id, removeItemEl){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes '
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: '{{route('schedule.pending-approval-remove')}}',
                        data: {roaster_mst_id: row_id},
                        success: function (msg) {
                            if (msg == 1) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(function () {
                                    //location.reload();
                                    //return false;
                                    removeItemEl.closest("tr").remove();
                                });
                            }else{
                                Swal.fire({
                                    title: 'Something went wrong.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        }
                    });
                }
            });
        }



        $(document).ready(function () {
            $('#schedule_id_indv').change(function() {
                let val = $('#schedule_id_indv').val();
                //alert(val)
                if(val==1){
                    $('#dtl_time_from_label').addClass('required');
                    $('#dtl_time_to_label').addClass('required');
                }else{//alert('asda111sd')
                    $('#dtl_time_from_label').removeClass('required');
                    $('#dtl_time_to_label').removeClass('required');
                }
            });
            $('#dtl_time_from_label').addClass('required');
            $('#dtl_time_to_label').addClass('required');
            //alert($('#boat_employee_id').val())
            pendingAppvList($('#boat_employee_id').val());
            datePicker('#schedule_start_date');
            datePicker('#schedule_end_date');
            datePicker('#start_date');
            datePicker('#end_date');
            timePickerCustom('#dtl_time_from');
            timePickerCustom('#dtl_time_to');
            var obj = [];

            function timePickerCustom(selector) {
                var elem = $(selector);
                elem.datetimepicker({
                    /*format: 'LT',*/
                    format: 'HH:mm',
                    icons: {
                        time: 'bx bx-time',
                        date: 'bx bxs-calendar',
                        up: 'bx bx-up-arrow-alt',
                        down: 'bx bx-down-arrow-alt',
                        previous: 'bx bx-chevron-left',
                        next: 'bx bx-chevron-right',
                        today: 'bx bxs-calendar-check',
                        clear: 'bx bx-trash',
                        close: 'bx bx-window-close'
                    }
                });

                let preDefinedDate = elem.attr('data-predefined-date');

                if (preDefinedDate) {
                    let preDefinedDateMomentFormat = moment(preDefinedDate, "YYYY-MM-DD HH:mm").format("YYYY-MM-DD HH:mm A");
                    elem.datetimepicker('defaultDate', preDefinedDateMomentFormat);
                }
            }

            function load_calender() {
                var url = '{{route('schedule.employee_roaster')}}';
                $.ajax({
                    type: "POST",
                    url: url,
                    async: false,
                    data: {
                        boat_employee_id: $('#boat_employee_id').val(),
                        boat_id : $('#vehicle_id').val()
                    },
                    success: function (resp) {
                        //console.log(resp);
                        var currentTime = new Date();
                        var month = currentTime.getMonth();
                        var day = currentTime.getDate();
                        var year = currentTime.getFullYear();

                        //var ricksDate = new Date('{{$year_id}}', '{{ $month_id-1 }}', 1); //active it for January
                        var ricksDate = new Date(year, month, 1);
                        //console.log(ricksDate);
                        obj = resp;
                        $('#calendar').fullCalendar('destroy');
                        $('#calendar').fullCalendar('render');
                        $('#calendar').fullCalendar({
                            defaultDate: ricksDate,
                            events: resp,

                            eventRender: function (event, element, view) {
                                // like that
                                var dateString = moment(event.start).format('YYYY-MM-DD');
                                $('#calendar').find('.fc-day-number[data-date="' + dateString + '"]').css('background-color', '#FAA732');
                            },
                            dayClick: function (date, allDay, jsEvent, view) {
                                //console.log(date);
                                var start = $.fullCalendar.formatDate(date, "Y-MM-DD");
                                var end_date = $.fullCalendar.formatDate(date, "Y-MM-DD");
                                $('#schedule_date').val(start);
                                $('#schedule_end_date').val(end_date);
                                $('#schedule_comment').val('');

                                $('#basicExampleModal').modal({
                                    show: true,
                                    backdrop: 'static'
                                });
                            },
                            selectable: true,
                            selectHelper: true,
                            select: function (start, end, allDay) {



                               // console.log('endDate',endDate);

                                var start_date = $.fullCalendar.formatDate(start, "Y-MM-DD");
                                var end_date = moment(new Date(end)).subtract(1, 'day').format("Y-MM-DD");

                                //console.log('end_date',end_date);
                                $('#schedule_date').val(start_date);
                                $('#schedule_end_date').val(end_date);
                                $('#schedule_comment').val('');

                                $('#basicExampleModal').modal({
                                    show: true,
                                    backdrop: 'static'
                                });
                            },
                            eventClick: function (event) {

                                var dateString = moment(event.start).format('DD');
                                //console.log(event.boat_employee_roster_id);
                                alertify.confirm('Delete Roaster', 'Are you sure?',
                                    function () {
                                        var url = '{{route('schedule.delete-employee-roster')}}';

                                        $.ajax({
                                            type: "POST",
                                            url: url,
                                            data: {
                                                "boat_employee_roster_id": event.boat_employee_roster_id,
                                                "boat_id" : $('#vehicle_id').val(),
                                                "month_id" : $('#month_id').val(),
                                                "year_id" : $('#year_id').val(),
                                                "day" : dateString,
                                            },
                                            success: function (resp) {
                                                //console.log(resp);
                                                if (resp.o_status_code == 1) {
                                                    alertify.success(resp.o_status_message);
                                                    //$('#basicExampleModal').modal('hide');
                                                    load_calender();

                                                } else {
                                                    alertify.error(resp.o_status_message);
                                                }
                                            },
                                            error: function (resp) {
                                                alert('error');
                                            }
                                        })


                                    }
                                    , function () {
                                        alertify.error('Cancel')
                                    }
                                );
                            }

                        });
                    },
                    error: function (resp) {
                        alert('error');
                    }
                });
            }

            load_calender();

            $('#roaster-holiday').click(function (e) {
                e.preventDefault();

                var comment = $('#schedule_comment').val();

                if (comment == null || comment == undefined) {
                    comment = 'Holiday';
                }

                var detail = {};
                detail.boat_employee_id = $('#boat_employee_id').val();

                detail.schedule_date = $('#schedule_date').val();
                detail.schedule_end_date = $('#schedule_end_date').val();
                detail.schedule_from_time = $('#schedule_from_time').val();
                detail.schedule_to_time = $('#schedule_to_time').val();
                detail.schedule_comment = comment;
                detail.holiday_yn = '{{\App\Enums\YesNoFlag::YES}}';
                detail.boat_id = $('#vehicle_id').val();
                //console.log(detail);
                var url = '{{route('schedule.duty-roster-calender-save')}}';
                $.ajax({
                    type: "POST",
                    url: url,
                    data: detail,
                    success: function (resp) {
                        //console.log(resp);

                        if (resp.o_status_code == 1) {

                            alertify.success(resp.o_status_message);
                            $('#basicExampleModal').modal('hide');
                            load_calender();

                        } else {
                            alertify.error(resp.o_status_message);
                        }
                    },
                    error: function (resp) {
                        alert('error');
                    }
                });
            });

            $('#roaster-confirm').click(function (e) {
                e.preventDefault();


                var detail = {};
                detail.boat_employee_id = $('#boat_employee_id').val();

                detail.schedule_date = $('#schedule_date').val();

                detail.schedule_end_date = $('#schedule_end_date').val();
                detail.schedule_from_time = $('#schedule_from_time').val();
                detail.schedule_to_time = $('#schedule_to_time').val();
                detail.schedule_comment = $('#schedule_comment').val();
                detail.holiday_yn = '{{\App\Enums\YesNoFlag::NO}}';
                //data.end = $('#schedule_comment').val();
                detail.boat_id = $('#vehicle_id').val();
                //console.log(detail);
                var url = '{{route('schedule.duty-roster-calender-save')}}';
                $.ajax({
                    type: "POST",
                    url: url,
                    data: detail,
                    success: function (resp) {
                        //console.log(resp);
                        if (resp.o_status_code == 1) {
                            alertify.success(resp.o_status_message);
                            $('#basicExampleModal').modal('hide');
                            load_calender();

                        } else {
                            alertify.error(resp.o_status_message);
                        }
                    },
                    error: function (resp) {
                        alert('error');
                    }
                });
            });


            $('.from-timepicker').wickedpicker({
                title: 'From',
                now: "9:00", //hh:mm 24 hour format only, defaults to current time
                twentyFour: true, //Display 24 hour format, defaults to false
            });

            $('#schedule_to_time').wickedpicker({
                title: 'To',
                now: "17:00", //hh:mm 24 hour format only, defaults to current time
                twentyFour: true, //Display 24 hour format, defaults to false
            });


            var SITEURL = "{{url('/')}}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



            /*
                        var calendar = $('#calendar').fullCalendar({
                            defaultDate: ricksDate,
                        editable: true,
                            events: SITEURL + "/fullcalendareventmaster",
                            displayEventTime: true,
                            editable: true,
                            eventRender: function (event, element, view) {
                                if (event.allDay === 'true') {
                                    event.allDay = true;
                                } else {
                                    event.allDay = false;
                                }
                            },
                            selectable: true,
                            selectHelper: true,
                            disableDragging : true,
                            select: function (start, end, allDay) {


                                var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                                var end_date = $.fullCalendar.formatDate(end, "Y-MM-DD");
                                $('#schedule_date').val(start);
                                $('#schedule_end_date').val(end_date);

                                $('#schedule_comment').val('');


                                $('#basicExampleModal').modal({
                                    show: true,
                                    backdrop: 'static'
                                });

                                /!*
                                var title = prompt('Event Title:');
                                if (title) {
                                    var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                                    var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");

                                    var data = {};
                                    data.boat_employee_id = $('#boat_employee_id').val();
                                    data.title = title;
                                    data.start = start;
                                    data.end = end;

                                    console.log(data);

                                    $.ajax({
                                        url: SITEURL + "/fullcalendareventmaster/create",
                                        data: 'title=' + title + '&start=' + start + '&end=' + end,
                                        type: "POST",
                                        success: function (data) {
                                            displayMessage("Added Successfully");
                                        }
                                    });
                                    calendar.fullCalendar('renderEvent',
                                        {
                                            title: title,
                                            start: start,
                                            end: end,
                                            allDay: allDay
                                        },
                                        true
                                    );
                                }
                                calendar.fullCalendar('unselect');
            *!/
                            },/!*
                            eventDrop: function (event, delta) {
                                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                                $.ajax({
                                    url: SITEURL + '/fullcalendareventmaster/update',
                                    data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
                                    type: "POST",
                                    success: function (response) {
                                        displayMessage("Updated Successfully");
                                    }
                                });
                            },*!/
                            eventClick: function (event) {
                                var deleteMsg = confirm("Do you really want to delete?");
                                if (deleteMsg) {
                                    $.ajax({
                                        type: "POST",
                                        url: SITEURL + '/fullcalendareventmaster/delete',
                                        data: "&id=" + event.id,
                                        success: function (response) {
                                            if (parseInt(response) > 0) {
                                                $('#calendar').fullCalendar('removeEvents', event.id);
                                                displayMessage("Deleted Successfully");
                                            }
                                        }
                                    });
                                }
                            }
                        });*/
        });

        function displayMessage(message) {
            $(".response").html("" + message + "");
            setInterval(function () {
                $(".success").fadeOut();
            }, 1000);
        }
    </script>

@endsection
