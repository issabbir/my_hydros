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
                    <h4 class="card-title">File Category Setup</h4>
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
                    <form @if(isset($fileCategory->file_category_id)) action="{{route('setup.file-category-update',
                    [$fileCategory->file_category_id])}}"
                          @else action="{{route('setup.file-category-post')}}" @endif method="post">
                        @csrf
                        @if (isset($fileCategory->file_category_id))
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="file_category_name" class="required">File Category Name</label>
                                    <input required
                                           type="text"
                                           class="form-control"
                                           id="file_category_name"
                                           name="file_category_name"
                                           placeholder="Enter File Category Name"
                                           value="{{old('file_category_name',isset($fileCategory->file_category_name) ? $fileCategory->file_category_name : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="file_category_name_bn" >File Category Name (Bangla)</label>
                                    <input
                                           type="text"
                                           class="form-control bn-lang-val-check"
                                           id="file_category_name_bn"
                                           name="file_category_name_bn"
                                           placeholder="Enter File Category Name (Bangla)"
                                           value="{{old('file_category_name_bn',isset($fileCategory->file_category_name_bn) ? $fileCategory->file_category_name_bn : '')}}"
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
                                                           @if($fileCategory && ($fileCategory->active_yn == \App\Enums\YesNoFlag::YES))
                                                           checked
                                                           @elseif(!$fileCategory)
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
                                                           @if($fileCategory && ($fileCategory->active_yn != \App\Enums\YesNoFlag::YES))
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


           @include('setup.file-category-datatable-list')


        </div>
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">
        function fileCategoryList()
        {
            $('#tbl_file_category').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{route('setup.file-category-datatable-list')}}',
                    'type': 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', "name": 'DT_RowIndex'},
                    {data: 'file_category_name'},
                    {data: 'active'},
                    {data: "action"},
                ]
            });
        }

        $(document).ready(function () {
            fileCategoryList();
        });
    </script>

@endsection

