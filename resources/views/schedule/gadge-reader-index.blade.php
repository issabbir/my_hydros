@extends('layouts.default')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->

@endsection
@section('content')

    <div class="content-body">
        <section id="form-repeater-wrapper">
            <!-- form default repeater -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
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

                        <div class="card-content">
                            <div class="card-body">
                                <form enctype="multipart/form-data"
                                      @if(isset($scheduleMaster->schedule_mst_id)) action="{{route('schedule.gadge-reader-roster-update',[$scheduleMaster->schedule_mst_id])}}"
                                      @else action="{{route('schedule.gadge-reader-roster-post')}}" @endif method="post">
                                    @csrf
                                    @if (isset($scheduleMaster->schedule_mst_id))
                                        @method('PUT')
                                    @endif

                                    <h5 class="card-title">Gauge Station List</h5>
                                    <hr>
                                    <div class="col-md-4 pl-1">{{--{{dd($stationMstData)}}--}}
                                        <div class="form-group">
                                            <label for="team_id" class="required">Gauge Station</label>
                                            <select class="custom-select select2 form-control" required id="station_id" name="station_id" @if(isset($scheduleMaster)) disabled @endif>
                                                <option value="">Select One</option>
                                                @foreach($stationList as $value)
                                                    <option value="{{$value->station_id}}"
                                                        {{isset($scheduleMaster->station_id) && $scheduleMaster->station_id == $value->station_id ? 'selected' : ''}}
                                                    >{{$value->station_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <h4 class="card-title">Gauge Station Roster Setup</h4>
                                    <hr>

                                    <fieldset class="border p-1 mt-1 mb-1 col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label class="required">From</label>
                                                    <input type="text"
                                                           autocomplete="off"
                                                           class="form-control datetimepicker-input"
                                                           data-toggle="datetimepicker"
                                                           id="tab_roster_from"
                                                           data-target="#tab_roster_from"
                                                           name="tab_roster_from"
                                                           value=""
                                                           placeholder="YYYY-MM-DD"
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label class="required">To</label>
                                                    <input type="text"
                                                           autocomplete="off"
                                                           class="form-control datetimepicker-input"
                                                           data-toggle="datetimepicker"
                                                           id="tab_roster_to"
                                                           data-target="#tab_roster_to"
                                                           name="tab_roster_to"
                                                           value=""
                                                           placeholder="YYYY-MM-DD"
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label class="required">Shift</label>
                                                    <select class="select2 form-control pl-0 pr-0 shift_id" id="tab_shift_id">
                                                        <option value="">Select One</option>
                                                        @if(isset($shiftList))
                                                            @foreach($shiftList as $value)
                                                                <option value="{{$value->shift_id}}">
                                                                    {{date('H:i',strtotime($value->shift_from_time)).' ~ '.date('H:i',strtotime($value->shift_to_time))}}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            {{--<div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="designation_id"
                                                           class="required">Designation</label>
                                                    <select class="select2 form-control pl-0 pr-0 designation_id" id="designation_id">
                                                        <option value="">Select One</option>
                                                        @if(isset($designations))
                                                            @foreach($designations as $designation)
                                                                <option value="{{$designation->designation_id}}">
                                                                    {{$designation->designation}}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>--}}
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="emp_id" class="required">Employee</label>
                                                    <select class="select2 form-control ipl-0 pr-0 emp_id" id="emp_id">
                                                        <option value="">Select One</option>
                                                        @if(isset($employee))
                                                            @foreach($employee as $data)
                                                                <option value="{{$data->emp_id}}">
                                                                    {{$data->emp_name}}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="name">Mobile Number</label>
                                                    <input type="text" class="form-control mobile_number" id="tab_mobile_number">
                                                    <small class="text-muted form-text"></small>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label class="required">Offday</label>
                                                    <select class="select2 form-control pl-0 pr-0 offday_id" id="tab_offday_id">
                                                        <option value="">Select One</option>
                                                        @if(isset($offdayList))
                                                            @foreach($offdayList as $value)
                                                                <option value="{{$value->offday_id}}">
                                                                    {{$value->offday_name}}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div id="start-no-field" class="form-group">
                                                    <label>Remarks</label>
                                                    <input type="text" id="tab_remrks" name="tab_remrks"
                                                           class="form-control" value="">
                                                </div>
                                            </div>

                                            <div class="col-sm-1" align="right">
                                                <div id="start-no-field">
                                                    <label for="seat_to1">&nbsp;</label><br/>
                                                    <button type="button" id="append"
                                                            class="btn btn-primary mb-1 add-row">
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
                                                            aria-colindex="2" class="" width="10%">From
                                                        </th>
                                                        <th role="columnheader" scope="col"
                                                            aria-colindex="4" class="" width="10%">To
                                                        </th>
                                                        <th role="columnheader" scope="col"
                                                            aria-colindex="5" class="" width="10%">Shift
                                                        </th>
                                                        {{--<th role="columnheader" scope="col"
                                                            aria-colindex="6" class="" width="13%">Designation
                                                        </th>--}}
                                                        <th role="columnheader" scope="col"
                                                            aria-colindex="6" class="" width="17%">Employee
                                                        </th>
                                                        <th role="columnheader" scope="col"
                                                            aria-colindex="6" class="" width="10%">Mobile
                                                        </th>
                                                        <th role="columnheader" scope="col"
                                                            aria-colindex="7" class="" width="10%">Off Day
                                                        </th>
                                                        <th role="columnheader" scope="col"
                                                            aria-colindex="7" class="" width="15%">Remarks
                                                        </th>
                                                    </tr>
                                                    </thead>

                                                    <tbody role="rowgroup" id="comp_body">
                                                    @if(!empty($scheduleDetail))
                                                        @foreach($scheduleDetail as $key=>$value)
                                                            <tr role="row">
                                                                <td aria-colindex="1" role="cell" class="text-center">
                                                                    <input type='checkbox' name='record' value="{{$value->emp_id.'+'.$value->schedule_dtl_id}}">
                                                                    <input type="hidden" name="schedule_dtl_id[]"
                                                                           value="{{$value->schedule_dtl_id}}"
                                                                           class="schedule_dtl_id">
                                                                    <input type="hidden" name="delete_emp_id[]"
                                                                           value="{{$value->emp_id}}"
                                                                           class="get_emp_id">
                                                                    <input type="hidden" name="schedule_mst_id[]"
                                                                           value="{{$value->schedule_mst_id}}">
                                                                </td>
                                                                <td aria-colindex="4" role="cell"
                                                                    id="tab_roster_from_pick_{{$key + 1}}"
                                                                    onclick="call_date_picker(this)"
                                                                    data-target-input="nearest">
                                                                    <input type="text"
                                                                           autocomplete="off"
                                                                           class="form-control datetimepicker-input"
                                                                           data-toggle="datetimepicker"
                                                                           data-target="#tab_roster_from_pick_{{$key + 1}}"
                                                                           name="tab_roster_from[]"
                                                                           value="{{date('Y-m-d', strtotime($value->roster_from_date))}}"
                                                                           data-predefined-date=""
                                                                    >
                                                                </td>
                                                                <td aria-colindex="4" role="cell"
                                                                    id="tab_roster_to_pick_{{$key + 1}}"
                                                                    onclick="call_date_picker(this)"
                                                                    data-target-input="nearest">
                                                                    <input type="text"
                                                                           autocomplete="off"
                                                                           class="form-control datetimepicker-input"
                                                                           data-toggle="datetimepicker"
                                                                           data-target="#tab_roster_to_pick_{{$key + 1}}"
                                                                           name="tab_roster_to[]"
                                                                           value="{{date('Y-m-d', strtotime($value->roster_to_date))}}"
                                                                           data-predefined-date=""
                                                                    >
                                                                </td>
                                                                <td aria-colindex="2" role="cell">
                                                                    <select class="custom-select form-control select2"
                                                                            id="tab_shift_id_list_{{$key + 1}}"
                                                                            name="tab_shift_id[]">
                                                                        <option value="">Select One</option>
                                                                        @foreach($shiftList as $values)
                                                                            <option value="{{$values->shift_id}}"
                                                                                {{isset($value->shift_id) && $value->shift_id == $values->shift_id ? 'selected' : ''}}
                                                                            >{{date('H:i',strtotime($values->shift_from_time)).' ~ '.date('H:i',strtotime($values->shift_to_time))}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                {{--<td aria-colindex="2" role="cell">
                                                                    <select class="custom-select form-control select2 tab_designation_id"
                                                                            id="tab_designation_id_list_{{$key + 1}}"
                                                                            name="tab_designation_id[]">
                                                                        <option value="">Select One</option>
                                                                        @foreach($designations as $values)
                                                                            <option value="{{$values->designation_id}}"
                                                                                {{isset($value->designation_id) && $value->designation_id == $values->designation_id ? 'selected' : ''}}
                                                                            >{{$values->designation}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>--}}
                                                                <td aria-colindex="2" role="cell">
                                                                    <select class="custom-select form-control select2 tab_emp_id"
                                                                            id="tab_emp_id_list_{{$key + 1}}"
                                                                            name="tab_emp_id[]">
                                                                        <option value="">Select One</option>
                                                                        @foreach($tab_employees as $values)
                                                                            <option value="{{$values->emp_id}}"
                                                                                {{isset($value->emp_id) && $value->emp_id == $values->emp_id ? 'selected' : ''}}
                                                                            >{{$values->emp_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td aria-colindex="7" role="cell">
                                                                    <input type="text" class="form-control"
                                                                           name="tab_mobile_number[]"
                                                                           value="{{$value->mobile_no}}">
                                                                </td>
                                                                <td aria-colindex="2" role="cell">
                                                                    <select class="custom-select form-control select2"
                                                                            id="tab_offday_id_list_{{$key + 1}}"
                                                                            name="tab_offday_id[]">
                                                                        <option value="">Select One</option>
                                                                        @foreach($offdayList as $values)
                                                                            <option value="{{$values->offday_id}}"
                                                                                {{isset($value->offday_id) && $value->offday_id == $values->offday_id ? 'selected' : ''}}
                                                                            >{{$values->offday_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td aria-colindex="7" role="cell">
                                                                    <input type="text" class="form-control"
                                                                           name="tab_remrks[]"
                                                                           value="{{$value->remarks}}">
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-start">

                                            <button type="button"
                                                    class="btn btn-primary mb-1 delete-row">
                                                Delete
                                            </button>
                                        </div>
                                    </fieldset>
                                    <div class="form-group">
                                        <div class="col-md-12 pr-0 d-flex justify-content-end">
                                            <div class="form-group">
                                                @if(!isset($scheduleMaster))
                                                    <button id="boat-employee-save" type="submit"
                                                            class="btn btn-primary mr-1 mb-1">Save
                                                    </button>
                                                @else
                                                    <button id="boat-employee-save" type="submit"
                                                            class="btn btn-primary mr-1 mb-1">Update
                                                    </button>
                                                @endif
                                                <input id="boat-employee-reset" type="reset"
                                                       class="btn btn-light-secondary mb-1" value="Reset"/>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ form default repeater -->

        </section>
    </div>

    <div class="card">
        <div class="card-body">
            <section id="horizontal-vertical">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Gauge Roster Schedule List</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table id="gadge-schedule-list" class="table table-sm datatable mdl-data-table dataTable">
                                            <thead>
                                            <tr>
                                            <tr>
                                                <th>#</th>
                                                <th>Gauge Station</th>
                                                <th>Entry Date</th>
                                                <th>Approved On</th>
                                                <th style="display:none;">
                                                <th>Action</th>
                                            </tr>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    @include('approval.workflowmodal')

    <div id="roster-modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-uppercase text-left">
                        Roster Detail Information
                    </h4>
                    <button class="close" type="button" data-dismiss="modal" area-hidden="true">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label><h4><b>STATION: </b></h4></label>
                            <label id="station_name"></label>
                        </div>
                    </div>
                    <hr>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table-data" class="table table-sm datatable mdl-data-table dataTable">
                                    <thead>
                                    <tr>
                                        <th role="columnheader" scope="col"
                                            aria-colindex="4" class="" width="10%">From
                                        </th>
                                        <th role="columnheader" scope="col"
                                            aria-colindex="4" class="" width="10%">To
                                        </th>
                                        <th role="columnheader" scope="col"
                                            aria-colindex="9" class="" width="10%">Shift
                                        </th>
                                        <th role="columnheader" scope="col"
                                            aria-colindex="6" class="" width="17%">Employee
                                        </th>
                                        <th role="columnheader" scope="col"
                                            aria-colindex="6" class="" width="10%">Mobile
                                        </th>
                                        <th role="columnheader" scope="col"
                                            aria-colindex="3" class="" width="10%">Off Day
                                        </th>
                                        <th role="columnheader" scope="col"
                                            aria-colindex="7" class="" width="15%">Remarks
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody id="table-data-body">

                                    </tbody>
                                </table>
                            </div>
                            <br> <br>
                        </div>
                        <!-- Table End -->
                    </div>
                    <div class="form-group mt-1">
                        <div class="col-md-12 pr-0 d-flex justify-content-end">
                            <div class="form-group">

                                <button class="btn btn-primary mr-1 mb-1"
                                        type="button" data-dismiss="modal">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer-script')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        var dataArray = new Array();

        var userRoles = '@php echo json_encode(Auth::user()->roles->pluck('role_key')); @endphp';
         //alert(userRoles);

        $("#show_dtl_btn").click(function(){
            let schedule_mst_id = $(this).val();
            getData(schedule_mst_id);
        });

        function convertDate(inputFormat) {
            function pad(s) {
                return (s < 10) ? '0' + s : s;
            }

            var d = new Date(inputFormat)
            return [d.getFullYear(), pad(d.getMonth() + 1), pad(d.getDate())].join('-')
        }

        function getData(schedule_mst_id) {
            let myModal = $('#roster-modal');
            $.ajax({
                url: '/schedule/get-dtl-data/' + schedule_mst_id,
                success: function (msg) {
                    let markup = '';
                    let mst_data = msg.mst_data;
                    let dtl_data = msg.dtl_data;console.log(dtl_data)
                    $("#table-data > tbody").html("");
                    $("#station_name").html("");
                    if(mst_data){
                        $("#station_name").html("<h4><b>"+mst_data.station_name+"</b></h4>");
                    }
                    if(dtl_data){
                        $.each(dtl_data, function (i) {
                            let mobile = dtl_data[i].mobile_no;
                            let remarks = dtl_data[i].remarks;
                            if(!remarks){
                                remarks = '';
                            }
                            if(!mobile){
                                mobile = '';
                            }
                            markup += "<tr role='row'>" +
                                "<td aria-colindex='4' role='cell'>" + convertDate(dtl_data[i].roster_from_date) + "</td>" +
                                "<td aria-colindex='4' role='cell'>" + convertDate(dtl_data[i].roster_to_date) + "</td>" +
                                "<td aria-colindex='9' role='cell'>" + dtl_data[i].shift + "</td>" +
                                "<td aria-colindex='6' role='cell'>" + dtl_data[i].emp_name + "</td>" +
                                "<td aria-colindex='6' role='cell'>" + mobile + "</td>" +
                                "<td aria-colindex='3' role='cell'>" + dtl_data[i].offday_name + "</td>" +
                                "<td aria-colindex='7' role='cell'>" + remarks + "</td>" +
                                "</tr>";

                        });
                        $("#table-data tbody").html(markup);
                    }

                }
            });
            myModal.modal({show: true});
            return false;
        }

        $('#gadge-schedule-list tbody').on('click', '.editButton', function () {
            var data_row = $('#gadge-schedule-list').DataTable().row( $(this).parents('tr') ).data();
            var schedule_mst_id = data_row.schedule_mst_id;
            approval(schedule_mst_id);
        });

        function approval(schedule_mst_id) {
            var myModal = $('#status-show');
            $("#get_url").val(window.location.pathname.slice(1)+'?id='+schedule_mst_id);
            $("#workflow_id").val(4);
            $("#object_id").val(schedule_mst_id);
            $("#show_dtl_btn").val(schedule_mst_id);


            $.ajax({
                type: 'GET',
                url: '/schedule/approval',
                data: {workflowId: 4,objectid: schedule_mst_id},
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

                    if ($.isEmptyObject(msg.next_step)) {
                        $(".no-permission").css("display","block");
                        $(document).find('#status_note').hide();
                        $(document).find('#button_portion').hide();
                    }else{
                        if(msg.next_step[0].user_role && JSON.stringify(userRoles).indexOf(msg.next_step[0].user_role) > -1){
                            $(document).find('.no-permission').hide();
                            if(msg.next_step[0].approve_yn == "Y"){
                                $("#radio_btn_por").css("display","block");
                            }else{
                                $("#radio_btn_por").css("display","none");
                            }
                            $(document).find('.no-permission').hide();
                            $(document).find('#status_note').show();
                            $(document).find('#button_portion').show();
                        }else {
                            $(".no-permission").css("display","block");
                            $("#radio_btn_por").css("display","none");
                            $(document).find('#status_note').hide();
                            $(document).find('#button_portion').hide();
                        }
                    }

                }
            });

            myModal.modal({show: true});
            return false;
        }

        $('input[type=radio][name=final_approve_yn]').change(function() {
            if (this.value == 'Y') {
                $("#save_btn").css("display","none");
                $("#bonus_id_prm").val(39);
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

        function get_emp_dropdown_form() {
            let designation_id = $('.designation_id option:selected').val();

            if (designation_id != undefined || designation_id != null) {
                get_emp_form(designation_id);
            }
            $('.designation_id').change(function () {
                var id = $(this).val();
                get_emp_form(id);
            });
        }

        function get_emp_form(id){
            var url = '{{route('schedule.employee-by-designation')}}';
            $.ajax({
                type: 'post',
                url: url,
                data: {id: id},
                success: function (msg) {
                    $(".emp_id").html(msg);
                }
            });
        }


        /*function get_emp_dropdown() {
            let designation_id = $('.tab_designation_id option:selected').val();
            let emp_id = $('.get_emp_id').val();

            if (designation_id != undefined || designation_id != null) {
                get_emp(designation_id, emp_id);
            }
            $('.tab_designation_id').change(function () {
                let emp_id = $('.get_emp_id').val();
                var id = $(this).val();
                get_emp(id,emp_id);
            });
        }

        function get_emp(id,emp_id){
            var url = '{{route('schedule.employee-by-designation')}}';
            $.ajax({
                type: 'post',
                url: url,
                data: {id: id, emp_id: emp_id},
                success: function (msg) {
                    $(".tab_emp_id").html(msg);
                }
            });
        }*/

        function call_date_picker(e) {
            datePicker(e);
        }

        function gadgeStationScheduleList() {
            var url = '{{route('schedule.gadge-reader-roster-datatable-list')}}';
            var oTable =$('#gadge-schedule-list').DataTable({
                processing: true,
                serverSide: true,
                order: [],
                ajax: {
                    url: url,
                    'type': 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'station_name', name: 'station_name', searchable: true},
                    {data: 'insert_date', name: 'insert_date', searchable: true},
                    {data: 'approve_date', name: 'approve_date', searchable: true},
                    {data: 'schedule_mst_id', name: 'schedule_mst_id'},
                    {data: 'action', name: 'action', searchable: false},
                ]
            });
            oTable.columns( [4] ).visible( false );
        };

        /*$('.designation_id').change(function () {
            var id = $(this).val();
            get_emp(id);
        });*/

        $(document).ready(function () {
            $("#show_dtl_btn").show();
            var schedule_mst_id = '{{request()->get('id')}}';

            if (schedule_mst_id) {
                approval(schedule_mst_id);
            }

            $("#workflow_form").attr('action', '{{ route('schedule.approval-post') }}');
            //get_emp_dropdown();
            //get_emp_dropdown_form();
            datePicker('#tab_roster_to');
            datePicker('#tab_roster_from');
            gadgeStationScheduleList();
        });

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

        $(".add-row").click(function () {
            let station_id = $("#station_id option:selected").val();
            let tab_roster_from = $("#tab_roster_from").val();
            let tab_roster_to = $("#tab_roster_to").val();
            let tab_shift_id = $("#tab_shift_id option:selected").val();
            let tab_shift = $("#tab_shift_id option:selected").text();
            /*let tab_designation_id = $("#designation_id option:selected").val();
            let tab_designation = $("#designation_id option:selected").text();*/
            let tab_emp_id = $("#emp_id option:selected").val();
            let tab_emp_name = $("#emp_id option:selected").text();
            let tab_mobile_number = $("#tab_mobile_number").val();
            let tab_offday_id = $("#tab_offday_id option:selected").val();
            let tab_offday = $("#tab_offday_id option:selected").text();
            let tab_remrks = $("#tab_remrks").val();

            if(!station_id){
                Swal.fire('Please select Gauge Station.');
                return false;
            }
            if(tab_roster_from){
                if(!dateCheck(tab_roster_from,tab_roster_to,tab_roster_from)){
                    Swal.fire('Please select date between From and To Date.');
                    return false;
                }
            }else{
                Swal.fire('Please select Date');
                return false;
            }

            if (tab_roster_from != '' && tab_roster_to != '' && tab_shift_id != '' /*&& tab_designation_id != ''*/ && tab_emp_id != ''&& tab_offday_id != ''&& station_id != '') {
                /*if ($.inArray(tab_emp_id, dataArray) > -1) {
                    Swal.fire('Duplicate value not allowed.');
                } else {*/
                    let markup = "<tr role='row'>" +
                        "<td aria-colindex='1' role='cell' class='text-center'>" +
                        "<input type='checkbox' name='record' value='" + tab_emp_id  + "+" + "" + "'>" +
                        "<input type='hidden' name='station_id[]' value='" + station_id + "'>" +
                        "<input type='hidden' name='schedule_dtl_id[]' value=''>" +
                        "<input type='hidden' name='tab_roster_from[]' value='" + tab_roster_from + "'>" +
                        "<input type='hidden' name='tab_roster_to[]' value='" + tab_roster_to + "'>" +
                        "<input type='hidden' name='tab_shift_id[]' value='" + tab_shift_id + "'>" +
                        /*"<input type='hidden' name='tab_designation_id[]' value='" + tab_designation_id + "'>" +*/
                        "<input type='hidden' name='tab_emp_id[]' value='" + tab_emp_id + "'>" +
                        "<input type='hidden' name='tab_mobile_number[]' value='" + tab_mobile_number + "'>" +
                        "<input type='hidden' name='tab_offday_id[]' value='" + tab_offday_id + "'>" +
                        "<input type='hidden' name='tab_remrks[]' value='" + tab_remrks + "'>" +
                        "</td><td aria-colindex='2' role='cell'>" + tab_roster_from + "</td>" +
                        "<td aria-colindex='4' role='cell'>" + tab_roster_to + "</td>" +
                        "<td aria-colindex='5' role='cell'>" + tab_shift + "</td>" +
                        /*"<td aria-colindex='6' role='cell'>" + tab_designation + "</td>" +*/
                        "<td aria-colindex='6' role='cell'>" + tab_emp_name + "</td>" +
                        "<td aria-colindex='6' role='cell'>" + tab_mobile_number + "</td>" +
                        "<td aria-colindex='6' role='cell'>" + tab_offday + "</td>" +
                        "<td aria-colindex='7' role='cell'>" + tab_remrks + "</td></tr>";
                    /*$("#tab_designation_id").val('').trigger('change');*/
                    $("#tab_emp_id").val('').trigger('change');
                    $("#tab_offday_id").val('').trigger('change');
                    $("#tab_shift_id").val('').trigger('change');
                    $("#tab_roster_from").val("");
                    $("#tab_roster_to").val("");
                    $("#tab_mobile_number").val("");
                    $("#tab_remrks").val("");
                    $("#table-exam-result tbody").append(markup);

                    dataArray.push(tab_emp_id);
                //}

            } else {
                Swal.fire('Fill required value.');
            }
        });

        $(".delete-row").click(function () {
            let arr_stuff = [];
            let schedule_dtl_id = [];
            $(':checkbox:checked').each(function (i) {
                arr_stuff[i] = $(this).val();
                let sd = arr_stuff[i].split('+');
                if (sd[1]) {
                    schedule_dtl_id.push(sd[1]);
                }
            });

            if (schedule_dtl_id.length != 0) {
                Swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: 'GET',
                            url: '/schedule/remove-dtl-data',
                            data: {schedule_dtl_id: schedule_dtl_id},
                            success: function (msg) {
                                if (msg == 0) {
                                    Swal.fire({
                                        title: 'Something Went Wrong!!.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                    //return false;
                                } else {
                                    Swal.fire({
                                        title: 'Entry Successfully Deleted!',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then(function () {
                                        $('td input:checked').closest('tr').remove();
                                    });
                                }
                            }
                        });
                    }
                });
            } else {
                /*Swal.fire({
                    title: 'Entry Successfully Deleted!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(function () {*/
                    $('td input:checked').closest('tr').remove();
                //});
            }
        });

    </script>

@endsection

