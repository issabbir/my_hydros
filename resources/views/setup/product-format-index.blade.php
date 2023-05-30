@extends('layouts.default')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection
@section('content')
    {{--@json($teams)--}}
    <form @if(isset($product_detail->product_detail_id)) action="{{route('setup.product-format-update',
                    [$product_detail->product_detail_id])}}"
          @else action="{{route('setup.product-format-post')}}" @endif method="post">
        @csrf
        @if (isset($product_detail->product_detail_id))
            @method('PUT')
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Product Format Setup</h4>
                        <hr>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="team_id" class="required">Product </label>
                                <select class="custom-select select2 form-control" required id="product_id" name="product_id">
                                    <option value="">Select One</option>
                                    @if(isset($products))
                                        @foreach($products as $p)
                                            <option value="{{$p->product_id}}"
                                                    @if(isset($product->product_id) &&
                                                    ($product->product_id == $p->product_id))
                                                    selected
                                                @endif
                                            >{{$p->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- Table Start -->
                    <div class="card-body">
                        <h4 class="card-title">Format Setup </h4>
                        <hr>
                        @if(Session::has('message'))
                            <div
                                class="alert {{Session::get('m-class') ? Session::get('m-class') : 'alert-danger'}} show"
                                role="alert">
                                {{ Session::get('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="file_format_id" class="required">File Format</label>
                                    <select class="custom-select select2 form-control" required id="file_format_id"
                                            name="file_format_id">
                                        <option value="">Select One</option>
                                        @if(isset($file_formats))
                                            @foreach($file_formats as $file_format)
                                                <option value="{{$file_format->file_format_id}}"
                                                        @if(isset($product_detail->file_format_id) &&
                                                        ($product_detail->file_format_id == $file_format->file_format_id))
                                                        selected
                                                    @endif
                                                >{{$file_format->file_format_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4" style="display: none">
                                <div class="form-group">
                                    <label for="price" class="required">Unit Price</label>
                                    <input required
                                           type="number"
                                           class="form-control"
                                           id="price"
                                           name="price"
                                           placeholder="Enter Unit Price"
                                           value="{{old('price',isset($product_detail->price) ? $product_detail->price : '1')}}"
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
                                                           @if($product_detail && ($product_detail->active_yn == \App\Enums\YesNoFlag::YES))
                                                           checked
                                                           @elseif(!$product_detail)
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
                                                           @if($product_detail && ($product_detail->active_yn != \App\Enums\YesNoFlag::YES))
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

                    </div>
                    <!-- Table End -->
                </div>


            </div>

        </div>

    </form>
    @include('setup.product-format-datatable-list')


@endsection

@section('footer-script')
    <script type="text/javascript">
        function productDetailList(url) {
            if ($.fn.DataTable.isDataTable('#tbl_product_detail')) {
                $('#tbl_product_detail').DataTable().destroy();
            }
            $('#tbl_product_detail tbody').empty();

            $('#tbl_product_detail').DataTable({
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

                    {data: 'product.name'},
                    {data: 'file_format.file_format_name'},
                    /*{data: 'price'},*/
                    {data: 'active'},
                    {data: "action"},
                ]
            });
        }

        $(document).ready(function () {

            $(document).on("click","input[type='reset']", function(){

                $( "#file_format_id" ).val(0).trigger('change.select2').select2({
                    placeholder: "Select One",
                });
            });



            $('#designation_id').change(function () {
                var id = $(this).val();
                console.log(id);

                if (id == "" || id == undefined) {
                    alertify.alert('Designation', 'Must select a designation!');
                    return;
                }

                var url = '{{route('setup.employee-by-designation')}}';
                console.log(url);

                $.ajax({
                    /* the route pointing to the post function */
                    url: url,
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: '{{ csrf_token() }}', id: id},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        console.log(data);

                        $("#emp_id").select2({
                            placeholder: "Select a employee",
                            data: data
                        });

                    }
                });
            });

            var current_product_id = $('#product_id').val();
            if (current_product_id == "" || current_product_id == undefined) {

            }else{
                loadProductWiseProductDetail();
            }


            $('#product_id').change(function () {
                loadProductWiseProductDetail();
            });

            function loadProductWiseProductDetail() {
                var product_id = $('#product_id').val();
                console.log(product_id);
                if (product_id == "" || product_id == undefined) {
                    alertify.alert('Product','Must select a product!');
                } else {
                    var url = '{{route('setup.product-format-datatable-list')}}' + "?id=" + product_id;
                    console.log(url);
                    productDetailList(url);
                }
            }


        });
    </script>

@endsection

