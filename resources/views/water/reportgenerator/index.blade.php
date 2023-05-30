@extends('layouts.default')

@section('title')
    Report Generator
@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body"><h4 class="card-title">Report Generator</h4>
                    <hr>
                    <form id="report-generator" method="POST" action="{{route('report')}}" target="_blank">
                        {{ csrf_field() }}
                        <input type="hidden" id="actionInput" value="{{route('report')}}">
                        <div class="row justify-content-center">
                            <div class="col-md-11">
                                <div class="row mt-1">
                                    <div class="col-md-6">
                                        <label class="required">Report</label>
                                        <select name="report" id="report" required class="form-control">
                                            <option value="">Select Report</option>
                                            @foreach($reports as $report)
                                                <option value="{{$report->report_id}}"
                                                        data-report-name="{{$report->report_name}}">{{$report->report_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-1" id="report-params"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="report-params" class="col-12"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">
        $(function () {
            function load_report() {
                console.log('lod report');
            }

            load_report();
            $('#report').on('change', function (e) {
                e.preventDefault();
                let reportId = $(this).val();
                let reportName = $(this).find('option:selected').attr('data-report-name');

                $(this).closest('form').attr('action');
                var  actionInput =   $('#actionInput').val();
                $(this).closest('form').attr('action', actionInput + '/' + reportName);

                if (
                    (reportId !== undefined) && (reportId !== null) && (reportName !== undefined) && (reportName !== '')
                ) {
                    var url = '{{route('report-generator-params')}}' + "?id=" + reportId;

                    console.log(url);
                    $.ajax({
                        type: "GET",
                        url: url,
                        success: function (data) {
                            console.log(data);
                            //$('#report-generator').attr('action', APP_URL+'/report/render/'+reportName);
                            $('#report-params').html(data);
                        },
                        error: function (err) {
                            alert('error', err);
                        }
                    });
                } else {
                    $('#report-generator').attr('action', '');
                    $('#report-params').html('');
                }
            });
        })
    </script>
@endsection
