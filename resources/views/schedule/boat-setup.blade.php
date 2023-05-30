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
                    <h4 class="card-title">Boat Setup</h4>
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
                    <form @if(isset($vInfo->vehicle_id)) action="{{route('schedule.boat-setup-update',
                    [$vInfo->vehicle_id])}}"
                          @else action="{{route('schedule.boat-setup-post')}}" @endif method="post">
                        @csrf
                        @if (isset($vInfo->vehicle_id))
                            <input type="hidden" name="vehicle_id"
                                   value="{{$vInfo->vehicle_id}}">
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="water_vessel_name" class="required">Boat Name</label>
                                    <input required autocomplete="off"
                                           type="text"
                                           class="form-control"
                                           id="vehicle_name"
                                           name="vehicle_name"
                                           placeholder="Enter Boat Name"
                                           value="{{old('vehicle_name',isset($vInfo->vehicle_name) ? $vInfo->vehicle_name : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="water_vessel_name_bn">Boat Name(Bangla)</label>
                                    <input type="text" autocomplete="off"
                                           class="form-control bn-lang-val-check"
                                           id="vehicle_name_bn"
                                           name="vehicle_name_bn"
                                           placeholder="Enter Zone Area Name(Bangla)"
                                           value="{{old('vehicle_name_bn',isset($vInfo->vehicle_name_bn) ? $vInfo->vehicle_name_bn : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="team_id" class="required">Boat Type</label>
                                    <select class="custom-select select2 form-control" required id="vehicle_type_id"
                                            name="vehicle_type_id">
                                        <option value="">Select One</option>
                                        @foreach($boatType as $value)
                                            <option value="{{$value->vehicle_type_id}}"
                                                {{isset($vInfo->vehicle_type_id) && $vInfo->vehicle_type_id == $value->vehicle_type_id ? 'selected' : ''}}
                                            >{{$value->type_name}}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="team_id" class="required">Boat Category</label>
                                    <select class="custom-select select2 form-control" required id="vehicle_category_id"
                                            name="vehicle_category_id">
                                        <option value="">Select One</option>
                                        @foreach($boatCategory as $value)
                                            <option value="{{$value->vehicle_category_id}}"
                                                {{isset($vInfo->vehicle_catgeory_id) && $vInfo->vehicle_catgeory_id == $value->vehicle_category_id ? 'selected' : ''}}
                                            >{{$value->category_name}}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Engine Capacity</label>
                                    <input type="number" autocomplete="off"
                                           class="form-control"
                                           id="engine_capacity"
                                           name="engine_capacity"
                                           placeholder="Enter Engine Capacity"
                                           value="{{old('engine_capacity',isset($vInfo->engine_capacity) ? $vInfo->engine_capacity : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Origin</label>
                                    <input type="text" autocomplete="off"
                                           class="form-control"
                                           id="origin"
                                           name="origin"
                                           placeholder="Enter Origin"
                                           value="{{old('origin',isset($vInfo->origin) ? $vInfo->origin : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control"
                                              aria-label="Description" id="description"
                                              name="description" rows="5"
                                              placeholder="Enter Description"
                                    >{{old('description',isset($vInfo->description) ? $vInfo->description : '')}}</textarea>
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Fuel Type</label>
                                    <input type="text" autocomplete="off"
                                           class="form-control"
                                           id="fuel_type"
                                           name="fuel_type"
                                           placeholder="Enter Fuel Type"
                                           value="{{old('fuel_type',isset($vInfo->fuel_type) ? $vInfo->fuel_type : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Model Year</label>
                                    <input type="number" autocomplete="off"
                                           class="form-control"
                                           id="model_year"
                                           name="model_year"
                                           placeholder="Enter Model Year"
                                           value="{{old('model_year',isset($vInfo->model_year) ? $vInfo->model_year : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 pr-0 d-flex justify-content-end">
                                <div class="form-group">
                                    @if(!isset($vInfo))
                                        <button id="boat-employee-save" type="submit"
                                                class="btn btn-primary mr-1 mb-1">Save
                                        </button>
                                    @else
                                        <button id="boat-employee-save" type="submit"
                                                class="btn btn-primary mr-1 mb-1">Update
                                        </button>
                                    @endif
                                    <input id="boat-employee-reset" type="button"
                                           onclick="window.location='{{ route('schedule.boat-setup-index') }}'"
                                           class="btn btn-light-secondary mb-1" value="Reset"/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Table End -->
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">Boat Setup List</h4>
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table id="tbl_boat_setup" class="table table-sm datatable mdl-data-table dataTable">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Boat Name</th>
                                            <th>Category</th>
                                            <th>Type</th>
                                            <th>Engine Capacity</th>
                                            <th>Origin</th>
                                            <th>Model Year</th>
                                            <th>Fuel Type</th>
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


        </div>
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">
        function boatSetuplList() {
            $('#tbl_boat_setup').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{route('schedule.boat-setup-datatable')}}',
                    'type': 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', "name": 'DT_RowIndex'},
                    {data: 'vehicle_name', searchable: true},
                    {data: 'category_name', searchable: true},
                    {data: 'type_name', searchable: true},
                    {data: 'engine_capacity', searchable: true},
                    {data: 'origin', searchable: true},
                    {data: 'model_year', searchable: true},
                    {data: 'fuel_type', searchable: true},
                    {data: "action", searchable: false},
                ]
            });
        }

        $(document).ready(function () {
            boatSetuplList();
        });
    </script>

@endsection

