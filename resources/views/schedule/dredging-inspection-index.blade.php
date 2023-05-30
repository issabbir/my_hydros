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
                                      @else action="{{route('schedule.dredging-inspection-post')}}" @endif method="post">
                                    @csrf
                                    @if (isset($scheduleMaster->schedule_mst_id))
                                        @method('PUT')
                                    @endif

                                    <h4 class="card-title">Dredging Inspection Setup (Outer)</h4>
                                    <hr>

                                    <fieldset class="border p-1 mt-1 mb-1 col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="required">Inspection Date</label>
                                                    <input type="text"
                                                           autocomplete="off"
                                                           class="form-control datetimepicker-input"
                                                           data-toggle="datetimepicker"
                                                           id="tab_dredging_from"
                                                           data-target="#tab_dredging_from"
                                                           name="tab_dredging_from"
                                                           value=""
                                                           placeholder="YYYY-MM-DD">
                                                </div>

                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="emp_id" class="required">Employee</label>
                                                    <select class="select2 form-control ipl-0 pr-0 emp_id" id="emp_id">
                                                        <option value="">Select One</option>
                                                        @if(isset($employee))
                                                            @foreach($employee as $data)
                                                                <option value="{{$data->emp_id}}">
                                                                    {{$data->emp_code.'-'.$data->emp_name}}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="name">Mobile Number</label>
                                                    <input type="number"
                                                           class="form-control mobile_number"
                                                           id="tab_mobile_number" >
                                                    <small class="text-muted form-text"></small>
                                                </div>
                                            </div>
{{--                                            <div class="col-sm-2">--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <label class="required">To</label>--}}
{{--                                                    <input type="text"--}}
{{--                                                           autocomplete="off"--}}
{{--                                                           class="form-control datetimepicker-input"--}}
{{--                                                           data-toggle="datetimepicker"--}}
{{--                                                           id="tab_dredging_to"--}}
{{--                                                           data-target="#tab_dredging_to"--}}
{{--                                                           name="tab_dredging_to"--}}
{{--                                                           value=""--}}
{{--                                                           placeholder="YYYY-MM-DD"--}}
{{--                                                    >--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="ship_booking_time" class="required">Ship Booking Time</label>
                                                    <input type="text"
                                                           autocomplete="off"
                                                           class="form-control datetimepicker-input"
                                                           data-toggle="datetimepicker"
                                                           id="ship_booking_time"
                                                           name="ship_booking_time"
                                                           data-target="#ship_booking_time"
                                                           placeholder="HH:mm"
                                                           value=""
                                                           onchange="getValue(this)"
                                                    />
                                                    <small class="text-muted form-text"> </small>
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="shift_from_time" class="required">Dredging Start Time</label>
                                                    <input type="text"
                                                           autocomplete="off"
                                                           class="form-control datetimepicker-input"
                                                           data-toggle="datetimepicker"
                                                           id="shift_from_time"
                                                           name="shift_from_time"
                                                           data-target="#shift_from_time"
                                                           placeholder="HH:mm"
                                                           value=""/>
                                                    <small class="text-muted form-text"> </small>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 ">
                                                <div class="form-group">
                                                    <label for="shift_to_time" class="required">Dredging End Time</label>
                                                    <input type="text"
                                                           class="form-control datetimepicker-input"
                                                           data-toggle="datetimepicker"
                                                           id="shift_to_time"
                                                           name="shift_to_time"
                                                           data-target="#shift_to_time"
                                                           placeholder="HH:mm"

                                                           value=""/>
                                                    <small class="text-muted form-text"> </small>
                                                </div>
                                            </div>
{{--                                            <div class="col-sm-2">--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <label class="">Off Day</label>--}}
{{--                                                    <select class="select2 form-control pl-0 pr-0 " id="tab_offday_id">--}}
{{--                                                      <option value="">---Choose--- </option>--}}
{{--                                                        @if(isset($offdayList))--}}
{{--                                                            @foreach($offdayList as $value)--}}
{{--                                                                <option value="{{$value->offday_id}}">--}}
{{--                                                                    {{$value->offday_name}}--}}
{{--                                                                </option>--}}
{{--                                                            @endforeach--}}
{{--                                                        @endif--}}
{{--                                                    </select>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}



                                            <div class="col-sm-5">
                                                <div id="start-no-field" class="form-group">
                                                    <label>Remarks</label>
                                                    <input type="text" id="tab_remrks" name="tab_remrks"
                                                           class="form-control" value="">
                                                </div>
                                            </div>

                                            <div class="col-sm-1" >
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
                                                            aria-colindex="2" class="" width="15%">Inspection Date
                                                        </th>
{{--                                                        <th role="columnheader" scope="col"--}}
{{--                                                            aria-colindex="4" class="" width="10%">To--}}
{{--                                                        </th>--}}
                                                        <th role="columnheader" scope="col"
                                                            aria-colindex="5" class="" width="10%">SHIP BOOKING
                                                        </th>
                                                        <th role="columnheader" scope="col"
                                                            aria-colindex="5" class="" width="10%">DUTY TIME FROM
                                                        </th>
                                                        <th role="columnheader" scope="col"
                                                            aria-colindex="5" class="" width="10%">DUTY TIME To
                                                        </th>
                                                        {{--<th role="columnheader" scope="col"
                                                            aria-colindex="6" class="" width="13%">Designation
                                                        </th>--}}
                                                        <th role="columnheader" scope="col"
                                                            aria-colindex="6" class="" width="15%">Employee
                                                        </th>
                                                        <th role="columnheader" scope="col"
                                                            aria-colindex="6" class="" width="10%">Mobile
                                                        </th>
{{--                                                        <th role="columnheader" scope="col"--}}
{{--                                                            aria-colindex="7" class="" width="10%">Off Day--}}
{{--                                                        </th>--}}
                                                        <th role="columnheader" scope="col"
                                                            aria-colindex="7" class="" width="15%">Remarks
                                                        </th>
                                                    </tr>
                                                    </thead>

                                                    <tbody role="rowgroup" id="comp_body">

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
                                    <div class="row">
                                        <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="required">Note</label>
                                        <textarea
                                               class="form-control"
                                               name="dreadging_note" id="dreadging_note"
                                               placeholder="Note"></textarea>
                                    </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 pr-0 d-flex justify-content-end">
                                            <div class="form-group">

                                                    <button id="boat-employee-save" type="submit"
                                                            class="btn btn-primary mr-1 mb-1">Save
                                                    </button>

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
                                <h4 class="card-title">Dredging Inspection Setup List</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table id="dradging-inspection-list" class="table table-sm datatable mdl-data-table dataTable">
                                            <thead>

                                            <tr>
                                                <th>#</th>
                                                <th>Inspection Date</th>
                                                <th>Ship Booking Time</th>
                                                <th>Dredging Time</th>
                                                <th>Employee</th>
                                                <th>Mobile No.</th>
                                                <th>Action</th>
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


@endsection

@section('footer-script')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        var dataArray = new Array();

        var userRoles = '@php echo json_encode(Auth::user()->roles->pluck('role_key')); @endphp';
         //alert(userRoles);
        // $('.from-timepicker').wickedpicker({
        //     title: 'From',
        //     twentyFour: true,
        //     now: "9:00"
        // });
        //
        //
        // $('#shift_to_time').wickedpicker({
        //     title: 'To',
        //     twentyFour: true,
        //     now: "17:00",
        // });


        $(".add-row").click(function () {
            let tab_dredging_from = $("#tab_dredging_from").val();
            let tab_dredging_to = $("#tab_dredging_to").val();
            let ship_booking_time = $("#ship_booking_time").val();
            let shift_from_time = $("#shift_from_time").val();
            let shift_to_time = $("#shift_to_time").val();
            let tab_emp_id = $("#emp_id option:selected").val();
            let tab_emp_name = $("#emp_id option:selected").text();
            let tab_mobile_number = $("#tab_mobile_number").val();
            let tab_offday_id = $("#tab_offday_id option:selected").val();
            let tab_offday = $("#tab_offday_id option:selected").text();
            let tab_remrks = $("#tab_remrks").val();


            // if(tab_dredging_from){
            //     if(!dateCheck(tab_dredging_from,tab_dredging_to,tab_dredging_from)){
            //         Swal.fire('Please select date between From and To Date.');
            //         return false;
            //     }
            // }
            if(tab_emp_id == ''){
                Swal.fire('Please Select Employee');
                return false;
            }
            if (tab_offday_id == '') {
                tab_offday = '';
            }


            if (tab_dredging_from != '' && tab_dredging_to != '' && ship_booking_time != '' && shift_from_time!='' && shift_to_time !='' && tab_emp_id != '') {
                /*if ($.inArray(tab_emp_id, dataArray) > -1) {
                    Swal.fire('Duplicate value not allowed.');
                } else {*/
                let markup = "<tr role='row'>" +
                    "<td aria-colindex='1' role='cell' class='text-center'>" +
                    "<input type='checkbox' name='record' value='" + tab_emp_id  + "+" + "" + "'>" +
                    "<input type='hidden' name='tab_dredging_from[]' value='" + tab_dredging_from + "'>" +
                    // "<input type='hidden' name='tab_dredging_to[]' value='" + tab_dredging_to + "'>" +
                    "<input type='hidden' name='ship_booking_time[]' value='" + ship_booking_time + "'>" +
                    "<input type='hidden' name='shift_from_time[]' value='" + shift_from_time + "'>" +
                    "<input type='hidden' name='shift_to_time[]' value='" + shift_to_time + "'>" +
                    "<input type='hidden' name='tab_emp_id[]' value='" + tab_emp_id + "'>" +
                    "<input type='hidden' name='tab_mobile_number[]' value='" + tab_mobile_number + "'>" +
                    // "<input type='hidden' name='tab_offday_id[]' value='" + tab_offday_id + "'>" +
                    "<input type='hidden' name='tab_remrks[]' value='" + tab_remrks + "'>" +
                    "</td><td aria-colindex='2' role='cell'>" + tab_dredging_from + "</td>" +
                    // "<td aria-colindex='4' role='cell'>" + tab_dredging_to + "</td>" +
                    "<td aria-colindex='5' role='cell'>" + ship_booking_time + "</td>" +
                    "<td aria-colindex='5' role='cell'>" + shift_from_time + "</td>" +
                    "<td aria-colindex='5' role='cell'>" + shift_to_time + "</td>" +
                    /*"<td aria-colindex='6' role='cell'>" + tab_designation + "</td>" +*/
                    "<td aria-colindex='6' role='cell'>" + tab_emp_name + "</td>" +
                    "<td aria-colindex='6' role='cell'>" + tab_mobile_number + "</td>" +
                    // "<td aria-colindex='6' role='cell'>" + tab_offday + "</td>" +
                    "<td aria-colindex='7' role='cell'>" + tab_remrks + "</td></tr>";
                /*$("#tab_designation_id").val('').trigger('change');*/
                $("#tab_emp_id").val('').trigger('change');
                $("#tab_offday_id").val('').trigger('change');
                $("#tab_dredging_from").val("");
                $("#tab_dredging_to").val("");
                $("#shift_from_time").val("");
                $("#shift_to_time").val("");
                $("#ship_booking_time").val("");
                $("#tab_mobile_number").val("");
                $("#tab_remrks").val("");
                $("#table-exam-result tbody").append(markup);

                dataArray.push(tab_emp_id);
                //}

            }
        });


        $(".delete-row").click(function () {
            let arr_stuff = [];
            let tab_emp_id = [];
            $(':checkbox:checked').each(function (i) {
                arr_stuff[i] = $(this).val();
                let sd = arr_stuff[i].split('+');
                if (sd[1]) {
                    tab_emp_id.push(sd[1]);
                }
            });

            if (tab_emp_id.length != 0) {
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
                            data: {tab_emp_id: tab_emp_id},
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



        function inspectionList() {
            var url = '{{route('schedule.dreadging-inspection-datatable-list')}}';
             $('#dradging-inspection-list').DataTable({
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
                    {data: 'inspection_date', name: 'inspection_date', searchable: true},
                    {data: 'ship_booking_time', name: 'ship_booking_time'},
                    {data: 'duty_time', name: 'duty_time'},
                    {data: 'emp_name', name: 'emp_name'},
                    {data: 'mobile_no', name: 'mobile_no'},
                    {data: 'action', name: 'action', searchable: false},
                ]
            });

        };

        /*$("#ship_booking_time").change.datetimepicker(function (e) {
            console.log
        });*/

        function getValue(that){
            let twoHrsAdd = moment($(that).val(),"HH:mm").add(2, 'h').format("HH:mm");
            $('#shift_from_time').val(twoHrsAdd);
        }

        $(document).ready(function () {
            datePicker('#tab_dredging_to');
            datePicker('#tab_dredging_from');
            inspectionList();


            timePickerCustom('#ship_booking_time');
            timePickerCustom('#shift_from_time');
            timePickerCustom('#shift_to_time');





            // $('#ship_booking_time').on('change', function () {
            //     alert('Hi');
            //     console.log($(this).val());
            //     var va = $(this).val();
            //     alert(va);
            //     let twoHrsAdd = moment(va).add(2, 'h').format("HH:mm");
            //     alert(twoHrsAdd);
            //     $('#shift_from_time').val(twoHrsAdd);
            // })


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




        });

    </script>

@endsection

