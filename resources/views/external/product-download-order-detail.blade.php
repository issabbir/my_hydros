@extends('layouts.external')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection
@section('content')


    <div class="row">
        <div class="col-12">


            @if(isset($product_order_details))
                {{--@json($product_order_details)
--}}
                <div class="card">
                    <!-- Table Start -->
                    <div class="card-body">
                        <h4 class="card-title">Product Order File Download </h4>
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
                                        {{--
                                                                                <th>Action</th>
                                            --}}                                </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($product_order_details as $product_order_detail)
                                        <tr id="{{$product_order_detail->product_order_detail_id}}">
                                            <td> {{$product_order_detail->product_order_detail_id}} </td>
                                            <td> {{$product_order_detail->product_order_id}} </td>
                                            <td> {{$product_order_detail->product->name}} </td>
                                            <td> {{$product_order_detail->product->description}} </td>
                                            <td> {{$product_order_detail->file_format->file_format_name}} </td>
                                            <td>
                                                @if(count($product_order_detail->product_order_detail_file) > 0)

                                                    @foreach($product_order_detail->product_order_detail_files as $product_order_detail_file)
                                                       {{--@json($product_order_detail_file->file_info)--}}
                                                        <a target="_blank"
                                                           href="{{route('external-user.product-download-order-detail-download', [$product_order_detail_file->file_info_id])}}">
                                                            {{$loop->iteration}} .  {{$product_order_detail_file->file_info->file_name}}
                                                        </a>
                                                        <br>
                                                        {{--<hr>--}}
                                                    @endforeach
                                                @else
                                                    No file uploaded.Please contract hydrography department.
                                                @endif


                                            </td>
                                            {{--
                                                                                        <td>
                                                                                            <button type="submit"
                                                                                                    class="btn btn-outline-info btn-xs btnProductOrderUpload">
                                                                                                Upload
                                                                                            </button>
                                                                                        </td>--}}

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>

            @endif


        </div>
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">
        $(function () {
            $('#menu-product-download').addClass('active');
            $('#breadcrumb-header').attr('href',"{{route('external-user.product-download-index')}}");
        });
    </script>
@endsection

