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
                    <h4 class="card-title">Zone Area Setup</h4>
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
                    <form @if(isset($zoneArea->zonearea_id)) action="{{route('setup.zone-area-update',
                    [$zoneArea->zonearea_id])}}"
                          @else action="{{route('setup.zone-area-post')}}" @endif method="post">
                        @csrf
                        @if (isset($zoneArea->zonearea_id))
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="water_vessel_no" class="required">Sheet No</label>
                                    <input required
                                           type="text"
                                           class="form-control"
                                           id="sheet_no"
                                           name="sheet_no"
                                           placeholder="Enter Sheet No"
                                           value="{{old('sheet_no',isset($zoneArea->sheet_no) ? $zoneArea->sheet_no : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="water_vessel_name" class="required">Zone Area Name</label>
                                    <input required
                                           type="text"
                                           class="form-control"
                                           id="proposed_name"
                                           name="proposed_name"
                                           placeholder="Enter Zone Area Name"
                                           value="{{old('proposed_name',isset($zoneArea->proposed_name) ? $zoneArea->proposed_name : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="water_vessel_name_bn">Zone Area Name(Bangla)</label>
                                    <input type="text"
                                           class="form-control bn-lang-val-check"
                                           id="proposed_name_bn"
                                           name="proposed_name_bn"
                                           placeholder="Enter Zone Area Name(Bangla)"
                                           value="{{old('proposed_name_bn',isset($zoneArea->proposed_name_bn) ? $zoneArea->proposed_name_bn : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">

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
                                                           @if($zoneArea && ($zoneArea->active_yn == \App\Enums\YesNoFlag::YES))
                                                           checked
                                                           @elseif(!$zoneArea)
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
                                                           @if($zoneArea && ($zoneArea->active_yn != \App\Enums\YesNoFlag::YES))
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
                                <input type="reset" class="btn btn-light-secondary mb-1" value="Reset"/>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Table End -->
            </div>


            @include('setup.zone-area-datatable-list')


        </div>
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">
        function zoneArealList() {
            $('#tbl_zone_area').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{route('setup.zone-area-datatable-list')}}',
                    'type': 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', "name": 'DT_RowIndex'},
                    {data: 'sheet_no'},
                    {data: 'proposed_name'},
                    {data: 'active'},
                    {data: "action"},
                ]
            });
        }

        $(document).ready(function () {
            zoneArealList();
        });
    </script>

@endsection

