@extends('layouts.default')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection
@section('content')

{{--
    @json($product)
--}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Table Start -->
                <div class="card-body">
                    <h4 class="card-title">Product Setup</h4>
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
                    <form @if(isset($product->product_id)) action="{{route('setup.product-update',
                    [$product->product_id])}}"
                          @else action="{{route('setup.product-post')}}" @endif method="post" enctype="multipart/form-data">
                        @csrf
                        @if (isset($product->product_id))
                            @method('PUT')
                        @endif
                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="name" class="required">Product Name</label>
                                    <input required
                                           type="text"
                                           class="form-control"
                                           id="name"
                                           name="name"
                                           placeholder="Enter Product Name"
                                           value="{{old('name',isset($product->name) ? $product->name : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="name_bn">Product Name(Bangla)</label>
                                    <input type="text"
                                           class="form-control bn-lang-val-check"
                                           id="name_bn"
                                           name="name_bn"
                                           placeholder="Enter Product Name(Bangla)"
                                           value="{{old('name_bn',isset($product->name_bn) ? $product->name_bn : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>

                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="description" class="required">Description</label>

                                    <textarea required class="form-control"
                                              aria-label="Description"id="description"
                                              name="description"
                                              placeholder="Enter Product Description"

                                    >{{old('description',isset($product->description) ? $product->description : '')}}</textarea>
                                   {{-- <input required
                                           type="text"
                                           class="form-control"
                                           id="description"
                                           name="description"
                                           placeholder="Enter Product Description"
                                           value="{{old('description',isset($product->description) ? $product->description : '')}}"
                                    >--}}
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>



                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="delivery_area_type_id" class="required">File Category</label>
                                    <select class="custom-select select2 form-control" required id="file_category_id" name="file_category_id">
                                        <option value="">Select One</option>
                                        @if(isset($fileCategories))
                                            @foreach($fileCategories as $fileCategory)
                                                <option value="{{$fileCategory->file_category_id}}"
                                                        @if(isset($product->file_category_id) &&
                                                        ($product->file_category_id == $fileCategory->file_category_id))
                                                        selected
                                                    @endif
                                                >{{$fileCategory->file_category_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group " title="jpg/png, size Max 512 kb">
                                    <label for="ack_file">Uploaded Thumbnail</label>
                                    <input  type="file" class="form-control image-file" id="upload_file" name="upload_file" onchange="return fileValidation()"/>

                                </div>
                                @if(isset($product->file_info))
                                    <a href="{{ route('file.file-upload-download', [$product->file_info->file_info_id]) }}" target="_blank">{{$product->file_info->file_name}}</a>
                                @endif
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
                                                           @if($product && ($product->active_yn == \App\Enums\YesNoFlag::YES))
                                                           checked
                                                           @elseif(!$product)
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
                                                           @if($product && ($product->active_yn != \App\Enums\YesNoFlag::YES))
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

{{--                            <div class="form-group">--}}
{{--                                <button type="submit" class="btn btn-primary mr-1 mb-1">Save</button>--}}
{{--                                <input type="reset" class="btn btn-light-secondary mb-1" value="Reset" />--}}
{{--                            </div>--}}

                            @if($product['product_id'])
                                <button type="submit" class="btn btn btn-dark shadow mr-1 mb-1 btn-secondary">
                                    Update
                                </button>
                                <a href="{{route('setup.product-index') }}" class="btn btn-light-secondary mb-1" style="color:white">Cancel</a>

                            @else
                                <button type="submit" class="btn btn btn-dark shadow mr-1 mb-1 btn-secondary">
                                    Save
                                </button>
                                <input type="reset" class="btn btn-light-secondary mb-1" value="Reset" />
                            @endif

                        </div>
                    </form>
                </div>
                <!-- Table End -->
            </div>


           @include('setup.product-datatable-list')

        </div>
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">
        function productList()
        {
            $('#tbl_product').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{route('setup.product-datatable-list')}}',
                    'type': 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', "name": 'DT_RowIndex'},
                    {data: 'name'},
                    {data: 'file_category.file_category_name'},

                    {data: 'active'},
                    {data: "action"},
                ]
            });
        }

        $(document).ready(function () {
            productList();

            $(document).on("click","input[type='reset']", function(){
                // console.log('test');
                $( "#file_category_id" ).val(0).trigger('change.select2').select2({
                    placeholder: "Select One",
                });
            });

        });

        function fileValidation(){
            var fileInput = document.getElementById('upload_file');
            var filePath = fileInput.value;
            var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
            if(!allowedExtensions.exec(filePath)){
                alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');

                fileInput.value = '';

                return false;
            }

            $('#upload_file').change(function () {

                //because this is single file upload I use only first index
                var f = this.files[0]

                //here I CHECK if the FILE SIZE is bigger than 8 MB (numbers below are in bytes)
                if (f.size > 512000 || f.fileSize > 512000)
                {
                    //show an alert to the user
                    alert("Allowed file size exceeded. (Max. 512 kb)")

                    //reset file upload control
                    this.value = null;
                }
            })
        }

    </script>

@endsection

