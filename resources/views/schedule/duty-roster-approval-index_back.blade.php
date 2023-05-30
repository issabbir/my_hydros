@extends('layouts.default')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"
            integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
    <style>
        .wickedpicker {
            z-index: 1151 !important;
        }

        body {
            font-family: Tahoma;
        }



        /* declare a 7 column grid on the table */
        #calendar {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }

        #calendar tr, #calendar tbody {
            grid-column: 1 / -1;
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            width: 100%;
        }

        caption {
            text-align: center;
            grid-column: 1 / -1;
            font-size: 130%;
            font-weight: bold;
            padding: 10px 0;
        }

        #calendar a {
            color: #8e352e;
            text-decoration: none;
        }

        #calendar td, #calendar th {
            padding: 5px;
            box-sizing:border-box;
            border: 1px solid #ccc;
        }

        #calendar .weekdays {
            background: #8e352e;
        }


        #calendar .weekdays th {
            text-align: center;
            text-transform: uppercase;
            line-height: 20px;
            border: none !important;
            padding: 10px 6px;
            color: #fff;
            font-size: 13px;
        }

        #calendar td {
            min-height: 180px;
            display: flex;
            flex-direction: column;
        }

        #calendar .days li:hover {
            background: #d3d3d3;
        }

        #calendar .date {
            text-align: center;
            margin-bottom: 5px;
            padding: 4px;
            background: #333;
            color: #fff;
            width: 20px;
            border-radius: 50%;
            flex: 0 0 auto;
            align-self: flex-end;
        }

        #calendar .event {
            flex: 0 0 auto;
            font-size: 13px;
            border-radius: 4px;
            padding: 5px;
            margin-bottom: 5px;
            line-height: 14px;
            background: #e4f2f2;
            border: 1px solid #b5dbdc;
            color: #009aaf;
            text-decoration: none;
        }

        #calendar .event-desc {
            color: #666;
            margin: 3px 0 7px 0;
            text-decoration: none;
        }

        #calendar .other-month {
            background: #f5f5f5;
            color: #666;
        }

        /* ============================
                        Mobile Responsiveness
           ============================*/

/*
        @media(max-width: 768px) {

            #calendar .weekdays, #calendar .other-month {
                display: none;
            }

            #calendar li {
                height: auto !important;
                border: 1px solid #ededed;
                width: 100%;
                padding: 10px;
                margin-bottom: -1px;
            }

            #calendar, #calendar tr, #calendar tbody {
                grid-template-columns: 1fr;
            }

            #calendar  tr {
                grid-column: 1 / 2;
            }

            #calendar .date {
                align-self: flex-start;
            }
        }*/
    </style>
@endsection
@section('content')

    <div class="row">
        <div class="col-12">
            @json($boat_employees)

            <div class="card">
                <!-- Table Start -->
                <div class="card-body">
                    <h4 class="card-title">Duty Roaster Approval</h4>
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

                    <form id="frm_duty_roaster" method="post" action="{{route('schedule.duty-roster-approval-save')}}">


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
                                    <label for="team_id" class="required">Month </label>
                                    <select class="custom-select select2 form-control" id="month_id"
                                            name="month_id" required>
                                        <option value="">Select One</option>
                                        @if(isset($months))
                                            @foreach($months as $month)
                                                <option value="{{$month->month_id}}"
                                                        @if(isset($scheduleType->month_id) &&
                                                        ($scheduleType->month_id == $month->month_id))
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
                            </div>


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




    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">Employee List</h4>
                            <div class="card-content">

                                <table id="calendar">
                                    <caption>August 2014</caption>
                                    <tr class="weekdays">
                                        <th scope="col">Sunday</th>
                                        <th scope="col">Monday</th>
                                        <th scope="col">Tuesday</th>
                                        <th scope="col">Wednesday</th>
                                        <th scope="col">Thursday</th>
                                        <th scope="col">Friday</th>
                                        <th scope="col">Saturday</th>
                                    </tr>

                                    <tr class="days">
                                        <td class="day other-month">
                                            <div class="date">27</div>
                                        </td>
                                        <td class="day other-month">
                                            <div class="date">28</div>
                                            <div class="event">
                                                <div class="event-desc">
                                                    HTML 5 lecture with Brad Traversy from Eduonix
                                                </div>
                                                <div class="event-time">
                                                    1:00pm to 3:00pm
                                                </div>
                                            </div>
                                        </td>
                                        <td class="day other-month">
                                            <div class="date">29</div>
                                        </td>
                                        <td class="day other-month">
                                            <div class="date">30</div>
                                        </td>
                                        <td class="day other-month">
                                            <div class="date">31</div>
                                        </td>


                                        <td class="day">
                                            <div class="date">1</div>
                                        </td>
                                        <td class="day">
                                            <div class="date">2</div>
                                            <div class="event">
                                                <div class="event-desc">
                                                    Career development @ Community College room #402
                                                </div>

                                                <div class="event-time">
                                                    2:00pm to 5:00pm
                                                </div>
                                            </div>
                                            <div class="event">
                                                <div class="event-desc">
                                                    Test event 2
                                                </div>

                                                <div class="event-time">
                                                    5:00pm to 6:00pm
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="day">
                                            <div class="date">3</div>
                                        </td>
                                        <td class="day">
                                            <div class="date">4</div>
                                        </td>
                                        <td class="day">
                                            <div class="date">5</div>
                                        </td>
                                        <td class="day">
                                            <div class="date">6</div>
                                        </td>
                                        <td class="day">
                                            <div class="date">7</div>
                                            <div class="event">
                                                <div class="event-desc">
                                                    Group Project meetup
                                                </div>
                                                <div class="event-time">
                                                    6:00pm to 8:30pm
                                                </div>
                                            </div>
                                        </td>
                                        <td class="day">
                                            <div class="date">8</div>
                                        </td>
                                        <td class="day">
                                            <div class="date">9</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="day">
                                            <div class="date">10</div>
                                        </td>
                                        <td class="day">
                                            <div class="date">11</div>
                                        </td>
                                        <td class="day">
                                            <div class="date">12</div>
                                        </td>
                                        <td class="day">
                                            <div class="date">13</div>
                                        </td>
                                        <td class="day">
                                            <div class="date">14</div>
                                            <div class="event">
                                                <div class="event-desc">
                                                    Board Meeting
                                                </div>
                                                <div class="event-time">
                                                    1:00pm to 3:00pm
                                                </div>
                                            </div>
                                        </td>
                                        <td class="day">
                                            <div class="date">15</div>
                                        </td>
                                        <td class="day">
                                            <div class="date">16</div>
                                        </td>
                                    </tr>
                                    <tr>

                                        <td class="day">
                                            <div class="date">17</div>
                                        </td>
                                        <td class="day">
                                            <div class="date">18</div>
                                        </td>
                                        <td class="day">
                                            <div class="date">19</div>
                                        </td>
                                        <td class="day">
                                            <div class="date">20</div>
                                        </td>
                                        <td class="day">
                                            <div class="date">21</div>
                                        </td>
                                        <td class="day">
                                            <div class="date">22</div>
                                            <div class="event">
                                                <div class="event-desc">
                                                    Conference call
                                                </div>
                                                <div class="event-time">
                                                    9:00am to 12:00pm
                                                </div>
                                            </div>
                                        </td>
                                        <td class="day">
                                            <div class="date">23</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="day">
                                            <div class="date">24</div>
                                        </td>
                                        <td class="day">
                                            <div class="date">25</div>
                                            <div class="event">
                                                <div class="event-desc">
                                                    Conference Call
                                                </div>
                                                <div class="event-time">
                                                    1:00pm to 3:00pm
                                                </div>
                                            </div>
                                        </td>
                                        <td class="day">
                                            <div class="date">26</div>
                                        </td>
                                        <td class="day">
                                            <div class="date">27</div>
                                        </td>
                                        <td class="day">
                                            <div class="date">28</div>
                                        </td>
                                        <td class="day">
                                            <div class="date">29</div>
                                        </td>
                                        <td class="day">
                                            <div class="date">30</div>
                                        </td>
                                    </tr>
                                    <tr>

                                        <td class="day">
                                            <div class="date">31</div>
                                        </td>
                                        <td class="day other-month">
                                            <div class="date">1</div>
                                            <!-- Next Month -->
                                        </td>
                                        <td class="day other-month">
                                            <div class="date">2</div>
                                        </td>
                                        <td class="day other-month">
                                            <div class="date">3</div>
                                        </td>
                                        <td class="day other-month">
                                            <div class="date">4</div>
                                        </td>
                                        <td class="day other-month">
                                            <div class="date">5</div>
                                        </td>
                                        <td class="day other-month">
                                            <div class="date">6</div>
                                        </td>

                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer-script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

    <script>

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

        $(document).ready(function () {

            selectMonth();
            populateYear();


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
                /* alertify.confirm('Confirm Roaster', 'Are you sure?',
                     function () {

                         var product_order_id = $('#product_order_id').val();
                         var tentative_confirmation = $('#tentative_confirmation').val();
                         var description = $('#description').val();


                         var detail = {};
                         detail.product_order_id = product_order_id;
                         detail.tentative_confirmation = tentative_confirmation;
                         detail.description = description;
                         //
                         detail.confirmed_yn = '<?php echo e(\App\Enums\YesNoFlag::YES); ?>';

                        console.log(detail);
                        var url  = '';
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: detail,
                            success: function (resp) {
                                console.log(resp);

                                if (resp.o_status_code == 1) {

                                    $('#tbl_product_completed_list tr').each(function () {
                                        var id = $(this).attr('id');

                                        if (id == product_order_id) {
                                            $(this).closest('tr').find('.confirmed').html('Yes');
                                            //var cur_date = '<?php echo e(date('Y-m-d')); ?>';
                                            $(this).closest('tr').find('.confirmed_date').html('<span>' + tentative_confirmation + '<span>');
                                        }
                                    });
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
                );*/

            })


            $('.from-timepicker').wickedpicker({
                title: 'To',
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
