
<div class="col-12">
    <div class="row">
        @if($report)
            @if($report->params)

                @foreach($report->params as $reportParam)

                    @if($reportParam->param_name == 'P_SCHEDULE_MASTER_ID')
                        <div class="col-md-3">
                            <label for="{{$reportParam->param_name}}"
                                   class="@if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif">{{$reportParam->param_label}}</label>
                            <select name="{{$reportParam->param_name}}" id="{{$reportParam->param_name}}"
                                    class="form-control"
                                    @if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif>
                                <option value="">Select One</option>
                                @if(isset($schedules))
                                    @foreach($schedules as $schedule)
                                        <option value="{{$schedule->schedule_master_id}}"
                                        >{{$schedule->schedule_name}}
                                            ( {{$schedule->schedule_from_date->format('Y-m-d')}}
                                            - {{$schedule->schedule_to_date->format('Y-m-d')}} )
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @else


                        @if($reportParam->param_name == 'P_SCHEDULE_MONTH')
                            <div class="col-md-3">
                                <label for="{{$reportParam->param_name}}"
                                       class="@if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif">{{$reportParam->param_label}}</label>
                                <select name="{{$reportParam->param_name}}" id="{{$reportParam->param_name}}"
                                        class="form-control"
                                        @if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif>
                                    <option value="">Select One</option>
                                    @if(isset($months))
                                        @foreach($months as $month)
                                            <option value="{{$month->month_id}}">
                                                {{$month->month_name}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        @endif

                            @if($reportParam->param_name == 'P_VEHICLE_ID')
                                <div class="col-md-3">
                                    <label for="{{$reportParam->param_name}}"
                                           class="@if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif">{{$reportParam->param_label}}</label>
                                    <select name="{{$reportParam->param_name}}" id="{{$reportParam->param_name}}"
                                            class="form-control"
                                            @if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif>
                                        <option value="">Select One</option>
                                        @if(isset($vehicles))
                                            @foreach($vehicles as $vehicle)
                                                <option value="{{$vehicle->vehicle_id}}">
                                                    {{$vehicle->vehicle_name}}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            @endif
                        @if($reportParam->param_name == 'P_SCHEDULE_YEAR')
                            <div class="col-md-3">
                                <label for="{{$reportParam->param_name}}"
                                       class="@if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif">{{$reportParam->param_label}}</label>
                                <select name="{{$reportParam->param_name}}" id="{{$reportParam->param_name}}"
                                        class="form-control"
                                        @if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif>

                                </select>
                            </div>
                        @endif
                    @endif
                @endforeach
            @endif
            <div class="col-md-3">
                <label for="type">Report Type</label>
                <select name="type" id="type" class="form-control">
                    <option value="pdf">PDF</option>
                    <option value="xlsx">Excel</option>
                </select>
                <input type="hidden" value="{{$report->report_xdo_path}}" name="xdo"/>
                <input type="hidden" value="{{$report->report_id}}" name="rid"/>
                <input type="hidden" value="{{$report->report_name}}" name="filename"/>
            </div>
            <div class="col-md-3 mt-2">
                <button type="submit" class="btn btn btn-dark shadow mr-1 mb-1 btn-secondary">Generate Report</button>
            </div>
        @endif
    </div>
</div>
<script type="text/javascript">
    function requisitionNumber() {
        $('#p_req_id').select2({
            placeholder: "Select",
            allowClear: true,
            ajax: {
                url: APP_URL + '/water/ajax/report-requisitions',
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
                        obj.id = obj.req_id;
                        obj.text = obj.req_no;
                        return obj;
                    });
                    return {
                        results: formattedResults,
                    };
                }
            }
        });
    }

    function bookingNumber() {
        $('#p_booking_mst_id').select2({
            placeholder: "Select",
            allowClear: true,
            width: "100%",
            ajax: {
                url: APP_URL + '/water/ajax/bookings',
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
                        obj.id = obj.booking_mst_id;
                        obj.text = obj.booking_no;
                        return obj;
                    });
                    return {
                        results: formattedResults,
                    };
                }
            }
        });
    }

    function invoiceNumber() {
        $('#p_invoice_mst_id').select2({
            placeholder: "Select",
            allowClear: true,
            width: "100%",
            ajax: {
                url: APP_URL + '/water/ajax/invoices',
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
                        obj.id = obj.invoice_mst_id;
                        obj.text = obj.invoice_no;
                        return obj;
                    });
                    return {
                        results: formattedResults,
                    };
                }
            }
        });
    }

    function datepicker(elem) {
        $(elem).datetimepicker({
            format: 'YYYY-MM-DD',
            widgetPositioning: {
                horizontal: 'left',
                vertical: 'bottom'
            },
            icons: {
                date: 'bx bxs-calendar',
                previous: 'bx bx-chevron-left',
                next: 'bx bx-chevron-right'
            }
        });
    }

    function agencies() {
        $('#p_agency_id').select2({
            placeholder: "Select",
            allowClear: true,
            ajax: {
                url: APP_URL + '/ajax/agencies',
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
                        obj.id = obj.agency_id;
                        obj.text = obj.agency_name;
                        return obj;
                    });
                    return {
                        results: formattedResults,
                    };
                }
            }
        });
    }

    function bookingOrInvoice() {
        var booking = 1;
        var invoice = 2;

        var bookingOrInvoice = $('#p_book_or_inv').val();
        if (bookingOrInvoice == booking) {
            $('#invoice_select').hide();
            $('#booking_select').show();
        } else if (bookingOrInvoice == invoice) {
            $('#invoice_select').show();
            $('#booking_select').hide();
        }

        $('#booking_select select').val('').change();
        $('#invoice_select select').val('').change();
    }

    function onChangeBookingOrInvoice() {
        $('#p_book_or_inv').on('change', function () {
            bookingOrInvoice();
        });
    }


    function populateYear() {
        var year = new Date().getFullYear()-1;
        var till = 2099;
        var options = "";
        for (var y = year; y <= till; y++) {
            options += "<option " + "value='" + y + "'" + ">" + y + "</option>";
        }
        document.getElementById("P_SCHEDULE_YEAR").innerHTML = options;
    }

    $(document).ready(function () {
        populateYear();
    });
</script>
