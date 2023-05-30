@extends('layouts.default')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->

@endsection
@section('content')

    <div class="card">
        <div class="card-body">
            <section id="horizontal-vertical">
                <div class="row">
                    <div class="col-12">
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
        $('#gadge-schedule-list tbody').on('click', '.removeData', function () {
            let row_id = $(this).data("pilotageid");
            dltData(row_id);
        });

        function dltData(row_id) {
            let url = '{{route('schedule.reader-roaster-remove')}}';
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
                        url: url,
                        data: {row_id: row_id},
                        success: function (msg) {
                            if (msg == 0) {
                                Swal.fire({
                                    title: 'Can not remove data. Something went wrong.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                Swal.fire({
                                    title: 'Entry Successfully Deleted!',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(function () {
                                    $('#gadge-schedule-list').DataTable().ajax.reload();
                                    //gadgeStationScheduleList()
                                });
                            }
                        }
                    });
                }
            });
        }

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
                                $("#save_btn").css("display","none");
                                $("#bonus_id_prm").val(39);
                                $(document).find('#hide_div').hide();
                                $("#close_btn").css("display","none");
                                $("#approve_btn").css("display","block");
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

        function gadgeStationScheduleList() {
            var url = '{{route('schedule.reader-approval-datatable-list')}}';
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
                    {data: 'station_name', name: 'station_name', searchable: true, orderable: false},
                    {data: 'insert_date', name: 'insert_date', searchable: true, orderable: false},
                    {data: 'approve_date', name: 'approve_date', searchable: true, orderable: false},
                    {data: 'schedule_mst_id', name: 'schedule_mst_id'},
                    {data: 'action', name: 'action', searchable: false},
                ]
            });
            oTable.columns( [4] ).visible( false );
        };

        $(document).ready(function () {
            $("#show_dtl_btn").show();
            var schedule_mst_id = '{{request()->get('id')}}';

            if (schedule_mst_id) {
                approval(schedule_mst_id);
            }

            $("#workflow_form").attr('action', '{{ route('schedule.approval-post') }}');
            gadgeStationScheduleList();
        });

    </script>

@endsection

