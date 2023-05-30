<div id="status-show" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-uppercase text-left">
                    File Upload & Browse
                </h4>
                <button class="close" type="button" data-dismiss="modal" area-hidden="true">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- Table Start -->
                            <div class="card-body">
                                <h4 class="card-title">File Upload</h4>
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
                                                <select class="custom-select select2 form-control" required id="file_category_id" name="file_category_id">
                                                    <option value="">Select One</option>
                                                    @if(isset($fileCategories))
                                                        @foreach($fileCategories as $fileCategory)
                                                            <option value="{{$fileCategory->file_category_id}}">{{$fileCategory->file_category_name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="file_format_id" class="required">File Fromat</label>
                                                <select class="custom-select select2 form-control" required id="file_format_id" name="file_format_id">
                                                    <option value="">Select One</option>
                                                    @if(isset($fileFormats))
                                                        @foreach($fileFormats as $fileFormat)
                                                            <option value="{{$fileFormat->file_format_id}}">{{$fileFormat->file_format_name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="survey_software_id" >Survey Software</label>
                                                <select class="custom-select select2 form-control"  id="survey_software_id" name="survey_software_id">
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
                                                <input required type="file" class="form-control" id="upload_file" name="upload_file" />
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
                                @if(Session::has('message'))
                                    <div class="alert {{Session::get('m-class') ? Session::get('m-class') : 'alert-danger'}} show"
                                         role="alert">
                                        {{ Session::get('message') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                <form action="{{route('product.archive-search-post')}}" id="search-form" method="post" enctype="multipart/form-data">
                                    @csrf

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
            </div>
        </div>
    </div>
</div>
<style>
    .modal-body .table td, .modal-body .table th {
        padding: 7px;
        vertical-align: top;
    }
    .step-progressbar {
        list-style: none;
        counter-reset: step;
        display: flex;
        padding: 0;
    }
    .step-progressbar__item {
        display: flex;
        flex-direction: column;
        flex: 1;
        text-align: center;
        position: relative;
    }
    .step-progressbar__item:before {
        width: 3em;
        height: 3em;
        content: counter(step);
        counter-increment: step;
        align-self: center;
        background: #999;
        color: #fff;
        border-radius: 100%;
        line-height: 3em;
        margin-bottom: 0.5em;
    }
    .step-progressbar__item:after {
        height: 2px;
        width: calc(100% - 4em);
        content: "";
        background: #999;
        position: absolute;
        top: 1.5em;
        left: calc(50% + 2em);
    }
    .step-progressbar__item:last-child:after {
        content: none;
    }
    .step-progressbar__item--active:before {
        background: #000;
    }
    .step-progressbar__item--complete:before {
        content: "✔";
    }
</style>
