@extends('layouts.default')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
    <style>
        .empId span {
            width: 100%!important;
        }
        .empId span b {
            margin-left: 160px!important;
        }
    </style>
@endsection
@section('content')

    @include('schedule.partial.form')
    @include('schedule.boat-employee-edit')


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Boat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">Boat Type: </label>
                                            <select class="custom-select form-control"
                                                    id="outsider_status" name="outsider_status"
                                                    required>
                                                <option value="">Select One</option>
                                                <option value="{{ \App\Enums\YesNoFlag::YES }}">
                                                    Outsider
                                                </option>
                                                <option value="{{ \App\Enums\YesNoFlag::NO }}">
                                                    CPA
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">Boat Category: </label>
                                            <select class="custom-select form-control"
                                                    id="outsider_status" name="outsider_status"
                                                    required>
                                                <option value="">Select One</option>
                                                <option value="{{ \App\Enums\YesNoFlag::YES }}">
                                                    Outsider
                                                </option>
                                                <option value="{{ \App\Enums\YesNoFlag::NO }}">
                                                    CPA
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">Boat Name: </label>
                                            <input required type="text" id="modal_org_name" name="modal_org_name"
                                                   class="form-control"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Boat Name (Bangla): </label>
                                            <input type="text" id="modal_org_name_ban" name="modal_org_name_ban"
                                                   class="form-control"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description: </label>
                                            <input required type="text" id="modal_emp_name" name="modal_emp_name"
                                                   class="form-control"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Engine Capacity: </label>
                                            <input type="text" id="modal_emp_name_ban" name="modal_emp_name_ban"
                                                   class="form-control"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">Model Year: </label>
                                            <input required type="text" id="modal_desig" name="modal_desig"
                                                   class="form-control"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">Origin: </label>
                                            <input required type="text" id="modal_adress" name="modal_adress"
                                                   class="form-control"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">Fuel Type: </label>
                                            <input required type="text" id="modal_contact" name="modal_contact"
                                                   class="form-control"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="modal_submit">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer-script')

    <script type="text/javascript">
        var url = '{{ route("schedule.get-employee") }}';
        $('.emp_id_modal').select2({
            //placeholder: "Select one",
            ajax: {
                url: url,
                data: function (params) {
                    if (params.term) {
                        if (params.term.trim().length < 1) {
                            return false;
                        }
                    } else {
                        return false;
                    }

                    return params;
                },
                dataType: 'json',
                processResults: function (data) {
                    var formattedResults = $.map(data, function (obj, idx) {
                        obj.id = obj.emp_id;
                        obj.text = obj.emp_code + '-' + obj.emp_name;
                        return obj;
                    });
                    return {
                        results: formattedResults,
                    };
                }
            }
        });

        function addOneRowToTable(resp) {


            $('#emptyRow').remove();

            var tr = "<tr id='" + resp.boat_employee_id + "'>";
            //alert(result.d[i].AreaName + "->" + result.d[i].ServicePointID);
            //tr = tr + '<td>' + resp.boat_employee_id + '</td>';
            tr = tr + '<td>' + resp.sl + '</td>';
            tr = tr + '<td>' + resp.vehicle_name + '</td>';
            tr = tr + '<td>' + resp.emp_name + '</td>';
            tr = tr + '<td>' + resp.designation + '</td>';

            tr = tr + '<td>' + resp.mobile_number + '</td>';
            tr = tr + '<td>' + resp.start_date + '</td>';
            tr = tr + '<td>' + resp.end_date + '</td>';
            tr = tr + '<td>' + resp.team_leader_yn + '</td>';
            tr = tr + '<td>' + resp.active_yn + '</td>';

            //<div class="text-primary teamEmployeeRemove" ><i class="bx bx-trash cursor-pointer"></i></div>
            tr = tr + '<td><a ml="4" target="_self" href="#" class="text-primary boatEmployeeEdit"><i class="bx bx-edit cursor-pointer"></i></a> ' +
                 '<a target="_self" href="#" class="text-danger boatEmployeeRemove" role="button"><i class="bx bx-trash cursor-pointer"></i></a>' +
                '</td>';

            tr = tr + '</tr>';

            /*if(resp.team_leader_yn == 'Yes' || resp.team_leader_yn == 'Y'){
                $('#tbl_employee_team > tbody:first').append(tr);
                return;
            }*/

            $('#tbl_employee_team > tbody:first').append(tr);

        }

        function teamEmployeeList(url) {
            if ($.fn.DataTable.isDataTable('#tbl_employee_team')) {
                $('#tbl_employee_team').DataTable().destroy();
            }
            $('#tbl_employee_team tbody').empty();

            $.ajax({
                type: "POST",
                url: url,
                //data: detail,
                success: function (resp) {
                    //console.log(resp);
                    for ( var i = 0, l = resp.length; i < l; i++ ) {
                        //console.log(resp[i]);
                        addOneRowToTable(resp[i]);
                    }

                },
                error: function (resp) {
                    alert('error');
                }
            });
        }

        $(document).ready(function () {

            $(document).on("click","input[type='reset']", function(){
                // console.log('test');
                $( ".designation_id" ).val(1).trigger('change.select2');

                $(".emp_id").empty();
                $('.emp_id').append('<option value="">Select One</option>');

                global_emp_id = '';
                $('#hidden_team_employee_id').val('');
                $('.mobile_number').val('');

            });

            var global_emp_id = '';
            $(document).on("click", ".boatEmployeeEdit", function (e) {
                var myModal = $('#status-show');
                e.preventDefault();
                var that = this;

                var boat_employee_id = $(that).closest('tr').attr('id');

                console.log('boat_employee_id', boat_employee_id);

                var url = '{{route('schedule.boat-employee-get')}}';

                var data = {};
                data.boat_employee_id = boat_employee_id;

                $.ajax({
                    type: "GET",
                    url: url,
                    data: data,
                    success: function (resp) {
                        // console.log(resp);

                        if (resp.boat_employee == null || resp.boat_employee == undefined) {
                            alertify.error('team employee is empty');
                            return;
                        }
                        $('#hidden_boat_employee_id_modal').val(resp.boat_employee.boat_employee_id);
                        $('#vehicle_id_modal').val(resp.boat_employee.vehicle_id);
                        $('.mobile_number_modal').val(resp.boat_employee.mobile_number);
                        $('.designation_id_modal').val(resp.boat_employee.designation_id).change();



                        // Append it to the select
                        $('.emp_id_modal').html('<option value="'+resp.boat_employee.emp_id+'" selected>'+resp.boat_employee.employee.emp_name+'</option>').trigger('change');


                        // $('input:radio[name=team_leader_yn]').filter('[value=' + resp.boat_employee.team_leader_yn +']').attr('checked', true);
                        // $('input:radio[name=active_yn]').filter('[value=' + resp.boat_employee.active_yn +']').attr('checked', true);

                        $('.start_date_modal').val(convertDate(resp.boat_employee.start_date));
                        $('.end_date_modal').val( convertDate(resp.boat_employee.end_date));
                        $('.team_leader_yn_modal').val( resp.boat_employee.team_leader_yn);
                        $('.active_yn_modal').val( resp.boat_employee.active_yn);

                        global_emp_id = resp.boat_employee.emp_id;
                    },
                    error: function (resp) {
                        alert('error');
                    }
                });

                myModal.modal({show: true});
                return false;
            });

            function convertDate(inputFormat) {
                function pad(s) {
                    return (s < 10) ? '0' + s : s;
                }

                var d = new Date(inputFormat)
                return [pad(d.getDate()), pad(d.getMonth() + 1), d.getFullYear()].join('-')
            }

            //teamEmployeeRemove
            $(document).on("click", ".boatEmployeeRemove", function (e) {

                e.preventDefault();
                var that = this;
                alertify.confirm('Remove Employee', 'Are you sure?',
                    function () {
                        var boat_employee_id = $(that).closest('tr').attr('id');

                        console.log('boat_employee_id', boat_employee_id);
                        var url = '{{ route("schedule.boat-employee-update") }}';
                        var detail = {};
                        var vehicle_id = $('#vehicle_id').val();
                        detail.vehicle_id = vehicle_id;
                        detail.boat_employee_id = boat_employee_id;

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: detail,
                            success: function (resp) {
                                // console.log(resp);

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

            $(document).on('change','.designation_id', function () {
                var id = $(this).val();
                //console.log(id);

                if (id == "" || id == undefined) {
                    alertify.alert('Designation', 'Must select a designation!');
                    return;
                }


                var url = '{{route('setup.employee-by-designation')}}';
                console.log(url);
                var that=$(this);

                $.ajax({
                    /* the route pointing to the post function */
                    url: url,
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: '{{ csrf_token() }}', id: id},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        //console.log(data);

                        var emp_id =that.parents('div.repeatingSection').find('.emp_id');
                        emp_id.empty();
                        emp_id.append('<option value="">Select One</option>');
                        if(data!=null || data != ''){
                            var option = '';
                            for (var i=0;i<data.length;i++){
                                option += '<option value="'+ data[i].id + '">' + data[i].text + '</option>';
                            }
                            emp_id.append(option);
                        }

                        if(global_emp_id != ''){
                            emp_id.val(global_emp_id).change();
                            global_emp_id = '';
                        }

                    }
                });
            });

            $(document).on('change','.emp_id', function () {
                var id = $(this).val();
                //console.log(id);
                var that=$(this);

                if (id == "" || id == undefined) {
                    alertify.alert('Employee', 'Must select a employee!');
                    return;
                }

                var url = '{{route('setup.employee-detail-from-pims')}}';
                // console.log(url);

                var detail = {};
                detail.emp_id = id;
                $.ajax({
                    /* the route pointing to the post function */
                    url: url,
                    type: 'POST',
                    data: detail,

                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        //console.log(data);
                        that.parents('div.repeatingSection').find('.mobile_number').val(data.mobile);
                        // $('#email').val(data.email);



                    }
                });
            });

            var team_id_loaded = $('#vehicle_id').val();

            if (team_id_loaded == "" || team_id_loaded == undefined) {

            } else {
                loadTeamWiseEmployee();
            }


            $('#vehicle_id').change(function () {
                loadTeamWiseEmployee();
            });

            function loadTeamWiseEmployee() {
                var vehicle_id = $('#vehicle_id').val();
                //console.log(team_id);
                if (vehicle_id == "" || vehicle_id == undefined) {

                    $(".emp_id").empty();
                    $(".emp_id").select2({
                        placeholder: "Select a employee",

                    });
                    alertify.alert('Boat', 'Must select a boat!');
                } else {
                    var url = '{{route('schedule.boat-employee-datatable-list')}}' + "?id=" + vehicle_id;
                    //$("#boat-employee-reset").trigger("click");
                    teamEmployeeList(url);
                }
            }

            $('#boat-employee-save').click(function (e) {
                e.preventDefault();


                var boat_employee_id = $('#hidden_boat_employee_id').val();
                var data = $(this).closest('form').serialize();
                var msg = '';
                console.log('boat_employee_id ==',boat_employee_id);
                if(boat_employee_id == '' || boat_employee_id == null){
                    msg = 'Add';

                }else{
                    msg = 'Update';

                }
                var url = '{{ route("schedule.boat-employee-post") }}';
                alertify.confirm(msg, 'Are you sure?',
                    function () {
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: data,
                            success: function (resp) {
                                // console.log(resp);
                                if (resp.o_status_code == 1) {

                                    $("#boat-employee-reset").trigger("click");

                                    $('#tbl_employee_team > tbody > tr').each(function () {
                                        var id = $(this).attr('id');

                                        // console.log(id);
                                        if (id == resp.boat_employee.boat_employee_id) {
                                            //   console.log('audit_detail_id',audit_detail_id);
                                            $(this).remove();
                                        }
                                    });

                                    //addOneRowToTable(resp.boat_employee);
                                    alertify.success(resp.o_status_message);
                                    window.location.reload();
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
        });
        datePicker('#start_date_modal');
        datePicker('#end_date_modal');
        //datePicker('.start_date');
        datePicker('.datetimepicker-input');

        /*$("#add-boat").click(function () {
            var myModal = $('#exampleModal');
            myModal.modal({show: true});
            return false;
        });*/
    </script>

@endsection

