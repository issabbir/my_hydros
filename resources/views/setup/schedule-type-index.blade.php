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
                    <h4 class="card-title">Schedule Type Setup</h4>
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
                    <form @if(isset($scheduleType->schedule_type_id)) action="{{route('setup.schedule-type-update',
                    [$scheduleType->schedule_type_id])}}"
                          @else action="{{route('setup.schedule-type-post')}}" @endif method="post">
                        @csrf
                        @if (isset($scheduleType->schedule_type_id))
                            @method('PUT')
                        @endif
                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="schedule_type_name" class="required">Schedule Type </label>
                                    <input required
                                           type="text"
                                           class="form-control"
                                           id="schedule_type_name"
                                           name="schedule_type_name"
                                           placeholder="Schedule  Type "
                                           value="{{old('schedule_type_name',isset($scheduleType->schedule_type_name) ? $scheduleType->schedule_type_name : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="schedule_type_name_bn" >Schedule Type  (Bangla)</label>
                                    <input
                                           type="text"
                                           class="form-control bn-lang-val-check"
                                           id="schedule_type_name_bn"
                                           name="schedule_type_name_bn"
                                           placeholder="Enter Schedule Type  (Bangla)"
                                           value="{{old('schedule_type_name_bn',isset($scheduleType->schedule_type_name_bn) ? $scheduleType->schedule_type_name_bn : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text"
                                           class="form-control"
                                           id="description"
                                           name="description"
                                           placeholder="Enter Description"
                                           value="{{old('description',isset($scheduleType->description) ? $scheduleType->description : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="active_yn" class="required">Active?</label>
                                    <ul class="list-unstyled mb-0">
                                        <li class="d-inline-block mr-2 mb-1">
                                            <fieldset>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="active_yn"
                                                           id="active_yes"
                                                           value="{{\App\Enums\YesNoFlag::YES}}"
                                                           @if($scheduleType && ($scheduleType->active_yn == \App\Enums\YesNoFlag::YES))
                                                           checked
                                                           @elseif(!$scheduleType)
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
                                                    <input class="custom-control-input" type="radio" name="active_yn"
                                                           id="active_no"
                                                           value="{{\App\Enums\YesNoFlag::NO}}"
                                                           @if($scheduleType && ($scheduleType->active_yn != \App\Enums\YesNoFlag::YES))
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

                        <div class="col-md-12 pr-0 d-flex justify-content-end">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary mr-1 mb-1">Save</button>
                                <input type="reset" class="btn btn-light-secondary mb-1" value="Reset" />
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Table End -->
            </div>


           @include('setup.schedule-type-datatable-list')


        </div>
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">
        function scheduleTypeList()
        {
            $('#tbl_schedule_type').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{route('setup.schedule-type-datatable-list')}}',
                    'type': 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', "name": 'DT_RowIndex'},
                    {data: 'schedule_type_name'},
                    {data: 'description'},
                    {data: 'active'},
                    {data: "action"},
                ]
            });
        }

        $(document).ready(function () {


            $('#from_date,#to_date').datepicker({
                autoclose: true,
                todayHighlight: true,
                //minDate:new Date()
                //startDate: "now()"
                orientation: "bottom auto",
            });
            scheduleTypeList();
        });
    </script>

@endsection

