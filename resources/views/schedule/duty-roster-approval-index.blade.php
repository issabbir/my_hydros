@extends('layouts.default')

@section('title')

@endsection


@section('content')

    <div class="row">
        <div class="col-12">
            {{--  @json($month_selected)--}}

            <div class="card">
                <!-- Table Start -->
                <div class="card-body">
                    <h4 class="card-title">Duty Roaster Approval</h4>
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

                    <form id="frm_duty_roaster" method="get" action="{{route('schedule.duty-roster-approval-save')}}">
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
                                                        (ltrim($month_id,'0') == $month->month_id))
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
                                    <select class="form-control" id="year_id"
                                            name="year_id" required>
                                    </select>
                                </div>
                            </div>--}}


                        </div>
                        <div class="col-md-12 pr-0 d-flex justify-content-end">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary mr-1 mb-1">Search</button>

                                <input type="reset" class="btn btn-light-secondary mb-1" value="Reset"/>

                            </div>
                        </div>
                    </form>

                </div>
                <!-- Table End -->
            </div>

        </div>
    </div>
    @if(!empty($scheduleData))
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

    {{--@include('schedule.partial.duty-roaster-approval-chart')--}}
    {{--@if(isset($year_id) && isset($month_id))--}}
    @if(isset($vehicle_id))
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Duty Roaster Approval</h4>
            <hr>
            @if(!empty($scheduleData))
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Schedule Start Date</label>
                        <input disabled
                               type="text"
                               class="form-control"
                               value="{{date('d-m-Y', strtotime($scheduleData->start_schedule_date))}}"
                        >
                        <small class="text-muted form-text"></small>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Schedule End Date</label>
                        <input disabled
                               type="text"
                               class="form-control"
                               value="{{date('d-m-Y', strtotime($scheduleData->end_schedule_date))}}"
                        >
                        <small class="text-muted form-text"></small>
                    </div>
                </div>
            </div>
            @else
                <div class="row">
                    <div class="col-md-12" style="align-content: center">
                        <b>NO DATA FOUND FOR APPROVAL.</b>
                    </div>
                </div>
            @endif

        </div>
    </div>
    @endif

    {{--@if(isset($year_id) && isset($month_id))--}}
    @if(!empty($scheduleData))
        <div class="card">
            <div class="card-body">

                <div class="col-md-12">
                    <h4 class="card-title">Roaster Approval </h4>

                    <form>


                        {{--<div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="remarks"
                                        name="remarks"
                                        placeholder="Enter Remarks"
                                        value="{{old('remarks',isset($boatRosterApproval->remarks) ? $boatRosterApproval->remarks : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>

                        </div>--}}

                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="approve_yn" class="required">Approved?</label>
                                    <ul class="list-unstyled mb-0">
                                        <li class="d-inline-block mr-2 mb-1">
                                            <fieldset>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="approve_yn"
                                                           id="approve_yes"
                                                           value="{{\App\Enums\YesNoFlag::YES}}"
                                                           @if($boatRosterApproval && ($boatRosterApproval->approved_yn == \App\Enums\YesNoFlag::YES))
                                                           checked
                                                           @elseif(!$boatRosterApproval)
                                                           checked
                                                        @endif
                                                    />
                                                    <label class="custom-control-label" for="approve_yes"> Yes </label>
                                                </div>
                                            </fieldset>
                                        </li>
                                        <li class="d-inline-block mr-2 mb-1">
                                            <fieldset>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="approve_yn"
                                                           id="approve_no"
                                                           value="{{\App\Enums\YesNoFlag::NO}}"
                                                           @if($boatRosterApproval && ($boatRosterApproval->approved_yn != \App\Enums\YesNoFlag::YES))
                                                           checked
                                                        @endif
                                                    />
                                                    <label class="custom-control-label" for="approve_no"> No </label>
                                                </div>
                                            </fieldset>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 pr-0 d-flex justify-content-end">
                            <div class="form-group">
                                <button id="duty-roster-approve" type="button" class="btn btn-success mr-1 mb-1">Approval Process
                                </button>
                                <button id="duty-roster-reject" type="button" class="btn btn-danger mr-1 mb-1">Reject
                                </button>
                                <input id="get_val" type="hidden" value="{{$scheduleData->schedule_mst_id}}">
                                {{--<a class="btn btn-info mr-1 mb-1" id="downloadPDF" target="_blank" href="{{route('schedule.downloadPDF',['vehicle_id' => $vehicle_id,
            'year_id' => $year_id,
            'month_id' => $month_selected->month_name])}}"
                                   @if(isset($boatRosterApproval) && ($boatRosterApproval->approved_yn == \App\Enums\YesNoFlag::YES))
                                   style="display: block"

                                   @else
                                   style="display: none"

                                    @endif
                                >Download PDF </a>--}}

                            </div>
                        </div>

                    </form>
                </div>


            </div>
        </div>

    @endif

    @include('approval.workflowmodal')

@endsection

@section('footer-script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

    <script>
        let userRoles = '@php echo json_encode(Auth::user()->roles->pluck('role_key')); @endphp';//alert(userRoles)

        function selectMonth() {

            var month = new Date().getMonth() + 1;
            $('#month_id').val(month).trigger('change');
        }

        function populateYear() {
            var year = new Date().getFullYear();
            var till = 2099;
            var options = "";
            for (var y = year; y <= till; y++) {
                options += "<option " + "value='" + y + "'" + ">" + y + "</option>";
            }
            document.getElementById("year_id").innerHTML = options;
        }

        function selectYear() {
            var year = '{{$year_id}}';
            if (year == null || year == "" || year === undefined) {
                year = new Date().getFullYear();
            }
            $('#year_id').val(year).trigger('change');
        }

        $("#duty-roster-approve").click(function(){
            //let master_id = $('#get_val').val();
            let vehicle_id = $('#vehicle_id').val();
            approval(vehicle_id);
        });

        function approval(vehicle_id) {
            var myModal = $('#status-show');
            $("#workflow_id").val(2);
            let master_id = $('#get_val').val();
            $("#object_id").val(master_id);
            $("#get_url").val(window.location.pathname.slice(1)+'?vehicle_id='+vehicle_id);
            //$("#get_url").val(window.location.pathname.slice(1)+'?vehicle_id='+vehicle_id+'&pop=true');
            //alert($("#get_url").val())
            $.ajax({
                type: 'GET',
                url: '/schedule/approval',
                data: {workflowId: 2,objectid: master_id},
                success: function (msg) {
                    let wrkprc = msg.workflowProcess;
                    if (typeof wrkprc === 'undefined' || wrkprc === null|| wrkprc.length === 0) {
                        $('#current_status').hide();
                    }else{
                        $('#current_status').show();
                        $("#step_name").text(msg.workflowProcess[0].workflow_step.workflow);
                        $("#step_approve_by").text('By ' + msg.workflowProcess[0].user.emp_name);
                        $("#step_time").text(msg.workflowProcess[0].insert_date);
                        $("#step_approve_desig").text(msg.workflowProcess[0].user.designation);
                        $("#step_note").text(msg.workflowProcess[0].note);
                    }

                    let steps = "";
                    $('.step-progressbar').html(steps);
                    $.each(msg.progressBarData, function(j){
                        steps += "<li data-step="+msg.progressBarData[j].process_step+" class='step-progressbar__item'>"+ msg.progressBarData[j].workflow +"</li>"
                    });
                    $('.step-progressbar').html(steps);

                    let content = "";
                    $.each(msg.workflowProcess, function(i){
                        let note = msg.workflowProcess[i].note;
                        if(note==null){
                            note = '';
                        }
                        content += "<div class='row d-flex justify-content-between px-1'>" +
                            "<div class='hel'>" +
                            "<span class='ml-1 font-medium'>" +
                            "<h5 class='text-uppercase'>"+ msg.workflowProcess[i].workflow_step.workflow +"</h5>" +
                            "</span>" +
                            "<span>By "+ msg.workflowProcess[i].user.emp_name +"</span>" +
                            "</div>" +
                            "<div class='hel'>" +
                            "<span class='btn btn-secondary btn-sm mt-1' style='border-radius: 50px'>"+ msg.workflowProcess[i].insert_date +"</span>" +
                            "<br>" +
                            "<span style='margin-left: .3rem'>"+ msg.workflowProcess[i].user.designation +"</span>" +
                            "</div>" +
                            "</div>" +
                            "<hr>" +
                            "<span class='m-b-15 d-block border p-1' style='border-radius: 5px'>"+ note +"" +
                            "</span><hr>";//msg.workflowProcess[i].insert_date;
                    });

                    $('#content_bdy').html(content);

                    if(msg.current_step && msg.current_step.process_step){
                        $('.step-progressbar li').each(function(i){

                            if ($(this).data('step') > msg.current_step.process_step) {
                                $(this).addClass('step-progressbar__item step-progressbar__item--active');
                            }
                            else {
                                $(this).addClass('step-progressbar__item step-progressbar__item--complete');
                            }
                        })
                    }
                    else {
                        $('.step-progressbar li').addClass('step-progressbar__item step-progressbar__item--active');
                    }

                    $("#status_id").html(msg.options);

                    if(JSON.stringify(userRoles).indexOf(msg.next_step[0].user_role) > -1){
                        $(document).find('.no-permission').hide();//alert(msg.next_step[0].process_step)
                        if(msg.next_step[0].approve_yn == "Y"){
                            $("#radio_btn_por").css("display","block");
                        }else{
                            $("#radio_btn_por").css("display","none");
                        }
                        $(document).find('.no-permission').hide();
                        $(document).find('#status_note').show();
                        $(document).find('#button_portion').show();
                    }
                    else {
                        $(".no-permission").css("display","block");
                        $(document).find('#status_note').hide();
                        $(document).find('#button_portion').hide();
                    }
                }
            });
            myModal.modal({show: true});
            return false;
        }

        $('input[type=radio][name=final_approve_yn]').change(function() {
            if (this.value == 'Y') {
                $("#save_btn").css("display","none");
                $("#bonus_id_prm").val(33);
                $(document).find('#hide_div').hide();
                $("#close_btn").css("display","none");
                $("#approve_btn").css("display","block");
            }
            else if (this.value == 'N') {
                $(document).find('#hide_div').show();
                $("#save_btn").css("display","block");
                $("#close_btn").css("display","block");
                $("#approve_btn").css("display","none");
                $("#bonus_id_prm").val('');
            }
        });

        $(document).ready(function () {
            let vehicle_id = '{{request()->get('vehicle_id')}}';
            let pop = '{{request()->get('pop')}}';

            if (vehicle_id && pop) {
                if(pop=='true'){
                    approval(vehicle_id);
                }
            }

            $("#workflow_form").attr('action', '{{ route('schedule.approval-post') }}');

            $(document).on("click", "input[type='reset']", function () {
                // console.log('test');
                $("#vehicle_id").val(0).trigger('change.select2').select2({
                    placeholder: "Select One",
                });

                $("#month_id").val(0).trigger('change.select2').select2({
                    placeholder: "Select One",
                });
                var year = new Date().getFullYear();
                $("#year_id").val(year).change();
            });

            $('#duty-roster-approve').prop('disabled', false);
            $('#duty-roster-reject').prop('disabled', true);

            $('input[type=radio][name=approve_yn]').change(function () {
                if (this.value == 'Y') {
                    console.log('approved');
                    $('#duty-roster-approve').prop('disabled', false);
                    $('#duty-roster-reject').prop('disabled', true);
                } else {
                    console.log('rejected');

                    $('#duty-roster-approve').prop('disabled', true);
                    $('#duty-roster-reject').prop('disabled', false);
                }
            });

            $('#duty-roster-reject').click(function () {
                var detail = {};
                detail.boat_employee_id = $('#boat_employee_id').val();
                detail.remarks = $('#remarks').val();
                detail.vehicle_id = $('#vehicle_id').val();
                detail.month_id = $('#month_id').val();
                detail.year_id = $('#year_id').val();
                detail.schedule_mst_id = $('#get_val').val();
                detail.approved_yn = '{{\App\Enums\YesNoFlag::NO}}';
                console.log(detail);
                var url = '{{route('schedule.duty-roster-approval-approve')}}';
                $.ajax({
                    type: "POST",
                    url: url,
                    data: detail,
                    success: function (resp) {
                        console.log(resp);

                        if (resp.o_status_code == 1) {
                            alertify.success(resp.o_status_message);
                            window.location.reload();
                            $('#downloadPDF').css({display: 'none'});

                        } else {
                            alertify.error(resp.o_status_message);
                        }
                    },
                    error: function (resp) {
                        alert('error');
                    }
                });


            });

            //selectMonth();
            populateYear();

            selectYear();

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

        });

    </script>

@endsection
