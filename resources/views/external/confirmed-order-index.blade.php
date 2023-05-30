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
                {{--  @json($selling_requests)--}}


                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title">Confirmed Order</h4>
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
                                        <table id="tbl_product_completed_list" class="table table-sm datatable mdl-data-table
                                    dataTable">
                                            <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Order Id</th>
                                                {{--<th>Customer Name</th>--}}
                                                <th>Order Date</th>
                                                <th>Payment  Date</th>


{{--
                                                <th>Requested Qty</th>--}}
                                                <th>Product</th>
                                                <th>Payment Amount</th>

                                                <th>Status</th>
{{--
                                                <th>Action</th>
--}}
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @if(isset($product_orders) && count($product_orders) > 0)

                                                @foreach($product_orders as $product_order)
                                                    <tr id="{{$product_order->product_order_id}}">
                                                        <td> {{$loop->iteration}} </td>
                                                        <td> {{$product_order->product_order_id}} </td>
                                                        {{--<td> {{$product_order->customer->customer_name}} </td>--}}
                                                        <td> {{ date( 'Y-m-d' , strtotime($product_order->order_date) )}} </td>
                                                        <td> {{ date( 'Y-m-d' , strtotime($product_order->payment_completed_date) )}} </td>

{{--

                                                        <td>
                                                            {{count($product_order->product_order_detail)}}

                                                            --}}
{{--  @if(isset($product_order->product_order_detail) && count($product_order->product_order_detail) > 0)

                                                                  <a class="btn btn-success btn-xm" href="{{route('external-user.product-download-order-detail',$product_order->product_order_id)}}">
                                                                      {{count($product_order->product_order_detail)}} Format Requested
                                                                  </a>

                                                              @endif
  --}}{{--

                                                        </td>
--}}

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
                                                            <span class="badge badge-pill badge-primary">Payment success</span>
                                                        </td>


                                                       {{-- <td><button type="submit"
                                                                    class="btn btn-outline-info btn-xs btnNotify">
                                                                Notify
                                                            </button></td>
--}}
                                                    </tr>
                                                @endforeach
                                                @else

                                                    <tr>
                                                        <td colspan="6" style="text-align: center;">
                                                            No confirmed order
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
            $('#menu-confirmed-order-index').addClass('active');
            $('#breadcrumb-header').html('Confirmed Order');
            $('#breadcrumb-header').attr('href',"{{route('external-user.confirmed-order-index')}}");
        });
    </script>
@endsection

