@extends('layouts.default')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Table Start -->
                <div class="card-body">
                    <h4 class="card-title">Survey Setup</h4>
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
                    <form @if(isset($schedule->schedule_master_id)) action="{{route('schedule.survey-update',
                    [$schedule->schedule_master_id])}}"
                          @else action="{{route('schedule.survey-post')}}" @endif method="post">
                        @csrf
                        @if (isset($schedule->schedule_master_id))
                            @method('PUT')
                        @endif
                        <div class="row">


                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="schedule_name" class="required">Schedule Name</label>
                                    <input required
                                           type="text"
                                           class="form-control"
                                           id="schedule_name"
                                           name="schedule_name"
                                           placeholder="Enter Schedule Name"
                                           value="{{old('schedule_name',isset($schedule->schedule_name) ? $schedule->schedule_name : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="schedule_name_bn">Schedule Name(Bangla)</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="schedule_name_bn"
                                        name="schedule_name_bn"
                                        placeholder="Enter Schedule Name(Bangla)"
                                        value="{{old('schedule_name_bn',isset($schedule->schedule_name_bn) ? $schedule->schedule_name_bn : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="schedule_type_id" class="required">Schedule Type </label>
                                    <select class="custom-select select2 form-control" required id="schedule_type_id"
                                            name="schedule_type_id">
                                        <option value="">Select One</option>
                                        @if(isset($schedule_types))
                                            @foreach($schedule_types as $schedule_type)
                                                <option value="{{$schedule_type->schedule_type_id}}"
                                                        @if(isset($schedule->schedule_type_id) &&
                                                        ($schedule->schedule_type_id == $schedule_type->schedule_type_id))
                                                        selected
                                                    @endif
                                                >{{$schedule_type->schedule_type_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>


                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="schedule_from_date" class="required">Schedule From Date</label>
                                    <input type="text"
                                           autocomplete="off"
                                           class="form-control"
                                           data-toggle="datetimepicker"
                                           id="schedule_from_date"
                                           data-target="#active_to"
                                           name="schedule_from_date"
                                           placeholder="YYYY-MM-DD"
                                           required
                                           data-date-format="yyyy-mm-dd"
                                           value="{{old('schedule_from_date',isset
                                           ($schedule->schedule_from_date) ?
                                           date('Y-m-d',strtotime($schedule->schedule_from_date)) : '')}}"/>
                                    <small class="text-muted form-text"> </small>
                                </div>
                            </div>


                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="schedule_to_date" class="required">Schedule To Date</label>
                                    <input type="text"
                                           autocomplete="off"
                                           class="form-control"
                                           data-toggle="datetimepicker"
                                           id="schedule_to_date"
                                           data-target="#active_to"
                                           name="schedule_to_date"
                                           placeholder="YYYY-MM-DD"
                                           required
                                           data-date-format="yyyy-mm-dd"
                                           value="{{old('schedule_to_date',isset
                                           ($schedule->schedule_to_date) ?
                                           date('Y-m-d',strtotime($schedule->schedule_to_date)) : '')}}"/>
                                    <small class="text-muted form-text"> </small>
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="active_yn" class="required">Active?</label>
                                    <ul class="list-unstyled mb-0">
                                        <li class="d-inline-block mr-2 mb-1">
                                            <fieldset>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="active_yn"
                                                           id="active_yes"
                                                           value="{{\App\Enums\YesNoFlag::YES}}"
                                                           @if($survey_schedule && ($survey_schedule->active_yn == \App\Enums\YesNoFlag::YES))
                                                           checked
                                                           @elseif(!$survey_schedule)
                                                           checked
                                                        @endif
                                                    />
                                                    <label class="custom-control-label" for="active_yes"> Yes </label>
                                                </div>
                                            </fieldset>
                                        </li>
                                        <li class="d-inline-block mr-2 mb-1">
                                            <fieldset>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="active_yn"
                                                           id="active_no"
                                                           value="{{\App\Enums\YesNoFlag::NO}}"
                                                           @if($survey_schedule && ($survey_schedule->active_yn != \App\Enums\YesNoFlag::YES))
                                                           checked
                                                        @endif
                                                    />
                                                    <label class="custom-control-label" for="active_no"> No </label>
                                                </div>
                                            </fieldset>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12 pr-0 d-flex justify-content-end">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary mr-1 mb-1">Save</button>
                                <input type="reset" class="btn btn-light-secondary mb-1" value="Reset"/>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Table End -->
            </div>


            <div class="card">
                <form name="frm_survey_requisition" id="frm_survey_requisition">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title">Survey Requisition Setup </h4>
                                <div class="card-content">

                                    <div class="row">

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="zonearea_id">Zone </label>
                                                <select class="custom-select select2 form-control" id="zonearea_id"
                                                        name="zonearea_id">
                                                    <option value="">Select One</option>
                                                    @if(isset($zone_areas))
                                                        @foreach($zone_areas as $zonearea)
                                                            <option value="{{$zonearea->zonearea_id}}"
                                                                    @if(isset($team_employee->zonearea_id) &&
                                                                    ($team_employee->zonearea_id == $zonearea->zonearea_id))
                                                                    selected
                                                                @endif
                                                            >{{$zonearea->proposed_name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="party_id">Team(party) </label>
                                                <select class="custom-select select2 form-control" id="party_id"
                                                        name="party_id">
                                                    <option value="">Select One</option>
                                                    @if(isset($teams))
                                                        @foreach($teams as $team)
                                                            <option value="{{$team->team_id}}"
                                                                    @if(isset($team_employee->zonearea_id) &&
                                                                    ($team_employee->zonearea_id == $team->team_id))
                                                                    selected
                                                                @endif
                                                            >{{$team->team_name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="boat_id">Boat </label>
                                                <select class="custom-select select2 form-control" id="boat_id"
                                                        name="boat_id">
                                                    <option value="">Select One</option>
                                                    @if(isset($vehicles))
                                                        @foreach($vehicles as $vehicle)
                                                            <option value="{{$vehicle->vehicle_id}}"
                                                                    @if(isset($team_employee->zonearea_id) &&
                                                                    ($team_employee->zonearea_id == $vehicle->vehicle_id))
                                                                    selected
                                                                @endif
                                                            >{{$vehicle->vehicle_name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row">
									<div class="col-sm-4">
                                <div class="form-group">
                                    <label for="schedule_date" class="required">Schedule Date</label>
                                    <input type="text"
                                           autocomplete="off"
                                           class="form-control"
                                           data-toggle="datetimepicker"
                                           id="schedule_date"
                                           data-target="#active_to"
                                           name="schedule_date"
                                           placeholder="YYYY-MM-DD"
                                           required
                                           data-date-format="yyyy-mm-dd"
                                           value="{{old('schedule_date',isset
                                           ($schedule->schedule_date) ?
                                           date('Y-m-d',strtotime($schedule->schedule_date)) : '')}}"/>
                                    <small class="text-muted form-text"> </small>
                                </div>
                            </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="schedule_time" class="required">Schedule Time</label>
                                                <input type="text"
                                                       autocomplete="off"
                                                       class="form-control from-timepicker"
                                                       id="schedule_time"
                                                       name="schedule_time"
                                                       placeholder="HH:mm"
                                                       required
                                                       value="{{old('schedule_time',isset
                                           ($team_employee->schedule_time) ?
                                           date('H:i',strtotime($team_employee->schedule_time)) : '')}}"/>
                                                <small class="text-muted form-text"> </small>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label for="remarks">Remarks</label>
                                                <input type="text"
                                                       class="form-control"
                                                       id="remarks"
                                                       name="remarks"
                                                       placeholder="Enter Remark"
                                                       value="{{old('remarks',isset($survey_schedule->remarks) ? $survey_schedule->remarks : '')}}"
                                                >
                                                <small class="text-muted form-text"></small>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-12 pr-0 d-flex justify-content-end">
                                        <div class="form-group">
                                            <button id="schedule-detail-save" type="submit"
                                                    class="btn btn-primary mr-1 mb-1">Add
                                            </button>

                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="tbl_schedule_detail"
                                               class="table table-sm datatable mdl-data-table dataTable">
                                            <thead>
                                            <tr>
                                                <th>SL</th>

                                                <th>Designation name</th>
                                                <th>Emp Name</th>
                                                <th>From Time</th>
                                                <th>To Time</th>
                                                <th>Zone Area Name</th>

                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(isset($schedule_details) && count($schedule_details) > 0)
                                                @foreach($schedule_details as $schedule_detail)
                                                    @if($schedule_detail->team_employee_yn  == 'N')
                                                        <tr id="{{$schedule_detail->schedule_detail_id}}">
                                                            <td> {{$schedule_detail->schedule_detail_id}} </td>

                                                            <td> {{$schedule_detail->designation}} </td>
                                                            <td> {{$schedule_detail->emp_name}} </td>
                                                            {{--  <td> {{$schedule_detail->schedule_date}} </td>--}}
                                                            <td> {{$schedule_detail->schedule_from_time}} </td>
                                                            <td> {{$schedule_detail->schedule_to_time}} </td>
                                                            <td> {{$schedule_detail->proposed_name}} </td>

                                                            <td><a class="text-primary scheduledetailremove"><i
                                                                        class="bx bx-trash cursor-pointer"></i></a></td>


                                                        </tr>
                                                    @endif
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
                </form>
            </div>

            @if(isset($schedule->schedule_master_id))

                @include('schedule.partial.schedule-detail')

            @else

                @include('schedule.survey-datatable-list')

            @endif


        </div>
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">
        function surveyList() {
            $('#tbl_survey').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{route('schedule.survey-datatable-list')}}',
                    'type': 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', "name": 'DT_RowIndex'},
                    {data: 'schedule_name'},
                    {data: 'schedule_type.schedule_type_name'},//schedule_type
                    {data: 'survey_from_date'},
                    {data: 'survey_to_date'},
                    {data: 'active'},
                    {data: "action"},
                ]
            });
        }

        $(document).ready(function () {
            surveyList();

            //schedule_time
            $('#schedule_time').wickedpicker({
                title: 'Time in 24h',
                now: "9:00", //hh:mm 24 hour format only, defaults to current time
                twentyFour: true, //Display 24 hour format, defaults to false
            });

            $('#schedule_from_date,#schedule_to_date').datepicker({
                autoclose: true,
                todayHighlight: true,
                //minDate:new Date()
                //startDate: "now()"
                orientation: "bottom auto",
            });


            $("form[name='frm_survey_requisition']").validate({
                errorElement: "span", // contain the error msg in a small tag
                errorClass: 'help-block',
                errorPlacement: function (error, element) { // render error placement for each input type
                    if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
                        error.insertAfter($(element).closest('.form-group').children('div').children().last());
                    } else if (element.hasClass("ckeditor")) {
                        error.appendTo($(element).closest('.form-group'));
                    } else {
                        error.insertAfter(element);
                        // for other inputs, just perform default behavior
                    }
                },
                ignore: "",
                // Specify validation rules
                rules: {
                    // The key name on the left side is the name attribute
                    // of an input field. Validation rules are defined
                    // on the right side
                    /*user_password: {
                        required: true,
                        minlength: 6,
                        checklower: true,
                        checkupper: true,
                        checkdigit: true
                    },
                    confirm_user_password: {
                        required: true,
                        minlength: 6,
                        equalTo : "#user_password"
                    },
                    agree_term_and_condition: {
                        required: true
                    }*/

                },
                // Specify validation error messages
                messages: {
                    /*user_password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 6 characters long",
                        checklower: "Need atleast 1 lowercase alphabet",
                        checkupper: "Need atleast 1 uppercase alphabet",
                        checkdigit: "Need atleast 1 digit"

                    },
                    confirm_user_password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 6 characters long",
                        equalTo : "Password does not match"

                    }*/
                },
                highlight: function (element) {
                    $(element).closest('.help-block').removeClass('valid');
                    // display OK icon
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                    // add the Bootstrap error class to the control group
                },
                unhighlight: function (element) { // revert the change done by hightlight
                    $(element).closest('.form-group').removeClass('has-error');
                    // set error class to the control group
                },
                success: function (label, element) {
                    label.addClass('help-block valid');
                    // mark the current input as valid and display OK icon
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                },
                // Make sure the form is submitted to the destination defined
                // in the "action" attribute of the form when valid
                submitHandler: function (form) {
                    //form.submit();

                    //var zonearea_id = $('#zonearea_id').val();
                    var detail = {};
                    detail.zonearea_id = $('#zonearea_id').val();

                    console.log(detail);

                    $('#frm_survey_requisition').trigger("reset");
                }
            });
        });
    </script>

@endsection

