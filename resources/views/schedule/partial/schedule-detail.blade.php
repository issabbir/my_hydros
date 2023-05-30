<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <h4 class="card-title">Schedule for different team </h4>
                <div class="card-content">

                    <div class="row">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="schedule_date" class="required">Schedule Date </label>
                                <input required type="text"
                                       autocomplete="off"
                                       class="form-control"
                                       id="schedule_date"
                                       data-target="#schedule_date"
                                       name="schedule_date"
                                       placeholder="YYYY-MM-DD"
                                       data-date-format="yyyy-mm-dd"
                                       value="{{old('schedule_date',isset
                                           ($team_employee->schedule_date) ?
                                           date('Y-m-d',strtotime($team_employee->schedule_date)) : '')}}"/>
                                <input id="schedule_master_id_chk" type="hidden"value="{{isset($schedule->schedule_master_id) ?
                                           $schedule->schedule_master_id : ''}}">
                            </div>
                        </div>

                        {{--<div class="col-sm-4">
                            <label class="required">Schedule Date </label>
                            <div class="input-group date" id="schedule_date"
                                 data-target-input="nearest">
                                <input type="text" required
                                       value="{{old('schedule_date',isset
                                           ($team_employee->schedule_date) ?
                                           date('Y-m-d',strtotime($team_employee->schedule_date)) : '')}}"
                                       class="form-control datetimepicker-input"
                                       data-toggle="datetimepicker" data-target="#schedule_date"
                                       id="schedule_date"
                                       name="schedule_date"
                                       autocomplete="off"
                                />
                            </div>
                        </div>--}}


                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="team_id" class="required">Team </label>
                                <select class="custom-select select2 form-control" required id="team_id"
                                        name="team_id">
                                    <option value="">Select One</option>
                                    @if(isset($teams))
                                        @foreach($teams as $t)
                                            <option value="{{$t->team_id}}"
                                                    @if(isset($schedule->team_id) &&
                                                    ($schedule->team_id == $t->team_id))
                                                    selected
                                                @endif
                                            >{{$t->team_name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>


                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="vehicle_id">Boat Name</label>
                                <select class="custom-select select2 form-control" id="vehicle_id"
                                        name="vehicle_id">
                                    <option value="">Select One</option>
                                    @if(isset($vehicles))
                                        @foreach($vehicles as $vehicle)
                                            <option value="{{$vehicle->vehicle_id}}"
                                                    @if(isset($schedule->vehicle_id) &&
                                                    ($schedule->vehicle_id == $vehicle->vehicle_id))
                                                    selected
                                                @endif
                                            >{{$vehicle->vehicle_name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

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
                                <label for="schedule_from_time">Schedule From Time</label>
                                <input type="text"
                                       autocomplete="off"
                                       class="form-control from-timepicker"
                                       id="schedule_from_time"
                                       name="schedule_from_time"
                                       placeholder="HH:mm"
                                       value="{{old('schedule_from_time',isset
                                           ($team_employee->schedule_from_time) ?
                                           date('H:i',strtotime($team_employee->schedule_from_time)) : '')}}"/>
                                <small class="text-muted form-text"> </small>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="schedule_to_time">Schedule To Time</label>
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

                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="work_description">Description</label>
                                <input type="text"
                                       class="form-control"
                                       id="get_description"
                                       autocomplete="off"
                                       name="description"
                                       placeholder="Enter Description"
                                       value="{{old('description')}}"
                                >
                                <small class="text-muted form-text"></small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="work_description">Remarks</label>
                                <input type="text"
                                       class="form-control"
                                       id="remarks"
                                       autocomplete="off"
                                       name="remarks"
                                       placeholder="Enter Remarks"
                                       value="{{old('remarks',isset($team_employee->remarks) ? $team_employee->remarks : '')}}"
                                >
                                <small class="text-muted form-text"></small>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 pr-0 d-flex justify-content-end">
                        <div class="form-group">
                            <button id="schedule-detail-save" type="button" class="btn btn-primary mr-1 mb-1">Save
                            </button>

                            {{--<input id="schedule-detail-reset" type="reset" class="btn btn-light-secondary mb-1" value="Reset"/>--}}
                            <a type="reset" href="{{route("schedule.schedule-index")}}"
                               class="btn btn-light-secondary mb-1"> Back</a>

                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="tbl_schedule_detail" class="table table-sm datatable mdl-data-table dataTable">
                            <thead>
                            <tr>
                                {{--<th>SL</th>--}}

                                <th>Schedule Date</th>

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
                                        {{--<td> {{$schedule_assignment->schedule_assignment_id}} </td>--}}
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
                                            @else
                                                --
                                            @endif

                                        </td>


                                        <td>
                                            @if(isset($schedule_assignment->vehicle))
                                                {{$schedule_assignment->vehicle->vehicle_name}}
                                            @else
                                                --
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
@section('footer-script')
    <script type="text/javascript">
        /*$('.from-timepicker').val('');
        $('#schedule_to_time').val('');*/

        $(function () {

            $(document).on("click","input[type='reset']", function(){

                $( "#team_id" ).val(0).trigger('change.select2').select2({
                    placeholder: "Select One",
                });

                $( "#vehicle_id" ).val(0).trigger('change.select2').select2({
                    placeholder: "Select One",
                });

                $( "#zonearea_id" ).val(0).trigger('change.select2').select2({
                    placeholder: "Select One",
                });


                $('#schedule_date').val('');
                $('#remarks').val('');
            });


            $('#schedule_from_date,#schedule_to_date').datepicker({
                autoclose: true,
                todayHighlight: true,
                //minDate:new Date()
                startDate: "now()",
                orientation: "bottom auto",
            });

            var schedule_from_date = $('#schedule_from_date').val();
            var schedule_to_date = $('#schedule_to_date').val();

            var parts = schedule_from_date.split('-');
// Please pay attention to the month (parts[1]); JavaScript counts months from 0:
// January - 0, February - 1, etc.
            var fdt = new Date(parts[0], parts[1] - 1, parts[2]);

            var tparts = schedule_to_date.split('-');
// Please pay attention to the month (parts[1]); JavaScript counts months from 0:
// January - 0, February - 1, etc.
            var tdt = new Date(tparts[0], tparts[1] - 1, tparts[2]);
            $('#schedule_date').datepicker({
                autoclose: true,
                //startDate: fdt,
                //endDate: tdt,
                orientation: "bottom auto",
            });

            //datePicker('#schedule_date');
            $('.from-timepicker').wickedpicker({
                title: 'From',
                clearable: true,
                time: 1,
               // now: "9:00", //hh:mm 24 hour format only, defaults to current time
                twentyFour: true, //Display 24 hour format, defaults to false
            });

            $('#schedule_to_time').wickedpicker({
                title: 'To',
                clearable: true,
              //  now: '00:00',
                //now: "17:00", //hh:mm 24 hour format only, defaults to current time
                twentyFour: true, //Display 24 hour format, defaults to false
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
                        detail.schedule_master_id = '{{ $schedule_master_id }}';
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

            $('#schedule-detail-save').click(function (e) {
                e.preventDefault();
                console.log('schedule-detail-save');

                alertify.confirm('Add Schedule', 'Are you sure?',
                    function () {
                        var url = '{{ route("schedule.schedule-detail-post") }}';
                        var detail = {};
                        detail.schedule_master_id = '{{ $schedule_master_id }}';
                        detail.active_yn = '{{\App\Enums\YesNoFlag::YES}}';

                        detail.schedule_date = $('#schedule_date').val();
                        detail.zonearea_id = $('#zonearea_id').val();
                        detail.team_id = $('#team_id').val();
                        detail.vehicle_id = $('#vehicle_id').val();
                        detail.description = $('#get_description').val();

                        detail.schedule_from_time = $('#schedule_from_time').val();
                        detail.schedule_to_time = $('#schedule_to_time').val();
                        detail.remarks = $('#remarks').val();

                        //console.log(detail);
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: detail,
                            success: function (resp) {
                                console.log(resp.schedule_assignment);
                                /**/
                                 if (resp.o_status_code == 1) {
                                     $("#schedule-detail-reset").trigger("click");

                                     $('#emptyRow').remove();
                                     let vehicle = resp.schedule_assignment.vehicle_id;
                                     let zonearea = resp.schedule_assignment.zonearea;
                                     if(vehicle==null){
                                         vehicle = '--';
                                     }else{
                                         vehicle = resp.schedule_assignment.vehicle.vehicle_name;
                                     }

                                     if(zonearea==null){
                                         zonearea = '--';
                                     }else{
                                         zonearea = resp.schedule_assignment.zonearea.proposed_name;
                                     }
                                     var tr = "<tr id='" + resp.schedule_assignment.schedule_assignment_id + "'>";
                                     //alert(result.d[i].AreaName + "->" + result.d[i].ServicePointID);
                                     /*tr = tr + '<td>' + resp.schedule_assignment.schedule_assignment_id + '</td>';*/
                                     tr = tr + '<td>' + resp.schedule_assignment.schedule_date + '</td>';
                                     tr = tr + '<td>' + resp.schedule_assignment.team.team_name + '</td>';
                                     tr = tr + '<td>' + zonearea + '</td>';
                                     tr = tr + '<td>' + vehicle + '</td>';
                                     tr = tr + '<td>' + resp.schedule_assignment.schedule_from_time + '</td>';
                                     tr = tr + '<td>' + resp.schedule_assignment.schedule_to_time + '</td>';
                                     tr = tr + '<td><a class="text-primary scheduledetailremove" ><i class="bx bx-trash cursor-pointer"></i></a></td>';

                                     tr = tr + '</tr>';
                                     $('#tbl_schedule_detail > tbody:last').append(tr);
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
        });

    </script>

@endsection
