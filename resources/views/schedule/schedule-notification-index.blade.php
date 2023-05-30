@extends('layouts.default')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Table Start -->
                <div class="card-body">
                    <h4 class="card-title">Schedule Notification</h4>
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
                    <form action="{{route('schedule.schedule-notification-post')}}" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="schedule_id" class="required">Schedule  </label>
                                    <select class="custom-select select2 form-control" required  id="schedule_master_id"
                                            name="schedule_master_id">
                                        <option value="">Select One</option>
                                        @if(isset($approved_schedules))
                                            @foreach($approved_schedules as $schedule)
                                                <option value="{{$schedule->schedule_master_id}}">
                                                    {{$schedule->schedule_name}}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="notification_type_id" class="required">Notification Type  </label>
                                    <select class="form-control" required id="notification_type_id"
                                            name="notification_type_id">
                                        <option value="">Select One</option>
                                        @if(isset($notification_types))
                                            @foreach($notification_types as $notification_type)
                                                <option value="{{$notification_type->notification_type_id}}"
                                                >{{$notification_type->notification_type_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 pr-0 d-flex justify-content-end">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary mr-1 mb-1" value="Send" />
                                <input type="reset" class="btn btn-light-secondary mb-1" value="Reset" />
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Table End -->
            </div>


           @include('schedule.schedule-notification-datatable-list')


        </div>
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">
        function scheduleNotificationList()
        {
            $('#tbl_schedule_notification').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{route('schedule.schedule-notification-datatable-list')}}',
                    'type': 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', "name": 'DT_RowIndex'},
                    {data: 'schedule_name'},
                    {data: 'notified'},
                    {data: 'notification_type_name'},
                    {data: 'notification_date'},

                ]
            });
        }

        $(document).ready(function () {
            scheduleNotificationList();

            $(document).on("click","input[type='reset']", function(){

                $("#notification_type_id").val(0).trigger('change.select2').select2({
                    placeholder: "Select One",
                });
                $("#schedule_master_id" ).val(1).trigger('change.select2').select2({
                    placeholder: "Select One",
                });

            });

        });
    </script>

@endsection

