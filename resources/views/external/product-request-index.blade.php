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
                            <h4 class="card-title">Submitted Product Order</h4>
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
                                            <th>Product Name</th>


                                            <th>Status</th>
                                 {{--           <th>Rejection Comment</th>
--}}
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
                                                    </td>



                                                    <td>

                                                        @if(isset($product_order->confirmed_yn) && $product_order->confirmed_yn == 'R')
                                                            <span class="badge badge-pill badge-danger">Rejected</span>

                                                            @else
                                                            <span class="badge badge-pill badge-warning">Submiited</span>
                                                            @endif


                                                    </td>

    {{--                                                <td> {{$product_order->rejection_comment}} </td>
--}}

                                                </tr>
                                            @endforeach

                                        @else

                                            <tr>
                                                <td colspan="5" style="text-align: center;">
                                                    No request submitted
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
        function sellingRequestList() {
            $('#tbl_selling_request').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{route('external-user.product-request-datatable-list')}}',
                    'type': 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                initComplete: function (settings, json) {
                    //console.log(json);
                },
                columns: [
                    {data: 'DT_RowIndex', "name": 'DT_RowIndex'},
                    {data: 'product_order_id'},
                    /*{data: 'file_format.file_format_name'},
                    {data: 'request_description'},
                    {data: 'product_qty'},*/
                    {data: 'price'},
                    /*{data: 'active'},
                     {data: "action"},*/
                ]
            });
        }

        $(document).ready(function () {
            //
            $('#menu-request-submitted').addClass('active');
            $('#breadcrumb-header').html('Request Submit');
            $('#breadcrumb-header').attr('href', "{{route('external-user.product-request-index')}}");

            /*
                        sellingRequestList();
                        var date = new Date();
                        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                        $('#tentative_delivery_date').datepicker({
                            autoclose: true,
                            todayHighlight: true,
                            //minDate:new Date()
                            startDate: "now()"
                        });

                        $('#selling_product_id').change(function () {
                           var selected_val = $(this).val();
                            console.log(selected_val);
                            var data = {};
                            data.selling_product_id= selected_val;
                            $.ajax({
                                type: "POST",
                                url: "{{ route('external-user.selling-product-by-id') }}",
                    data: data,
                    success: function (resp) {

                        var file_category_id = resp.file_category.file_category_id;
                        var product_description = resp.product_description;
                        var unit_price = resp.unit_price;

                        console.log(file_category_id +'->' + product_description );
                        $('#file_category_id').val(file_category_id).trigger('change');
                      //  $("#file_category_id").prop('disabled', true);

                        $('#product_description').val(product_description)
                        $('#unit_price').val(unit_price)
                    },
                    error: function (resp) {
                        alert('error');
                    }
                });


            });
*/
        });
    </script>

@endsection

