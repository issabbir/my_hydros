@if(isset($year_id) && isset($month_id))

    <div class="" style="overflow-x:auto;">
        @php
            $from_date = $year_id . "-" . $month_id . "-" . "01";
            $to_date = $year_id . "-" . $month_id . "-" . date('t', strtotime($from_date));
        @endphp


        <div>
            <caption>{{ date('F, Y',strtotime($from_date))}}</caption>
        </div>
        <table id="tbl_roaster" class="table table-striped table-bordered">


            <thead>
            <tr>
                <th>
                    Employee Name
                </th>
                <th>
                    Designation
                </th>
                @php
                    $date = $from_date;
                    $end = $to_date; //get end date of month
                @endphp
                @while (strtotime($date) <= strtotime($end))
                    @php
                        $day_num = date('d', strtotime($date));
                        $day_name = date('l', strtotime($date));
                        $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                    @endphp
                    {{--  <th>{{$day_name}}</th>--}}
                    <th>
                        {{$day_num}} ({{$day_name}})

                    </th>
                @endwhile
            </tr>
            </thead>
            <tbody>

            @foreach($boat_employees as $boat_employee)
                <tr class="days" id="{{$boat_employee->boat_employee_id}}">

                    <td class="day other-month">
                        {{$boat_employee->employee->emp_name}}
                    </td>


                    <td class="day other-month">
                        {{$boat_employee->designation->designation}}
                    </td>

                    {{-- <td>
                         @json($boat_employee->schedule_details)

                     </td>
 --}}
                    @php
                        $tddate = $from_date;
                        $tdend = $to_date; //get end date of month
                    @endphp
                    @while (strtotime($tddate) <= strtotime($tdend))
                        @php
                            $td_day_num = date('d', strtotime($tddate));
                            $td_day_name = date('l', strtotime($tddate));
                            $tddate = date("Y-m-d", strtotime("+1 day", strtotime($tddate)));
                        @endphp
                        {{--  <th>{{$day_name}}</th>--}}
                        <td class="day other-month">
                            @foreach ($boat_employee->schedule_details as $item)
                                @if($item->dt == $td_day_num && $item->holiday_yn == 'N')
                                    {{--<div class="date">
                                        {{$td_day_num}}

                                    </div>--}}
                                    <div class="event">
                                        <div class="event-desc">
                                            <div>
                                                {{$item->schedule_comment}}
                                            </div>
                                        </div>

                                        <div class="event-time">
                                            {{$item->schedule_from_time}} to {{$item->schedule_to_time}}
                                        </div>
                                    </div>

                                @elseif($item->dt == $td_day_num && $item->holiday_yn == 'Y')
                                    <div class="event">
                                        <div class="event-desc">
                                            <div>
                                                Holiday
                                            </div>
                                        </div>
                                    </div>

                                    {{--
                                                                        @else
                                                                            <div class="event">
                                                                                <div class="event-desc">
                                                                                    <div>
                                                                                        Holiday
                                                                                    </div>
                                                                                </div>
                                                                            </div>--}}
                                @endif
                            @endforeach
                        </td>
                    @endwhile

                </tr>
            @endforeach

            </tbody>
        </table>

    </div>


@endif
