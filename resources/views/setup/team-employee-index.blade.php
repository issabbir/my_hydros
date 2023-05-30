@extends('layouts.default')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection
@section('content')
    {{--@json($teams)--}}
    {{--<form @if(isset($team_employee->team_employee_id)) action="{{route('setup.team-employee-update',
                    [$team_employee->team_employee_id])}}"
          @else action="{{route('setup.team-employee-post')}}" @endif method="post">
        @csrf
        @if (isset($team_employee->team_employee_id))
            @method('PUT')
        @endif
     --}}
    {{--    <div class="row">--}}
    {{--        <div class="col-md-12">--}}
    {{--            <div class="card">--}}
    {{--                <div class="card-body">--}}
    {{--                    <h4 class="card-title">Team List</h4>--}}
    {{--                    <hr>--}}
    {{--                    <div class="col-sm-4">--}}
    {{--                        <div class="form-group">--}}
    {{--                            <label for="team_id" class="required">Team </label>--}}
    {{--                            <select class="custom-select select2 form-control" required id="team_id" name="team_id">--}}
    {{--                                <option value="">Select One</option>--}}
    {{--                                @if(isset($teams))--}}
    {{--                                    @foreach($teams as $t)--}}
    {{--                                        <option value="{{$t->team_id}}"--}}
    {{--                                                @if(isset($team->team_id) &&--}}
    {{--                                                ($team->team_id == $t->team_id))--}}
    {{--                                                selected--}}
    {{--                                            @endif--}}
    {{--                                        >{{$t->team_name}}</option>--}}
    {{--                                    @endforeach--}}
    {{--                                @endif--}}
    {{--                            </select>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}

    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    {{--    <div class="row">--}}
    {{--        <div class="col-12">--}}
    {{--            <div class="card">--}}
    {{--                <!-- Table Start -->--}}
    {{--                <form>--}}

    {{--                    <div class="card-body">--}}
    {{--                        <h4 class="card-title">Team Member Setup</h4>--}}
    {{--                        <hr>--}}
    {{--                        @if(Session::has('message'))--}}
    {{--                            <div--}}
    {{--                                class="alert {{Session::get('m-class') ? Session::get('m-class') : 'alert-danger'}} show"--}}
    {{--                                role="alert">--}}
    {{--                                {{ Session::get('message') }}--}}
    {{--                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
    {{--                                    <span aria-hidden="true">&times;</span>--}}
    {{--                                </button>--}}
    {{--                            </div>--}}
    {{--                        @endif--}}
    {{--                        <div class="row">--}}

    {{--                            <input type="hidden" id="hidden_team_employee_id" name="hidden_team_employee_id">--}}
    {{--                            <div class="col-sm-4">--}}
    {{--                                <div class="form-group">--}}
    {{--                                    <label for="designation_id" class="required">Designation</label>--}}
    {{--                                    <select class="custom-select select2 form-control" required id="designation_id"--}}
    {{--                                            name="designation_id">--}}
    {{--                                        <option value="">Select One</option>--}}
    {{--                                        @if(isset($designations))--}}
    {{--                                            @foreach($designations as $designation)--}}
    {{--                                                <option value="{{$designation->designation_id}}"--}}
    {{--                                                        @if(isset($team_employee->designation_id) &&--}}
    {{--                                                        ($team_employee->designation_id == $designation->designation_id))--}}
    {{--                                                        selected--}}
    {{--                                                    @endif--}}
    {{--                                                >{{$designation->designation}}</option>--}}
    {{--                                            @endforeach--}}
    {{--                                        @endif--}}
    {{--                                    </select>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}


    {{--                            <div class="col-sm-4">--}}
    {{--                                <div class="form-group">--}}
    {{--                                    <label for="emp_id" class="required">Employee</label>--}}
    {{--                                    <select required class="form-control" id="emp_id"--}}
    {{--                                            name="emp_id">--}}
    {{--                                        <option value="" selected="selected">Select One</option>--}}
    {{--                                        @if(isset($employees))--}}
    {{--                                            @foreach($employees as $employee)--}}
    {{--                                                <option value="{{$employee->emp_id}}"--}}
    {{--                                                        @if(isset($team_employee->emp_id) &&--}}
    {{--                                                        ($team_employee->emp_id == $employee->emp_id))--}}
    {{--                                                        selected--}}
    {{--                                                    @endif--}}
    {{--                                                >{{$employee->emp_name}}</option>--}}
    {{--                                            @endforeach--}}
    {{--                                        @endif--}}
    {{--                                    </select>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}

    {{--                            <div class="col-sm-4">--}}
    {{--                                <div class="form-group">--}}
    {{--                                    <label for="description">Mobile No</label>--}}
    {{--                                    <input type="text"--}}
    {{--                                           class="form-control"--}}
    {{--                                           id="mobile_no"--}}
    {{--                                           name="mobile_no"--}}
    {{--                                           placeholder="Enter mobile"--}}
    {{--                                           value="{{old('mobile_no',isset($team_employee->mobile_no) ? $team_employee->mobile_no : '')}}"--}}
    {{--                                    >--}}
    {{--                                    <small class="text-muted form-text"></small>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                            <div class="col-sm-4">--}}
    {{--                                <div class="form-group">--}}
    {{--                                    <label for="description">Email</label>--}}
    {{--                                    <input type="email"--}}
    {{--                                           class="form-control"--}}
    {{--                                           id="email"--}}
    {{--                                           name="email"--}}
    {{--                                           placeholder="Enter email"--}}
    {{--                                           value="{{old('email',isset($team_employee->email) ? $team_employee->email : '')}}"--}}
    {{--                                    >--}}
    {{--                                    <small class="text-muted form-text"></small>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}


    {{--                            <div class="col-sm-4">--}}
    {{--                                <div class="form-group">--}}
    {{--                                    <label for="team_leader_yn" class="required">Team Leader</label>--}}
    {{--                                    <ul class="list-unstyled mb-0">--}}
    {{--                                        <li class="d-inline-block mr-2 mb-1">--}}
    {{--                                            <fieldset>--}}
    {{--                                                <div class="custom-control custom-radio">--}}
    {{--                                                    <input class="custom-control-input" type="radio"--}}
    {{--                                                           name="team_leader_yn"--}}
    {{--                                                           id="team_leader_yes"--}}
    {{--                                                           value="{{\App\Enums\YesNoFlag::YES}}"--}}
    {{--                                                           @if($team_employee && ($team_employee->team_leader_yn == \App\Enums\YesNoFlag::YES))--}}
    {{--                                                           checked--}}
    {{--                                                        @endif--}}
    {{--                                                    />--}}
    {{--                                                    <label class="custom-control-label" for="team_leader_yes">--}}
    {{--                                                        Yes </label>--}}
    {{--                                                </div>--}}
    {{--                                            </fieldset>--}}
    {{--                                        </li>--}}
    {{--                                        <li class="d-inline-block mr-2 mb-1">--}}
    {{--                                            <fieldset>--}}
    {{--                                                <div class="custom-control custom-radio">--}}
    {{--                                                    <input class="custom-control-input" type="radio"--}}
    {{--                                                           name="team_leader_yn"--}}
    {{--                                                           id="team_leader_no"--}}
    {{--                                                           value="{{\App\Enums\YesNoFlag::NO}}"--}}
    {{--                                                           @if($team_employee && ($team_employee->team_leader_yn != \App\Enums\YesNoFlag::YES))--}}
    {{--                                                           checked--}}

    {{--                                                           @elseif(!$team_employee)--}}
    {{--                                                           checked--}}
    {{--                                                        @endif--}}
    {{--                                                    />--}}
    {{--                                                    <label class="custom-control-label" for="team_leader_no">--}}
    {{--                                                        No </label>--}}
    {{--                                                </div>--}}
    {{--                                            </fieldset>--}}
    {{--                                        </li>--}}
    {{--                                    </ul>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}


    {{--                        </div>--}}


    {{--                        <div class="row">--}}


    {{--                            <div class="col-sm-4">--}}
    {{--                                <div class="form-group">--}}
    {{--                                    <label for="active_yn" class="required">Active?</label>--}}
    {{--                                    <ul class="list-unstyled mb-0">--}}
    {{--                                        <li class="d-inline-block mr-2 mb-1">--}}
    {{--                                            <fieldset>--}}
    {{--                                                <div class="custom-control custom-radio">--}}
    {{--                                                    <input class="custom-control-input" type="radio" name="active_yn"--}}
    {{--                                                           id="active_yes"--}}
    {{--                                                           value="{{\App\Enums\YesNoFlag::YES}}"--}}
    {{--                                                           @if($team_employee && ($team_employee->active_yn == \App\Enums\YesNoFlag::YES))--}}
    {{--                                                           checked--}}
    {{--                                                           @elseif(!$team_employee)--}}
    {{--                                                           checked--}}
    {{--                                                        @endif--}}
    {{--                                                    />--}}
    {{--                                                    <label class="custom-control-label" for="active_yes"> Yes </label>--}}
    {{--                                                </div>--}}
    {{--                                            </fieldset>--}}
    {{--                                        </li>--}}
    {{--                                        <li class="d-inline-block mr-2 mb-1">--}}
    {{--                                            <fieldset>--}}
    {{--                                                <div class="custom-control custom-radio">--}}
    {{--                                                    <input class="custom-control-input" type="radio" name="active_yn"--}}
    {{--                                                           id="active_no"--}}
    {{--                                                           value="{{\App\Enums\YesNoFlag::NO}}"--}}
    {{--                                                           @if($team_employee && ($team_employee->active_yn != \App\Enums\YesNoFlag::YES))--}}
    {{--                                                           checked--}}
    {{--                                                        @endif--}}
    {{--                                                    />--}}
    {{--                                                    <label class="custom-control-label" for="active_no"> No </label>--}}
    {{--                                                </div>--}}
    {{--                                            </fieldset>--}}
    {{--                                        </li>--}}
    {{--                                    </ul>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                        <div class="col-md-12 pr-0 d-flex justify-content-end">--}}
    {{--                            <div class="form-group">--}}
    {{--                                <button id="team-employee-save" type="button" class="btn btn-primary mr-1 mb-1">Save--}}
    {{--                                </button>--}}
    {{--                                <input id="team-employee-reset" type="reset" class="btn btn-light-secondary mb-1" value="Reset"/>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}

    {{--                    </div>--}}

    {{--                </form>--}}
    {{--                <!-- Table End -->--}}
    {{--            </div>--}}


    {{--        </div>--}}

    {{--    </div>--}}

    {{--</form>--}}
    {{--@include('setup.team-employee-datatable-list')--}}
    @include('setup.partials.form')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h4 class="card-title">Team Employee List</h4>
                    <div class="card-content">
                        <div class="table-responsive">
                            <table id="tbl_employee_team" class="table table-sm datatable mdl-data-table dataTable">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Team Name</th>
                                    <th>Designation</th>
                                    <th>Emp Name</th>
                                    <th>Mobile no</th>
                                    <th>Team Leader</th>

                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($team_employees) && count($team_employees) > 0)
                                    @foreach($team_employees as $team_employee)

                                        <tr id="{{$team_employee->team_employee_id}}">
                                            <td> {{$team_employee->team_employee_id}} </td>
                                            <td> {{$team_employee->team_name}} </td>
                                            <td> {{$team_employee->designation}} </td>
                                            <td> {{$team_employee->emp_name}} </td>
                                            <td> {{$team_employee->mobile_no}} </td>
                                            <td> {{$team_employee->team_leader_yn == 'Y' ? 'Yes':'No'}} </td>


                                            <td> {{$team_employee->active_yn == 'Y' ? 'Yes':'No'}} </td>


                                            <td>
                                                <a ml="4" target="_self" href="#" class="text-primary teamEmployeeEdit"><i class="bx bx-edit cursor-pointer"></i></a>
                                                <a class="text-primary teamEmployeeRemove"><i
                                                        class="bx bx-minus-circle cursor-pointer"></i></a></td>


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



@endsection

@section('footer-script')
    <script type="text/javascript">

        function addOneRowToTable(resp) {


            $('#emptyRow').remove();

            var tr = "<tr id='" + resp.team_employee_id + "'>";
            //alert(result.d[i].AreaName + "->" + result.d[i].ServicePointID);
            tr = tr + '<td>' + resp.sl + '</td>';
            tr = tr + '<td>' + resp.team_name + '</td>';
            tr = tr + '<td>' + resp.designation + '</td>';

            tr = tr + '<td>' + resp.emp_name + '</td>';

            if(resp.mobile_no == null){
                tr = tr + '<td>' + '' + '</td>';
            }else{
                tr = tr + '<td>' + resp.mobile_no + '</td>';
            }

            tr = tr + '<td>' + resp.team_leader_yn + '</td>';

            tr = tr + '<td>' + resp.active_yn + '</td>';

            //<div class="text-primary teamEmployeeRemove" ><i class="bx bx-trash cursor-pointer"></i></div>
            tr = tr + '<td><a ml="4" target="_self" href="#" class="text-primary teamEmployeeEdit"><i class="bx bx-edit cursor-pointer"></i></a> <a target="_self" href="#" class="text-danger teamEmployeeRemove" role="button"><i class="bx bx-trash cursor-pointer"></i></a></td>';

            tr = tr + '</tr>';
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
                    for (var i = 0, l = resp.length; i < l; i++) {
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

            var team_id = '{{request()->get('teamId')}}';

            if (team_id) {
                $('#team_id').find('option[value={{request()->get('teamId')}}]').attr('selected','selected');
                //$('#team_id').val(team_id);
                $("#team_id").trigger('change');
            }

            $(document).on("click","input[type='reset']", function(){
                // console.log('test');
                $( ".designation_id" ).val(1).trigger('change.select2')({
                    placeholder: "Select One",
                });
                $(".emp_id").empty();
                $('.emp_id').append('<option value="">Select One</option>');

                global_emp_id = '';
                $('#hidden_team_employee_id').val('');
                $('.mobile_no').val('');
            });

            //teamEmployeeEdit
            var global_emp_id = '';

            $(document).on("click", ".teamEmployeeEdit", function (e) {

                e.preventDefault();
                var that = this;

                var team_employee_id = $(that).closest('tr').attr('id');

                console.log('team_employee_id', team_employee_id);

                var url = '{{route('setup.team-employee-get')}}';

                var data = {};
                data.team_employee_id = team_employee_id;

                $.ajax({
                    type: "GET",
                    url: url,
                    data: data,
                    success: function (resp) {
                        //console.log(resp);

                        if (resp.team_employee == null || resp.team_employee == undefined) {
                            alertify.error('team employee is empty');
                            return;
                        }
                        $('#hidden_team_employee_id').val(resp.team_employee.team_employee_id);
                        $('.mobile_no').val(resp.team_employee.mobile_no);
                        $('.email').val(resp.team_employee.email);
                        $('.designation_id').val(resp.team_employee.designation_id).change();
                        // $('#emp_id').val(resp.team_employee.emp_id).change();

                        // $('input:radio[name=team_leader_yn]').filter('[value=' + resp.team_employee.team_leader_yn +']').attr('checked', true);
                        // $('input:radio[name=active_yn]').filter('[value=' + resp.team_employee.active_yn +']').attr('checked', true);
                        $('.team_leader_yn').val( resp.team_employee.team_leader_yn);
                        $('.active_yn').val( resp.team_employee.active_yn);

                        global_emp_id = resp.team_employee.emp_id;
                    },
                    error: function (resp) {
                        alert('error');
                    }
                });


            });

            //teamEmployeeRemove
            $(document).on("click", ".teamEmployeeRemove", function (e) {

                e.preventDefault();
                var that = this;
                alertify.confirm('Remove Employee', 'Are you sure?',
                    function () {
                        var team_employee_id = $(that).closest('tr').attr('id');

                        console.log('team_employee_id', team_employee_id);
                        var url = '{{ route("setup.team-employee-update") }}';
                        var detail = {};
                        var team_id = $('#team_id').val();
                        detail.team_id = team_id;
                        detail.team_employee_id = team_employee_id;
                        //detail.emp_id = '00000';
                        /*detail.emp_id = '00000';
                        //detail.team_leader_yn = '{{\App\Enums\YesNoFlag::NO}}';
                       // detail.active_yn = '{{\App\Enums\YesNoFlag::NO}}';

                        console.log(detail);
*/
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
                // console.log(id);

                if (id == "" || id == undefined) {
                    alertify.alert('Designation', 'Must select a designation!');
                    return;
                }
                var url = '{{route('setup.employee-by-designation')}}';
                // console.log(url);
                var that=$(this);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {_token: '{{ csrf_token() }}', id: id},
                    dataType: 'JSON',
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

                        // console.log(global_emp_id);

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
                        that.parents('div.repeatingSection').find('.mobile_no').val(data.mobile);
                        // $('#mobile_no').val(data.mobile);
                        that.parents('div.repeatingSection').find('.email').val(data.email);
                        //$('#email').val(data.email);



                    }
                });
            });

            var team_id_loaded = $('#team_id').val();

            if (team_id_loaded == "" || team_id_loaded == undefined) {

            } else {
                loadTeamWiseEmployee();
            }


            $('#team_id').change(function () {
                loadTeamWiseEmployee();
            });

            function loadTeamWiseEmployee() {
                var team_id = $('#team_id').val();
                //console.log(team_id);
                if (team_id == "" || team_id == undefined) {

                    $(".emp_id").empty();
                    $(".emp_id").select2({
                        placeholder: "Select a employee",

                    });
                    alertify.alert('Team', 'Must select a team!');
                } else {
                    var url = '{{route('setup.team-employee-datatable-list')}}' + "?id=" + team_id;
                    //  console.log(url);
                    teamEmployeeList(url);
                }
            }

            $('#team-employee-save').click(function (e) {
                e.preventDefault();

                var mobile_no = $('.mobile_no').val();
                var team_leader_yn = $('.team_leader_yn').val();
                /*if (team_leader_yn == 'Y' && (mobile_no == "" || mobile_no == null || mobile_no == undefined)) {
                    alertify.error('Provide mobile number for team leader!');
                    return;
                }*/

                console.log('mobile_no',mobile_no);



                var team_employee_id = $('#hidden_team_employee_id').val();
                var data = $(this).closest('form').serialize();
                var msg = '';
                console.log('team_employee_id ==',team_employee_id);
                if(team_employee_id == '' || team_employee_id == null){
                    msg = 'Add';
                }else{
                    msg = 'Update';
                }

                var url = '{{ route("setup.team-employee-post") }}';

                alertify.confirm(msg, 'Are you sure?',
                    function () {
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: data,
                            success: function (resp) {
                                //console.log(resp);
                                //alert(resp)
                                if (resp.o_status_code == 1) {

                                    // $("#team-employee-reset").trigger("click");


                                    // $('#tbl_employee_team > tbody > tr').each(function () {
                                    //     var id = $(this).attr('id');
                                    //
                                    //     // console.log(id);
                                    //     if (id == resp.team_employee.team_employee_id) {
                                    //         //   console.log('audit_detail_id',audit_detail_id);
                                    //         $(this).remove();
                                    //     }
                                    //
                                    // });


                                    // addOneRowToTable(resp.team_employee);
                                    alertify.success(resp.o_status_message);
                                    location.reload();
                                    global_emp_id = '';
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
    </script>

@endsection

