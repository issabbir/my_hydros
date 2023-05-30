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
                    <h4 class="card-title">File Archive</h4>
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
                          @else action="{{route('file.file-upload-post')}}" @endif method="post" enctype="multipart/form-data">
                        @csrf
                        @if (isset($fileInfo->file_info_id))
                            @method('PUT')
                        @endif
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
                                           value="{{old('file_title',isset($fileInfo->file_title) ? $fileInfo->file_title : '')}}"
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

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="file_format_id" class="required">File Fromat</label>
                                    <select class="custom-select select2 form-control" required id="file_format_id" name="file_format_id">
                                        <option value="">Select One</option>
                                        @if(isset($fileFormats))
                                            @foreach($fileFormats as $fileFormat)
                                                <option value="{{$fileFormat->file_format_id}}"
                                                        @if(isset($fileInfo->file_format_id) &&
                                                        ($fileInfo->file_format_id == $fileFormat->file_format_id))
                                                        selected
                                                    @endif
                                                >{{$fileFormat->file_format_name}}</option>
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
                                    <label for="ack_file" class="@if(!isset($ack->upload_file) || !$ack->upload_file) required @endif">Uploaded File</label>
                                    <input @if(!isset($ack->upload_file) || !$ack->upload_file) required @endif type="file" class="form-control" id="upload_file" name="upload_file" />
                                </div>
                                <div class="alert alert-danger border" role="alert">
                                    * Maximum File Upload Limit 2 MB
                                </div>
                                {{--@if(isset($ack->ack_file))
                                    <a href="{{ route('water-acknowledgement-file-download', [$ack->ack_id]) }}" target="_blank">{{$ack->ack_file_name}}</a>
                                @endif--}}
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
                                                           @if($fileInfo && ($fileInfo->active_yn == \App\Enums\YesNoFlag::YES))
                                                           checked
                                                           @elseif(!$fileInfo)
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
                                                           @if($fileInfo && ($fileInfo->active_yn != \App\Enums\YesNoFlag::YES))
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
                                <button type="submit" class="btn btn-primary mr-1 mb-1">Upload</button>
                                <input type="reset" class="btn btn-light-secondary mb-1" value="Reset"/>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Table End -->
            </div>


           @include('file.file-upload-datatable-list')

        </div>
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">
        $("input[type='file']").on("change", function () {
            if(this.files[0].size > 2000000) {
                alert("Please upload file less than 2MB. Thanks!!");
                $(this).val('');
            }
        });
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
            sellingProductList();

            $(document).on("click","input[type='reset']", function(){
                // console.log('test');
                $( "#file_category_id" ).val(0).trigger('change.select2').select2({
                    placeholder: "Select One",
                });

                $( "#file_format_id" ).val(0).trigger('change.select2').select2({
                    placeholder: "Select One",
                });

                $( "#survey_software_id" ).val(0).trigger('change.select2').select2({
                    placeholder: "Select One",
                });

            });


        });
    </script>

@endsection

