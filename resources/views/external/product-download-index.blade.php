@extends('layouts.external')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection
@section('content')


    <div class="row">
        <div class="col-12">

            @if(isset($product_orders))

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title">Product Download List</h4>
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
                                        <table id="tbl_product_completed_list" class="table table-sm table-bordered text-nowrap table-sm table-striped datatable mdl-data-table
                                    dataTable">
                                            <thead style="background: #bac0c7;">
                                            <tr>
                                                <th>SL</th>
                                                <th>Order Id</th>
                                                <th>Order Date</th>
                                                <th>Payment Date</th>
                                                <th style="text-align: center">Product Detail</th>

                                            </tr>
                                            </thead>
                                            <tbody>

                                            @if(isset($product_orders) && count($product_orders) > 0)

                                                @foreach($product_orders as $product_order)
                                                    <tr id="{{$product_order->product_order_id}}">

                                                        <td> {{$loop->iteration}} </td>
                                                        <td> {{$product_order->product_order_id}} </td>

                                                        <td> {{ date( 'Y-m-d' , strtotime($product_order->order_date) )}} </td>

                                                        <td> {{ date( 'Y-m-d' , strtotime($product_order->payment_completed_date) )}} </td>

                                                        <td>
                                                            <table class="table tblProductDetail table-hover">
                                                                <thead class="thead-light">
                                                                <th>Product Description</th>
                                                                <th>Format</th>
                                                                <th>File Name</th>
                                                                <th>Uploaded By</th>
                                                                <th>Download</th>

                                                                </thead>
                                                                <tbody>

                                                                @if(isset($product_order->product_order_details))

                                                                    @foreach($product_order->product_order_details as $product_order_detail)

                                                                        <tr id="{{$product_order_detail->product_order_detail_file_id}}">
                                                                            <td title="{{ $product_order_detail->description }}">
                                                                                {{substr($product_order_detail->description, 0, 15)}}
                                                                            </td>

                                                                            <td>
                                                                                {{$product_order_detail->file_format_name}}
                                                                            </td>


                                                                            <td title="{{ $product_order_detail->file_name }}">
                                                                                {{substr($product_order_detail->file_name, 0, 10)}}
                                                                            </td>
                                                                            <td>
                                                                                {{$product_order_detail->emp_name}}
                                                                            </td>

                                                                            <td>

                                                                                @if(isset($product_order_detail->file_info_id))
                                                                                    <a target="_blank"
                                                                                       href="{{route('external-user.product-download-order-detail-download', [$product_order_detail->file_info_id])}}">
                                                                                        Download
                                                                                    </a>
                                                                                @else
                                                                                <span title="No file to download">{{substr('No file to download', 0, 10)}}</span>
                                                                                @endif

                                                                            </td>

                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                                </tbody>
                                                            </table>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td id="emptyRow" colspan="5" style="text-align: center;">
                                                        No product to download
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

            @endif
        </div>
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">
        $(function () {
            $('#menu-product-download').addClass('active');
            $('#breadcrumb-header').html('Product Download');
            $('#breadcrumb-header').attr('href', "{{route('external-user.product-download-index')}}");
        });
    </script>
@endsection

