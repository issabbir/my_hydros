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
                    <h4 class="card-title">Schedule Setup</h4>
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
                    <form name="frm-schedule-setup" id="frm-schedule-setup"
                          @if(isset($schedule->schedule_master_id)) action="{{route('schedule.schedule-update',
                    [$schedule->schedule_master_id])}}"
                          @else action="{{route('schedule.schedule-post')}}" @endif method="post">
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
                                        class="form-control bn-lang-val-check"
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
                                    <label for="description">Schedule Description</label>
                                    <input type="text"
                                           class="form-control"
                                           id="description"
                                           name="description"
                                           placeholder="Enter Description"
                                           value="{{old('description',isset($schedule->description) ? $schedule->description : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>


                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="schedule_type_id" class="required">Schedule Type </label>
                                    <select class="form-control" required id="schedule_type_id"
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
                                                           value="{{\App\Enums\YesNoFlag::YES}}" checked
                                                           @if(isset($schedule))
                                                           @if($schedule && ($schedule->active_yn == \App\Enums\YesNoFlag::YES))
                                                           checked
                                                           @elseif(!$schedule)
                                                           checked
                                                        @endif
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
                                                           @if(isset($schedule))
                                                           @if($schedule && ($schedule->active_yn != \App\Enums\YesNoFlag::YES))
                                                           checked
                                                        @endif
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
                        {{--@json($schedule->rejected_yn)--}}

                        @if(isset($schedule->rejected_yn) && $schedule->rejected_yn == 'Y')
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label>Schedule Rejection Reason </label>
                                        <div class="alert alert-danger" role="alert">
                                            {{$schedule->rejected_comment}}
                                        </div>
                                    </div>
                                </div>


                            </div>

                        @endif

                        <div class="col-md-12 pr-0 d-flex justify-content-end">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary mr-1 mb-1">Save</button>
                                <a type="reset" href="{{route("schedule.schedule-index")}}"
                                   class="btn btn-light-secondary mb-1"> Back</a>
                                {{--<input type="reset" class="btn btn-light-secondary mb-1" value="Reset"/>--}}
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12 pr-0 d-flex justify-content-start">
                            <button id="show_form" onclick="$('#report_list').toggle('slow')"
                                    class="btn btn-secondary mb-1 ml-1"><i class="bx bxs-report cursor-pointer"></i>
                                Show Previous Report
                            </button>
                        </div>
                    </div>

                    <form id="report-generator" method="POST" action="{{route('report')}}" target="_blank">
                        {{ csrf_field() }}
                        <input type="hidden" id="actionInput" value="{{route('report')}}">
                        <div class="row" id="report_list" style="display: none">
                            <div class="col-md-3 ml-1">
                                <label class="required">Schedule List</label>
                                <select name="P_SCHEDULE_MASTER_ID" id="P_SCHEDULE_MASTER_ID"
                                        class="form-control select2"
                                        required>
                                    <option value="">Select One</option>
                                    @if(isset($schedules))
                                        @foreach($schedules as $schedule)
                                            <option value="{{$schedule->schedule_master_id}}"
                                            >{{$schedule->schedule_name}}
                                                ( {{$schedule->schedule_from_date->format('Y-m-d')}}
                                                - {{$schedule->schedule_to_date->format('Y-m-d')}} )
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="type">Report Type</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="pdf">PDF</option>
                                    <option value="xlsx">Excel</option>
                                </select>
                                <input type="hidden" value="{{$report->report_xdo_path}}" name="xdo"/>
                                <input type="hidden" value="{{$report->report_id}}" name="rid"/>
                                <input type="hidden" value="{{$report->report_name}}" name="filename"/>
                            </div>
                            <div class="col-md-3 mt-2">
                                <button type="submit" class="btn btn btn-dark shadow mr-1 mb-1 btn-secondary">Generate
                                    Report
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
                <!-- Table End -->
            </div>

            @if(isset($schedule_master_id))
                @include('schedule.partial.schedule-detail')
            @else
                @include('schedule.schedule-datatable-list')
            @endif


        </div>
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">
        function scheduleList() {
            $('#tbl_schedule').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{route('schedule.schedule-datatable-list')}}',
                    'type': 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', "name": 'DT_RowIndex'},
                    {data: 'schedule_name'},
                    {data: 'schedule_type.schedule_type_name'},//schedule_type
                    /*  {data: 'team.team_name'},*/
                    /*{data: 'zonearea.proposed_name'},*/
                    {data: 'schedule_from_date'},
                    {data: 'schedule_to_date'},
                    {data: 'active'},
                    {data: "action"},
                ]
            });
        }

        $(document).ready(function () {
            scheduleList();

            $('#schedule_from_date').datepicker({
                autoclose: true,
                todayHighlight: true,
                //minDate:new Date()
                //startDate: "now()",
                orientation: "bottom auto",
            });
            $('#schedule_to_date').datepicker({
                autoclose: true,
                todayHighlight: true,
                //minDate:new Date()
                //startDate: "now()",
                orientation: "bottom auto",
            });


            $("form[name='frm-schedule-setup']").validate({
                errorElement: "span", // contain the error msg in a small tag
                errorClass: 'help-block error',
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
                    schedule_type_id: {
                        required: true
                    }

                },
                // Specify validation error messages
                messages: {
                    schedule_type_id: "Please select one",
                },
                submitHandler: function (form) {
                    console.log('submitHandler');
                    var from_date = $('#schedule_from_date').val();

                    if (from_date == null || from_date == undefined || from_date == "") {
                        alertify.error('From date is required');
                        return;
                    }
                    var parts = from_date.split('-');
// Please pay attention to the month (parts[1]); JavaScript counts months from 0:
// January - 0, February - 1, etc.
                    var fdt = new Date(parts[0], parts[1] - 1, parts[2]);

                    var to_date = $('#schedule_to_date').val();

                    if (to_date == null || to_date == undefined || to_date == "") {
                        alertify.error('To date is required');
                        return;
                    }

                    var tparts = to_date.split('-');
// Please pay attention to the month (parts[1]); JavaScript counts months from 0:
// January - 0, February - 1, etc.
                    var tdt = new Date(tparts[0], tparts[1] - 1, tparts[2]);

                    console.log('fdt', fdt);
                    console.log('tdt', tdt);
                    if (tdt < fdt) {
                        alertify.error('From date/To date is not valid!');
                        return;
                    }


                    //alertify.success('OK');

                    form.submit();
                }
            });

        });
    </script>

@endsection

