
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <h4 class="card-title">Schedule for different team </h4>
                <div class="card-content">

                    <div class="table-responsive">
                        <table id="tbl_schedule_detail" class="table table-sm datatable mdl-data-table dataTable">
                            <thead>
                            <tr>
                                <th>SL</th>

                                <th>Date</th>

                                <th>Team Name</th>

                                <th>Zone Area Name</th>

                                <th>Vehicle Name</th>

                                <th>From Time</th>
                                <th>To Time</th>

                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if(isset($schedule_assignments) && count($schedule_assignments) > 0)
                                @foreach($schedule_assignments as $schedule_assignment)

                                    <tr id="{{$schedule_assignment->schedule_assignment_id}}">
                                        <td> {{$schedule_assignment->schedule_assignment_id}} </td>
                                        <td>
                                            @if(isset($schedule_assignment->schedule_date))
                                                {{date('Y-m-d', strtotime($schedule_assignment->schedule_date))}}
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($schedule_assignment->team))
                                                {{$schedule_assignment->team->team_name}}
                                            @endif

                                        </td>

                                        <td>
                                            @if(isset($schedule_assignment->zonearea))
                                                {{$schedule_assignment->zonearea->proposed_name}}
                                            @endif

                                        </td>


                                        <td>
                                            @if(isset($schedule_assignment->vehicle))
                                                {{$schedule_assignment->vehicle->vehicle_name}}
                                            @endif

                                        </td>

                                        <td>
                                            @if(isset($schedule_assignment->schedule_from_time))
                                                {{date('H:i', strtotime($schedule_assignment->schedule_from_time))}}
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($schedule_assignment->schedule_to_time))
                                                {{date('H:i', strtotime($schedule_assignment->schedule_to_time))}}
                                            @endif
                                        </td>

                                        <td><a class="text-primary scheduledetailremove"><i
                                                    class="bx bx-trash cursor-pointer"></i></a></td>


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



@if($schedule_mst->approved_yn =='Y')
    <div class="card" id="show-div">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12" style="align-content: center">
                    <b>SCHEDULE APPROVED.</b>
                </div>
            </div>
        </div>
    </div>
@else
<div class="card">
    <div class="card-body">

        <div class="col-md-12">
            <h4 class="card-title">Approval Decision</h4>

            {{--<form action="{{route('schedule.schedule-approval-update',
                    [$schedule->schedule_master_id])}}" method="post">
                @method('PUT')

                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <input
                                type="text"
                                class="form-control"
                                id="remarks"
                                name="remarks"
                                placeholder="Enter Remarks"
                                value="{{old('remarks',isset($schedule->remarks) ? $schedule->remarks : '')}}"
                            >
                            <small class="text-muted form-text"></small>
                        </div>
                    </div>

                </div>

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
                                                   @if($schedule && ($schedule->active_yn == \App\Enums\YesNoFlag::YES))
                                                   checked
                                                   @elseif(!$schedule)
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
                                                   @if($schedule && ($schedule->active_yn != \App\Enums\YesNoFlag::YES))
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


            </form>--}}
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
                                               @if($schedule && ($schedule->active_yn == \App\Enums\YesNoFlag::YES))
                                               checked
                                               @elseif(!$schedule)
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
                                               @if($schedule && ($schedule->active_yn != \App\Enums\YesNoFlag::YES))
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
                    <button id="schedule_approve" type="button" class="btn btn-success mr-1 mb-1">Approval Process</button>
                    <button id="schedule_reject" type="submit" class="btn btn-danger mr-1 mb-1">Reject</button>
                    <input id="get_val" type="hidden" value="{{$schedule_master_id}}">
                </div>
            </div>
        </div>


    </div>
</div>
@endif
@section('footer-script')
    <script type="text/javascript">
        var userRoles = '@php echo json_encode(Auth::user()->roles->pluck('role_key')); @endphp';
        $(function () {

            $('#schedule_approve').prop('disabled', false);
            $('#schedule_reject').prop('disabled', true);

            $('input[type=radio][name=approve_yn]').change(function() {
                /*if (this.value == 'allot') {
                    alert("Allot Thai Gayo Bhai");
                }
                else if (this.value == 'transfer') {
                    alert("Transfer Thai Gayo");
                }*/
                console.log(this.value);
                if(this.value == 'Y'){
                    console.log('approved');
                    $('#schedule_approve').prop('disabled', false);
                    $('#schedule_reject').prop('disabled', true);
                }else{
                    console.log('rejected');

                    $('#schedule_approve').prop('disabled', true);
                    $('#schedule_reject').prop('disabled', false);
                }
            });

            $(document).on("click", ".scheduledetailremove", function () {

                var that = this;
                alertify.confirm('Remove Schedule', 'Are you sure?',
                    function () {
                        var schedule_assignment_id = $(that).closest('tr').attr('id');

                        console.log('schedule_assignment_id', schedule_assignment_id);
                        var url = '{{ route("schedule.schedule-assignment-delete") }}';
                        var detail = {};

                        detail.schedule_assignment_id = schedule_assignment_id;
                        detail.schedule_master_id = '{{ $schedule->schedule_master_id }}';
                        console.log(detail);

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: detail,
                            success: function (resp) {
                                console.log(resp);

                                if (resp.o_status_code == 1) {
                                    $(that).closest('tr').remove();
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
                );

            });

            $(document).ready(function () {
                $("#workflow_form").attr('action', '{{ route('schedule.approval-post') }}');
            });



            $("#schedule_approve").click(function(){
                var myModal = $('#status-show');
                let master_id = $('#get_val').val();
                $("#workflow_id").val(1);
                $("#object_id").val(master_id);
                $("#get_url").val(window.location.pathname.slice(1));

                $.ajax({
                    type: 'GET',
                    url: '/schedule/approval',
                    data: {workflowId: 1,objectid: master_id},
                    success: function (msg) {
                        //console.log(msg)
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
                            $(document).find('.no-permission').hide();
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
            });

            $('input[type=radio][name=final_approve_yn]').change(function() {
                if (this.value == 'Y') {
                    $("#save_btn").css("display","none");
                    $("#bonus_id_prm").val(27);
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


            $('#schedule-detail-save').click(function (e) {
                e.preventDefault();
                console.log('schedule-detail-save');
                if (confirm("Are you sure?")) {
                    schedule_detail_save();
                }
            });

            function schedule_detail_save() {
                var url = '{{ route("schedule.schedule-detail-post") }}';
                var detail = {};
                detail.schedule_master_id = '{{ $schedule->schedule_master_id }}';
                detail.emp_id = $('#emp_id').val();
                detail.active_yn = '{{\App\Enums\YesNoFlag::YES}}';

                console.log(detail);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: detail,
                    success: function (resp) {
                        console.log(resp);
                        if (resp.o_status_code == 1) {
                            alert(resp.o_status_message);
                            //$(that).closest('tr').remove();
                            $('#emptyRow').remove();
                            var tr = "<tr id='" + resp.schedule_detail.schedule_detail_id + "'>";
                            //alert(result.d[i].AreaName + "->" + result.d[i].ServicePointID);
                            tr = tr + '<td>' + resp.schedule_detail.schedule_detail_id + '</td>';
                            tr = tr + '<td>' + resp.schedule_detail.designation + '</td>';
                            tr = tr + '<td>' + resp.schedule_detail.emp_name + '</td>';
                            tr = tr + '<td><a class="text-primary scheduledetailremove" ><i class="bx bx-minus-circle cursor-pointer"></i></a></td>';

                            tr = tr + '</tr>';
                            $('#tbl_schedule_detail > tbody:last').append(tr);
                        } else {
                            alert(resp.o_status_message);
                        }
                    },
                    error: function (resp) {
                        alert('error');
                    }
                });

            }
        });

    </script>

@endsection
