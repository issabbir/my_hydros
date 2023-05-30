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
                    @if(Session::has('message'))
                        <div class="alert {{Session::get('m-class') ? Session::get('m-class') : 'alert-danger'}} show"
                             role="alert">
                            {{ Session::get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <h4 class="card-title">Product Order Summary</h4>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="schedule_name" class="required">Order Id</label>
                                <input disabled
                                       type="text"
                                       class="form-control"
                                       id="product_order_id"
                                       name="product_order_id"
                                       placeholder="Enter product order id"
                                       value="{{old('product_order_id',isset($product_order->product_order_id) ? $product_order->product_order_id : '')}}"
                                >
                                <small class="text-muted form-text"></small>
                            </div>
                        </div>


                        {{--
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="schedule_from_date" class="required">Tentative Delivery Date</label>
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
                                                                   ($product_order->tentative_confirmation) ?
                                                                   date('Y-m-d',strtotime($product_order->tentative_confirmation)) : '')}}"/>
                                                        <small class="text-muted form-text"> </small>
                                                    </div>
                                                </div>

                                                <div class="col-sm-8">
                                                    <div class="form-group">
                                                        <label for="description" class="required">Order Description</label>
                                                        <input disabled class="form-control"
                                                                  aria-label="Description"
                                                                  id="description"
                                                                  name="description"
                                                                  placeholder="Enter Order Description"
                                                                  value="{{old('description',isset($product_order->description) ? $product_order->description : '')}}"
                                                        />                                <small class="text-muted form-text"></small>
                                                    </div>
                                                </div>--}}


                    </div>

                    <div class="col-md-12 pr-0 d-flex justify-content-end">
                        <div class="form-group">
                            <button onclick="$('#file_upload').toggle('slow')" id="upload_files" type="submit" class="btn btn-primary mr-1 mb-1">Upload Files
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Table End -->
            </div>
        </div>
    </div>

    <div class="row" id="file_upload">
        <div class="col-md-12">
            <div class="card">
                <!-- Table Start -->
                <div class="card-body">
                    <h4 class="card-title">File Upload</h4>
                    <hr>
                    {{--@if(Session::has('message'))
                        <div class="alert {{Session::get('m-class') ? Session::get('m-class') : 'alert-danger'}} show"
                             role="alert">
                            {{ Session::get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif--}}
                    <form action="{{route('product.file-upload-post')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="file_title" class="required">File Title</label>
                                    <input required
                                           type="text"
                                           class="form-control"
                                           id="file_title"
                                           name="file_title"
                                           placeholder="Enter File Title"
                                           value="{{old('file_title')}}"
                                    >
                                    <input type="hidden"
                                           id="product_order_id"
                                           name="product_order_id"
                                           value="{{old('product_order_id',isset($product_order->product_order_id) ? $product_order->product_order_id : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="delivery_area_type_id" class="required">File Category</label>
                                    <select class="custom-select select2 form-control" required id="file_category_id"
                                            name="file_category_id">
                                        <option value="">Select One</option>
                                        @if(isset($fileCategories))
                                            @foreach($fileCategories as $fileCategory)
                                                <option
                                                    value="{{$fileCategory->file_category_id}}">{{$fileCategory->file_category_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="file_format_id" class="required">File Fromat</label>
                                    <select class="custom-select select2 form-control" required id="file_format_id"
                                            name="file_format_id">
                                        <option value="">Select One</option>
                                        @if(isset($fileFormats))
                                            @foreach($fileFormats as $fileFormat)
                                                <option
                                                    value="{{$fileFormat->file_format_id}}">{{$fileFormat->file_format_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="survey_software_id">Survey Software</label>
                                    <select class="custom-select select2 form-control" id="survey_software_id"
                                            name="survey_software_id">
                                        <option value="">Select One</option>
                                        @if(isset($surveySoftwares))
                                            @foreach($surveySoftwares as $surveySoftware)
                                                <option value="{{$surveySoftware->survey_software_id}}"
                                                        @if(isset($fileInfo->survey_software_id) &&
                                                        ($fileInfo->survey_software_id == $surveySoftware->survey_software_id))
                                                        selected
                                                    @endif
                                                >{{$surveySoftware->survey_software_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="ack_file" class="required">Uploaded File</label>
                                    <input required type="file" class="form-control" id="upload_file"
                                           name="upload_file"/>
                                </div>
                                <div class="alert alert-danger border" role="alert">
                                    * Maximum File Upload Limit 2 MB
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
                                                           value="{{\App\Enums\YesNoFlag::YES}}" checked
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
                                <button type="submit" class="btn btn-primary mr-1 mb-1">Upload</button>
                                <input type="reset" class="btn btn-light-secondary mb-1" value="Reset"/>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Table End -->

            </div>

            <div class="card">
                <!-- Table Start -->
                <div class="card-body">
                    <h4 class="card-title">File Search</h4>
                    <hr>
                    {{--@if(Session::has('message'))
                        <div class="alert {{Session::get('m-class') ? Session::get('m-class') : 'alert-danger'}} show"
                             role="alert">
                            {{ Session::get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif--}}
                    <form {{--action="{{route('product.archive-search-post')}}"--}} id="search-form" method="post"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="name">File Name</label>
                                    <input
                                        type="text"
                                        autocomplete="off"
                                        class="form-control"
                                        id="file_name"
                                        name="file_name"
                                        placeholder="Enter File Name"
                                    >
                                    <input type="hidden" id="product_order_id" name="product_order_id"
                                           value="{{$product_order_id}}">
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>


                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="delivery_area_type_id" class="required">File Category</label>
                                    <select class="custom-select select2 form-control" id="file_category_id"
                                            name="file_category_id">
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
                                    <label for="delivery_area_type_id" class="required">Product</label>
                                    <select class="custom-select select2 form-control" id="product_id"
                                            name="product_id">
                                        <option value="">Select One</option>
                                        @if(isset($product_order_details))
                                            @foreach($product_order_details as $product)
                                                <option value="{{$product->product_order_detail_id}}">{{$product->product_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-2">
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


                            <div class="col-sm-2">
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
                            <hr>
                            <div class="row">
                                <div class="col" id="final-selection-message"></div>
                            </div>
                            <div class="card-content">
                                <form method="post" name="final-results-form" id="final-results-form" onsubmit="return chkTable()">
                                    {{csrf_field()}}
                                    <div class="table-responsive">
                                        <table id="tbl_file" class="table table-sm datatable mdl-data-table dataTable">
                                            <thead>
                                            <tr>
                                                <th>Select File</th>
                                                <th>File Name</th>
                                                <th>Uploaded By</th>
                                                <th>Uploaded Time</th>
                                                <th>Active</th>
                                            </tr>
                                            </thead>
                                            <tbody id="comp_body"></tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-end mt-2">
                                        <button type="submit" class="btn btn btn-dark shadow btn-secondary"
                                                name="file_server_upload" id="file_server_upload">Upload Files
                                        </button>&nbsp;
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            @if(isset($product_order_details))
                {{--@json($product_order_details)--}}
                {{--@json($product_order_detail_id)--}}
                <div class="card">
                    <!-- Table Start -->
                    <div class="card-body">
                        <h4 class="card-title">Product Order Detail </h4>
                        <hr>
                        {{--@if(Session::has('message'))
                            <div
                                class="alert {{Session::get('m-class') ? Session::get('m-class') : 'alert-danger'}} show"
                                role="alert">
                                {{ Session::get('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif--}}
                        <div class="card-content">
                            <div class="table-responsive">
                                <table id="tbl_product_upload"
                                       class="table table-sm datatable mdl-data-table dataTable">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Product Order Id</th>
                                        <th>Product Name</th>
                                        <th>Product Description</th>
                                        <th>File Format</th>
                                        <th>No. Of Uploaded File</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($product_order_details as $product_order_detail)
                                        <tr id="{{$product_order_detail->product_order_detail_id}}"
                                            file_mime_type="{{$product_order_detail->file_format->file_mime_type}}">
                                            <td> {{$product_order_detail->product_order_detail_id}} </td>
                                            <td> {{$product_order_detail->product_order_id}} </td>
                                            <td>
                                                @if(isset($product_order_detail->product))
                                                    <span
                                                        class="product-name">{{$product_order_detail->product->name}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($product_order_detail->product))
                                                    {{$product_order_detail->product->description}}

                                                @endif

                                            </td>
                                            <td>
                                                @if($product_order_detail->file_format)
                                                    <span class="file-format-name">
                                                    {{$product_order_detail->file_format->file_format_name}}
                                                </span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ count($product_order_detail->product_order_detail_file)}}
                                            </td>
                                            <td>
                                                <button type="submit"
                                                        class="btn btn-outline-info btn-xs btnProductOrderUpload">
                                                    Uploaded Files
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="card" id="upload-div">
                <!-- Table Start -->
            {{--<div class="card-body">
                <h4 class="card-title">File Upload for <span id="product"></span>
                </h4>
                <h4 class="card-title">
                    Preferred format: <span
                        id="file-format"></span>

                    <input type="hidden" id="hidden-file-mime-type" value="">
                </h4>
                <hr>

                <form method="post"
                      enctype="multipart/form-data"
                      action="{{route('product.product-order-detail-post',$product_order_id)}}">

                    <div class="row">
                        <input type="hidden" id="product_order_id" name="product_order_id"
                               value="{{$product_order_id}}">
                        <input type="hidden" id="product_order_detail_id" name="product_order_detail_id">
                    </div>

                    <div class="row">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="upload_file"
                                       class="required">Uploaded
                                    File</label>
                                <input  type="file" class="form-control upload_file" id="upload_file"
                                        name="upload_file"/>
                            </div>
                        </div>

                        <div class="col-sm-4 hidden">
                            <div class="form-group">
                                <label for="active_yn" class="required">Active?</label>
                                <ul class="list-unstyled mb-0">
                                    <li class="d-inline-block mr-2 mb-1">
                                        <fieldset>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio"
                                                       name="active_yn"
                                                       id="active_yes"
                                                       value="{{\App\Enums\YesNoFlag::YES}}"
                                                       checked
                                                />
                                                <label class="custom-control-label" for="active_yes">
                                                    Yes </label>
                                            </div>
                                        </fieldset>
                                    </li>
                                    <li class="d-inline-block mr-2 mb-1">
                                        <fieldset>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio"
                                                       name="active_yn"
                                                       id="active_no"
                                                       value="{{\App\Enums\YesNoFlag::NO}}"
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
                            <button type="submit" class="btn btn-primary mr-1 mb-1">Upload</button>
                            <input id="upload-close" type="reset" class="btn btn-light-secondary mb-1"
                                   value="Close"/>
                        </div>
                    </div>
                </form>
            </div>--}}

            <!-- Table End -->
            </div>
                @include('product.product-upload-order-datatable-list')
        </div>
    </div>
@endsection

@section('footer-script')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $("input[type='file']").on("change", function () {
            if(this.files[0].size > 2000000) {
                alert("Please upload file less than 2MB. Thanks!!");
                $(this).val('');
            }
        });
        function chkTable() {
            if ($('#comp_body tr').length === 0) {
                Swal.fire({
                    title: 'Please select File!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return false;
            }else {
                return true;
            }
        }

        $('#upload_files').click(function () {
            $('#file_upload').show();
        });

        function getdatatable() {
            var oTable = $('#tbl_file').DataTable({
                processing: true,
                serverSide: true,
                bDestroy: true,
                pageLength: 20,
                bFilter: true,
                lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'All']],
                ajax: {
                    url: '{{route('product.file-upload-datatable-list')}}',
                    async: false,
                    'type': 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function (d) {
                        d.file_name = $('#file_name').val();
                        d.file_category_id = $('#file_category_id').val();
                        d.file_from_date = $('#file_from_date').val();
                        d.file_to_date = $('#file_to_date').val();
                        d.product_id = $('#product_id').val();
                    }
                },
                "columns": [
                    {data: 'selected'},
                    {data: 'file_name'},
                    {data: 'emp_name'},
                    {data: 'insert_time'},
                    {data: 'active'},
                ]
            });
            oTable.draw();
        }

        $(function () {
            $('#final-results-form').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: "{{route('product.multi-product-order-detail-post')}}",
                    data: $(this).serialize(),
                    success: function (data) {
                        $('#final-selection-message').html(data.html);
                    },
                    error: function (data) {
                        alert('error');
                    }
                });
            });

            $('#file_from_date,#file_to_date').datepicker({
                autoclose: true,
                todayHighlight: true,
                //minDate:new Date()
                //startDate: "now()"
                orientation: "bottom auto",
            });

            $('#search-form').on('submit', function (e) {
                e.preventDefault();
                getdatatable();
            });


            //$('#upload-div').hide();
            $('#file_upload').hide();
            var product_order_detail_id = '{{$product_order_detail_id}}';
            console.log(product_order_detail_id);
            if (product_order_detail_id == null || product_order_detail_id == undefined) {
                //$('#upload-div').hide();
            } else {
                $('#product_order_detail_id').val(product_order_detail_id);
                fileUploadList(product_order_detail_id);
                $('#tbl_product_upload tr').each(function () {
                    var id = $(this).attr('id');

                    if (id == product_order_detail_id) {
                        $(this).addClass('alert');
                        $(this).addClass('alert-dark');
                    }
                });
            }

            $('#upload-close').click(function () {
                $('#tbl_product_upload tr').each(function () {
                    $(this).removeClass('alert');
                    $(this).removeClass('alert-dark');
                });
                //$('#upload-div').hide();

            });

            function fileUploadList(product_order_detail_id) {


                if ($.fn.DataTable.isDataTable('#tbl_file_upload')) {
                    $('#tbl_file_upload').DataTable().destroy();
                }
                $('#tbl_file_upload tbody').empty();

                var url = '{{ route('product.product-order-detail-datatable-list') }}' + "?id=" + product_order_detail_id;
                console.log(url);

                $('#tbl_file_upload').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: url,
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
                        /*  {data: 'active'},*/
                        {data: "action"},
                        /*  {data: "delete"},*/
                    ]
                });


            }

            $(document).on("click", ".btnProductOrderUpload", function () {

                //$('#upload-div').show();
                var that = this;

                $('#tbl_product_upload tr').each(function () {
                    //processing this row
                    //how to process each cell(table td) where there is checkbox
                    //console.log($(this).attr('id'))
                    $(this).removeClass('alert');
                    $(this).removeClass('alert-dark');
                });

                $(that).closest('tr').addClass('alert');
                $(that).closest('tr').addClass('alert-dark');
                var product_order_detail_id = $(that).closest('tr').attr('id');
                //  var product_order_id = '{{$product_order_id}}'

                $('#product_order_detail_id').val(product_order_detail_id);
                fileUploadList(product_order_detail_id);


                var product_name = $.trim($(that).closest('tr').find('.product-name').html());
                var file_format_name = $.trim($(that).closest('tr').find('.file-format-name').html());
                var file_mime_type = $.trim($(that).closest('tr').attr('file_mime_type'));

                $('#product').html(product_name);
                $('#file-format').html(file_format_name);
                $('#hidden-file-mime-type').val(file_mime_type);

                //console.log(file_format_name);


            });

            //$('#tbl_product_completed_list').DataTable();

            //upload_file
            $(document.body).on('change', ".upload_file", function (e) {
                var file = this;
                var filePath = file.value;
                var fileType = $(this).prop('files')[0].type;
                var errorMsgFileType = 'Please upload a ' + $('#file-format').html() + ' file';
                // var allowedExtensions = /(\.pdf|\.jpg|\.jpeg|\.jfif|\.bmp|\.png|\.doc|\.docx|\.xls|\.xlsx)$/i;


                var required_file_type = $('#hidden-file-mime-type').val();
                // console.log(required_file_type);

                if (required_file_type != fileType) {
                    alertify.error(errorMsgFileType);
                    $(file).val('');

                }


            });


        });

    </script>

@endsection

