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
                    <h4 class="card-title">File Search</h4>
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
                    <form @if(isset($fileInfo->file_info_id)) action="{{route('file.file-upload-update',
                    [$fileInfo->file_info_id])}}"
                          @else action="{{route('file.archive-search-post')}}" @endif method="post" enctype="multipart/form-data">
                        @csrf
                        @if (isset($fileInfo->file_info_id))
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="name" >File Name</label>
                                    <input
                                           type="text"
                                           autocomplete="off"
                                           class="form-control"
                                           id="file_name"
                                           name="file_name"
                                           placeholder="Enter File Name"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>


                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="delivery_area_type_id">File Category</label>
                                    <select class="custom-select select2 form-control"  id="file_category_id" name="file_category_id">
                                        <option value="">Select One</option>
                                        @if(isset($fileCategories))
                                            @foreach($fileCategories as $fileCategory)
                                                <option value="{{$fileCategory->file_category_id}}"
                                                        @if(isset($fileInfo->file_category_id) &&
                                                        ($fileInfo->file_category_id == $fileCategory->file_category_id))
                                                        selected
                                                    @endif
                                                >{{$fileCategory->file_category_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="file_from_date" class="required">From Date</label>
                                    <input type="text"
                                           autocomplete="off"
                                           class="form-control"
                                           data-toggle="datetimepicker"
                                           id="file_from_date"
                                           data-target="#active_to"
                                           name="file_from_date"
                                           placeholder="YYYY-MM-DD"
                                           required
                                           data-date-format="yyyy-mm-dd"
                                           value="{{old('file_from_date',isset
                                           ($fileInfo->file_from_date) ?
                                           date('Y-m-d',strtotime($fileInfo->file_from_date)) : '')}}"/>
                                    <small class="text-muted form-text"> </small>
                                </div>
                            </div>


                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="file_to_date" class="required">To Date</label>
                                    <input type="text"
                                           autocomplete="off"
                                           class="form-control"
                                           data-toggle="datetimepicker"
                                           id="file_to_date"
                                           data-target="#active_to"
                                           name="file_to_date"
                                           placeholder="YYYY-MM-DD"
                                           required
                                           data-date-format="yyyy-mm-dd"
                                           value="{{old('file_to_date',isset
                                           ($fileInfo->file_to_date) ?
                                           date('Y-m-d',strtotime($fileInfo->file_to_date)) : '')}}"/>
                                    <small class="text-muted form-text"> </small>
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

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">Uploaded File List</h4>
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table id="tbl_file_upload" class="table table-sm datatable mdl-data-table dataTable">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>File Name</th>
                                            <th>Uploaded By</th>
                                            <th>Uploaded Time</th>
                                            <th>Active</th>
                                            <th>Download</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @if(isset($fileInfoes) && count($fileInfoes) > 0)
                                            @foreach($fileInfoes as $file)

                                                    <tr id="{{$file->file_info_id}}">
                                                        <td> {{ $loop->iteration}} </td>
                                                        <td> {{$file->file_name}} </td>
                                                        <td> {{$file->employee['emp_name']}} </td>
                                                        <td> {{ date('Y-m-d',strtotime($file->insert_time)) }} </td>
                                                        <td> {{$file->active_yn == 'Y'?'Yes':'No'}} </td>

                                                        <td>
                                                            <a target="_blank" href="{{route('file.file-upload-download', [$file->file_info_id])}}"><i class="bx bx-download cursor-pointer"></i></a>
                                                        </td>
                                                        {{--  <td><a class="text-primary scheduledetailremove"><i
                                                                      class="bx bx-minus-circle cursor-pointer"></i></a></td>--}}


                                                    </tr>

                                            @endforeach
                                        @else
                                            <tr>
                                                <td id="emptyRow" colspan="5">
                                                    No data found
                                                </td>
                                            </tr>
                                        @endif

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
        function sellingProductList()
        {
            $('#tbl_file_upload').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{route('file.file-upload-datatable-list')}}',
                    'type': 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', "name": 'DT_RowIndex'},
                    {data: 'file_name'},
                    {data: 'emp_name'},
                    {data: 'insert_time'},
                    {data: 'active'},
                    {data: "action"},
                ]
            });
        }

        $(document).ready(function () {
            //sellingProductList();
            $(document).on("click","input[type='reset']", function(){
                // console.log('test');
                $( "#file_category_id" ).val(0).trigger('change.select2').select2({
                    placeholder: "Select One",
                });

                $('#file_from_date').attr('value','');
                $('#file_to_date').attr('value','');

            });

            $('#file_from_date,#file_to_date').datepicker({
                autoclose: true,
                todayHighlight: true,
                //minDate:new Date()
                //startDate: "now()"
                orientation: "bottom auto",
            });
        });
    </script>

@endsection

