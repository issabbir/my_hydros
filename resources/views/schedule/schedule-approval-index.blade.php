@extends('layouts.default')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection
@section('content')
    <div class="row">
        <div class="col-12">

            @if(Session::has('message'))
                <div class="alert {{Session::get('m-class') ? Session::get('m-class') : 'alert-danger'}} show"
                     role="alert">
                    {{ Session::get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(isset($schedule->schedule_master_id))


                <div class="card">
                    <!-- Table Start -->
                    <div class="card-body">
                        <h4 class="card-title">Schedule Detail</h4>
                        <hr>

                        <form @if(isset($schedule->schedule_master_id)) action="{{route('schedule.schedule-update',
                    [$schedule->schedule_master_id])}}"
                              @else action="{{route('schedule.schedule-post')}}" @endif method="post">
                            @csrf
                            @if (isset($schedule->schedule_master_id))
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="schedule_name" class="">Schedule Name</label>
                                        <input disabled
                                               type="text"
                                               class="form-control"
                                               id="schedule_name"
                                               name="schedule_name"
                                               placeholder="Enter Schedule Name"
                                               value="{{old('schedule_name',isset($schedule->schedule_name) ? $schedule->schedule_name : '')}}"
                                        >
                                        <small class="text-muted form-text"></small>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="schedule_name_bn" >Schedule Name(Bangla)</label>
                                        <input disabled
                                               type="text"
                                               class="form-control"
                                               id="schedule_name_bn"
                                               name="schedule_name_bn"
                                               placeholder="Enter Schedule Name(Bangla)"
                                               value="{{old('schedule_name_bn',isset($schedule->schedule_name_bn) ? $schedule->schedule_name_bn : '')}}"
                                        >
                                        <small class="text-muted form-text"></small>
                                    </div>
                                </div>


                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="schedule_name_bn" >Description</label>
                                        <input disabled
                                               type="text"
                                               class="form-control"
                                               id="description"
                                               name="description"
                                               placeholder="Enter Description"
                                               value="{{old('description',isset($schedule->description) ? $schedule->description : '')}}"
                                        >
                                        <small class="text-muted form-text"></small>
                                    </div>
                                </div>



                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="schedule_type_id" class="required">Schedule Type </label>
                                        <select disabled class=" form-control" required id="schedule_type_id"
                                                name="schedule_type_id">
                                            <option value="">Select One</option>
                                            @if(isset($schedule_types))
                                                @foreach($schedule_types as $schedule_type)
                                                    <option value="{{$schedule_type->schedule_type_id}}"
                                                            @if(isset($schedule->schedule_type_id) &&
                                                            ($schedule->schedule_type_id == $schedule_type->schedule_type_id))
                                                            selected
                                                        @endif
                                                    >{{$schedule_type->schedule_type_name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="schedule_from_date">Schedule From Date</label>
                                        <input disabled type="text"
                                               autocomplete="off"
                                               class="form-control"
                                               data-toggle="datetimepicker"
                                               id="schedule_from_date"
                                               data-target="#active_to"
                                               name="schedule_from_date"
                                               placeholder="YYYY-MM-DD"
                                               required
                                               data-date-format="yyyy-mm-dd"
                                               value="{{old('schedule_from_date',isset
                                           ($schedule->schedule_from_date) ?
                                           date('Y-m-d',strtotime($schedule->schedule_from_date)) : '')}}"/>
                                        <small class="text-muted form-text"> </small>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="schedule_to_date" >Schedule To Date</label>
                                        <input disabled type="text"
                                               autocomplete="off"
                                               class="form-control"
                                               data-toggle="datetimepicker"
                                               id="schedule_to_date"
                                               data-target="#active_to"
                                               name="schedule_to_date"
                                               placeholder="YYYY-MM-DD"
                                               required
                                               data-date-format="yyyy-mm-dd"
                                               value="{{old('schedule_to_date',isset
                                           ($schedule->schedule_to_date) ?
                                           date('Y-m-d',strtotime($schedule->schedule_to_date)) : '')}}"/>
                                        <small class="text-muted form-text"> </small>
                                    </div>
                                </div>


                            </div>
                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="active_yn" >Active?</label>
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-inline-block mr-2 mb-1">
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input disabled class="custom-control-input" type="radio" name="active_yn"
                                                               id="active_yes"
                                                               value="{{\App\Enums\YesNoFlag::YES}}"
                                                               @if($schedule && ($schedule->active_yn == \App\Enums\YesNoFlag::YES))
                                                               checked
                                                               @elseif(!$schedule)
                                                               checked
                                                            @endif
                                                        />
                                                        <label class="custom-control-label" for="active_yes"> Yes </label>
                                                    </div>
                                                </fieldset>
                                            </li>
                                            <li class="d-inline-block mr-2 mb-1">
                                                <fieldset>
                                                    <div class="custom-control custom-radio">
                                                        <input disabled class="custom-control-input" type="radio" name="active_yn"
                                                               id="active_no"
                                                               value="{{\App\Enums\YesNoFlag::NO}}"
                                                               @if($schedule && ($schedule->active_yn != \App\Enums\YesNoFlag::YES))
                                                               checked
                                                            @endif
                                                        />
                                                        <label class="custom-control-label" for="active_no"> No </label>
                                                    </div>
                                                </fieldset>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>
                    <!-- Table End -->
                </div>

            @endif

            @if(isset($schedule->schedule_master_id))
                @include('schedule.partial.team-employee-detail-datatable')
                @include('schedule.partial.schedule-approval-detail')
            @else
                @include('schedule.schedule-approval-datatable-list')
            @endif

            @include('approval.workflowmodal')
        </div>
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">
        function scheduleApprovalList() {
            $('#tbl_schedule').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{route('schedule.schedule-approval-datatable-list')}}',
                    'type': 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                /*columns: [
                    {data: 'DT_RowIndex', "name": 'DT_RowIndex'},
                    {data: 'schedule2.schedule_name'},
                    {data: 'schedule2.schedule_type.schedule_type_name'},//schedule_type
                    {data: 'schedule2.schedule_from_date'},
                    {data: 'schedule2.schedule_to_date'},
                    {data: 'rejected'},
                    {data: 'approved'},
                    {data: "action"},
                ]*/
                columns: [
                    {data: 'DT_RowIndex', "name": 'DT_RowIndex'},
                    {data: 'schedule_name'},
                    {data: 'schedule_type.schedule_type_name'},//schedule_type
                    {data: 'schedule_from_date'},
                    {data: 'schedule_to_date'},
                    {data: 'rejected'},
                    {data: 'approved'},
                    {data: "action"},
                ]
            });
        }

        $(document).ready(function () {
            scheduleApprovalList();

            $('#schedule_from_date,#schedule_to_date').datepicker({
                autoclose: true,
                todayHighlight: true,
                //minDate:new Date()
                //startDate: "now()"
                orientation: "bottom auto",
            });

        });




    </script>

@endsection

