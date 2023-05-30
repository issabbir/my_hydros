@extends('layouts.external')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection
@section('content')

    <div class="row">
        <div class="col-12">

            {{--@json($product_orders)--}}
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">List for Payment</h4>
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
                                    <table id="tbl_customer_list" class="table table-sm datatable mdl-data-table
                                    dataTable">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Order Id</th>
                                            <th>Order Date</th>
                                            <th> Product Name</th>
                                            <th> Order Detail</th>
                                            <th>Confirmation Date</th>
                                            <th>Confirm By</th>
                                            <th>Total Amount</th>

                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @if(isset($product_orders) && count($product_orders)> 0)

                                            @foreach($product_orders as $product_order)
                                                <tr id="{{$product_order->product_order_id}}">
                                                    <td> {{$loop->iteration}} </td>
                                                    <td> {{$product_order->product_order_id}} </td>
                                                    <td>
                                                        {{date('Y-m-d',strtotime($product_order->order_date))}}

                                                    </td>
                                                    <td>

                                                        @if(isset($product_order->product_order_details) && count($product_order->product_order_details))
                                                            <div style="display: none">
                                                                {{ $p_name = "" }}
                                                                @foreach($product_order->product_order_details as $details)
                                                                    {{$p_name  = $p_name . $details->product->name}}

                                                                    @if($loop->iteration !=count($product_order->product_order_details))
                                                                        {{$p_name = $p_name . " , "}}
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                            {{$p_name}}

                                                        @endif

                                                        {{--    @json($product_order->product_order_details[0]->product->name)--}}
                                                    </td>

                                                    <td style="padding: 0px;">
                                                        <table class="table table-bordered tblProductDetail">
                                                            <thead>
                                                            <th>Product Name</th>
                                                            <th>Requested Format</th>
                                                            <th>From Date</th>
                                                            <th>To Date</th>
                                                            <th>Price</th>

                                                            </thead>
                                                            <tbody>
                                                            @if(isset($product_order->product_order_detail ))
                                                            @foreach($product_order->product_order_detail as $product_order_detail)

                                                                <tr id="{{$product_order_detail->product_order_detail_id}}">


                                                                    <td>

                                                                        @if(isset($product_order_detail->product))
                                                                            {{$product_order_detail->product->name}}
                                                                        @endif

                                                                    </td>
                                                                    <td>
                                                                        @if(isset($product_order_detail->file_format))

                                                                            {{$product_order_detail->file_format->file_format_name}}
                                                                        @endif

                                                                    </td>
                                                                    <td style="white-space: nowrap;">

                                                                        {{ date( 'Y-m-d' , strtotime($product_order_detail->from_date) )}}
                                                                    </td>
                                                                    <td style="white-space: nowrap;">

                                                                        {{ date( 'Y-m-d' , strtotime($product_order_detail->to_date) )}}


                                                                    </td>
                                                                    <td>
                                                                        <input disabled autocomplete="off" type="number"
                                                                               name="price"
                                                                               class="form-control product-detail-price"
                                                                               value="{{$product_order_detail->price}}"
                                                                            {{-- @if(isset($product_order_detail->price))
                                                                             disabled
                                                                          @endif--}}
                                                                        >
                                                                    </td>

                                                                    {{--<td>
                                                                        <a class="text-primary approve-price"
                                                                           onclick=""><i
                                                                                class="bx bx-check-circle
                                                     cursor-pointer"></i>&nbsp;</a>
                                                                        --}}{{-- <a class="text-primary reject-price" onclick=""><i
                                                                                 class="bx
                                                          bx-minus-circle cursor-pointer"></i></a>--}}{{--
                                                                    </td>--}}


                                                                </tr>
                                                            @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </td>

                                                    <td>

                                                        {{date('Y-m-d',strtotime($product_order->confirmed_date))}}

                                                    </td>

                                                    <td> @if(isset($product_order->employee))
                                                            {{$product_order->employee->emp_name}}
                                                        @endif
                                                    </td>

                                                    {{-- <td>
                                                        <span class="badge badge-pill badge-success">Success</span>
                                                    </td> --}}

                                                    <td>
                                                        <div style="display: none">
                                                            {{ $total = 0 }}
                                                        </div>
                                                        @foreach($product_order->product_order_detail as $device)

                                                            <div
                                                                style="display: none">{{$total += $device->price}}</div>

                                                        @endforeach
                                                        {{$total}} BDT
                                                    </td>
                                                    <td>

                                                        <form class=""
                                                              action="{{ route('external-user.goto-payment-gateway',[$product_order->product_order_id]) }}"
                                                              method="post">
                                                            {{--<input id="" name="" type="hidden" value="">--}}
                                                            <button type="submit"
                                                                    class="btn btn-icon btn-success btn-xm btnPaymentIndex">
                                                                Payment
                                                            </button>

                                                            {{-- <button> <span id="pay_msg" title="Payment"><i class="fas fa-money-check-alt" style="font-size: 30px;color: #00FF00";></i></span></button>
        --}}
                                                        </form>

                                                        {{--<a class="text-primary approvebutton"  onclick="" href="#"><i
                                                                    class="bx
                                                        bx-check-circle
                                                         cursor-pointer"></i>&nbsp;|</a>
                                                        <a class="text-primary rejectbutton"  onclick=""><i class="bx
                                                         bx-minus-circle cursor-pointer"></i></a>
        --}}
                                                    </td>

                                                </tr>
                                            @endforeach

                                        @else

                                            <tr>
                                                <td colspan="9" style="text-align: center;">
                                                    No approved product request
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

        //tbl_customer_list
        $(function () {

            $('#menu-approval-status').addClass('active');
            $('#breadcrumb-header').html('Approved Request Index');
            $('#breadcrumb-header').attr('href', "{{route('external-user.approved-request-index')}}");

        });

    </script>

@endsection

