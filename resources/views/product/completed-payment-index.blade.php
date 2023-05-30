@extends('layouts.default')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
    <style>
        .btnNotify {
            width: -webkit-fill-available;
        }
    </style>
@endsection
@section('content')


    <div class="row">
        <div class="col-12">

            @if(isset($product_orders))
                {{--  @json($product_orders)
--}}

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title">Completed Payment List</h4>
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
                                        <table id="tbl_product_completed_list" class="table table-striped table-sm datatable mdl-data-table
                                    dataTable ">
                                            <thead>
                                            <tr>
                                                <th>Order Id</th>
                                                <th>Customer Name</th>
                                                <th>Order Date</th>
                                                <th>Payment Date</th>
                                                                     <!--                            <th>Confirmed</th>
                                                                                                <th>Confirmation Date</th>
                                                                                                <th>Notified</th> -->

                                                <th>Approx. Delivery Date</th>
                                                {{--                                            <th>Description</th>
                                                --}}
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @if(isset($product_orders))

                                                @foreach($product_orders as $product_order)
                                                    <tr id="{{$product_order->product_order_id}}">
                                                        <td> {{$product_order->product_order_id}} </td>
                                                        <td>
                                                            {{$product_order->customer->customer_name}}
                                                            {{--<a class="customer-detail"
                                                               id="{{$product_order->customer->customer_id}}"
                                                               href="#">{{$product_order->customer->customer_name}}</a>--}}
                                                        </td>
                                                        <td> {{ date( 'Y-m-d' , strtotime($product_order->order_date) )}} </td>
                                                        <td> {{ date( 'Y-m-d' , strtotime($product_order->payment_completed_date) )}} </td>
                                                        {{--                                                    <td>
                                                                                                                <span class="confirmed">
                                                                                                                {{$product_order->confirmed_yn == 'Y'?'Yes':'No'}}
                                                                                                                </span>
                                                                                                            </td>
                                                                                                            <td class="confirmed_date">
                                                                                                                @if(isset($product_order->tentative_confirmation))
                                                                                                                    {{ date( 'Y-m-d' , strtotime($product_order->tentative_confirmation) )}}
                                                                                                                @endif
                                                                                                            </td>
                                                                                                            <td class="notified"> {{$product_order->notified_yn == 'Y'?'Yes':'No'}} </td>
                                                    --}}
                                                        {{--<td>
                                                            @if(isset($product_order->product_order_detail) && count($product_order->product_order_detail) > 0)

                                                                <a href="{{route('product.product-order-detail',$product_order->product_order_id)}}">
                                                                    {{count($product_order->product_order_detail)}}
                                                                    Format Requested
                                                                </a>

                                                            @endif

                                                        </td>--}}

                                                        <td>
                                                            <input placeholder="YYYY-MM-DD"
                                                                   type="text"
                                                                   class="form-control tentative-delivery"
                                                                   id="tentative_confirmation"
                                                                   name="tentative_confirmation"
                                                                   data-date-format="yyyy-mm-dd"
                                                                   @if(isset($product_order->tentative_confirmation))
                                                                   value="{{ date( 'Y-m-d' , strtotime($product_order->tentative_confirmation) )}}"
                                                                   disabled="disabled"
                                                                @endif
                                                            >
                                                        </td>

                                                        {{--                                                    <td>
                                                                                                                <input placeholder=""
                                                                                                                       type="text"
                                                                                                                       class="form-control description"
                                                                                                                       value="{{  $product_order->description }}"
                                                                                                                >
                                                                                                            </td>
                                                    --}}

                                                        <td>
                                                            @if(isset($product_order->tentative_confirmation))
                                                                <button type="submit" style="padding: 0px" class="btn btn-outline-info btn-xs btnNotify">ReNotify</button>
                                                            @else
                                                                <button type="submit" style="padding: 0px" class="btn btn-outline-warning btn-xs btnNotify">Notify</button>
                                                            @endif
                                                        </td>

                                                    </tr>
                                                @endforeach

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

    <!-- Modal -->
    <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Customer Details Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" id="product_order_id">
                            <div class="form-group">
                                <label for="file_category_name" class="required">Customer Name</label>
                                <input disabled
                                       type="text"
                                       class="form-control"
                                       id="customer_name"
                                       name="customer_name"
                                >
                                <small class="text-muted form-text"></small>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="file_category_name" class="required">Customer Organization</label>
                                <input disabled
                                       type="text"
                                       class="form-control"
                                       id="customer_organization"
                                       name="customer_organization"
                                >
                                <small class="text-muted form-text"></small>
                            </div>
                        </div>


                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="file_category_name" class="required">Customer Mobile</label>
                                <input disabled
                                       type="text"
                                       class="form-control"
                                       id="mobile_number"
                                       name="mobile_number"
                                >
                                <small class="text-muted form-text"></small>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="file_category_name" class="required">Customer Email</label>
                                <input disabled
                                       type="text"
                                       class="form-control"
                                       id="email"
                                       name="email"
                                >
                                <small class="text-muted form-text"></small>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="order_summary" class="required">Order Summary</label>
                                <input disabled
                                       type="text"
                                       class="form-control"
                                       id="order_summary"
                                       name="order_summary"
                                >
                                <small class="text-muted form-text"></small>
                            </div>
                        </div>


                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="tentative_confirmation" class="required">Confirmation Date</label>
                                <input placeholder="YYYY-MM-DD"
                                       type="text"
                                       class="form-control tentative-delivery"
                                       id="tentative_confirmation"
                                       name="tentative_confirmation"
                                       data-date-format="yyyy-mm-dd"
                                >
                                <small class="text-muted form-text"></small>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="description" class="required">Order Description</label>
                                <textarea class="form-control"
                                          aria-label="Description"
                                          id="description"
                                          name="description"
                                          placeholder="Enter Order Description"
 {{--                                         value="{{old('description',isset($product->description) ? $product->description : '')}}"
 --}}                               ></textarea>
                                <small class="text-muted form-text"></small>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="order-confirm" type="button" class="btn btn-primary" data-dismiss="modal">Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer-script')
    <script type="text/javascript">
        $(function () {

            $('.tentative-delivery').datepicker({
                autoclose: true,
                todayHighlight: true,
                //minDate:new Date()
                startDate: "now()",
                orientation: "bottom auto",
            });


            $('#order-confirm').click(function (e) {
                e.preventDefault();

                alertify.confirm('Confirm Order', 'Are you sure?',
                    function () {

                        var product_order_id = $('#product_order_id').val();
                        var tentative_confirmation = $('#tentative_confirmation').val();
                        var description = $('#description').val();


                        var detail = {};
                        detail.product_order_id = product_order_id;
                        detail.tentative_confirmation = tentative_confirmation;
                        detail.description = description;
                        //
                        detail.confirmed_yn = '{{\App\Enums\YesNoFlag::YES}}';

                        console.log(detail);
                        var url = '{{ route('product.product-confirm-notify') }}';

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: detail,
                            success: function (resp) {
                                console.log(resp);

                                if (resp.o_status_code == 1) {

                                    $('#tbl_product_completed_list tr').each(function () {
                                        var id = $(this).attr('id');

                                        if (id == product_order_id) {
                                            $(this).closest('tr').find('.confirmed').html('Yes');
                                            //var cur_date = '{{ date('Y-m-d') }}';
                                            $(this).closest('tr').find('.confirmed_date').html('<span>' + tentative_confirmation + '<span>');
                                        }
                                    });
                                    alertify.success(resp.o_status_message);
                                } else {
                                    alertify.error(resp.o_status_message);
                                }
                            },
                            error: function (resp) {
                                alert('error');
                            }
                        });


                    }
                    , function () {
                        alertify.error('Cancel')
                    }
                );

            })

            $(document).on("click", ".customer-detail", function () {

                var that = this;
                var product_order_id = $(that).closest('tr').attr('id');
                var customer_id = $(that).attr('id');
                console.log(customer_id);


                var url = '{{ route('customer_detail-with-order') }}';

                var detail = {};
                detail.customer_id = customer_id;
                detail.product_order_id = product_order_id;

                $.ajax({
                    type: "POST",
                    url: url,
                    data: detail,
                    success: function (resp) {


                        $('#customer_name').val(resp.customer.customer_name);
                        $('#customer_organization').val(resp.customer.customer_organization);
                        $('#mobile_number').val(resp.customer.mobile_number);
                        $('#email').val(resp.customer.email);

                        var product_order = resp.product_order;
                        var summary = '';
                        if (product_order != null || product_order != undefined) {
                            console.log(product_order);

                            $.each(product_order, function (index, order) {
                                summary = summary + order.name + '(' + order.file_format_name + ') , ';
                            });

                        } else {
                            summary = 'No order summary';
                        }
                        $('#order_summary').val(summary);

                        $('#product_order_id').val(product_order_id);
                        $('#basicExampleModal').modal({
                            show: true,
                            backdrop: 'static'
                        });


                        /* if (resp.o_status_code == 1) {
                             $(that).closest('tr').remove();
                             alertify.success(resp.o_status_message);
                         } else {
                             alertify.error(resp.o_status_message);
                         }*/
                    },
                    error: function (resp) {
                        alert('error');
                    }
                });

            });

            $(document).on("click", ".btnNotify", function () {

                var that = this;
                var product_order_id = $(that).closest('tr').attr('id');
                var tentative_confirmation = $(that).closest('tr').find('.tentative-delivery').val();

                if (tentative_confirmation == "" || tentative_confirmation == null) {
                    alertify.error('Must provide approx. delivery date');
                    return;
                }


                alertify.confirm('Confirm Notification', 'Are you sure?',
                    function () {



                        var detail = {};
                        detail.product_order_id = product_order_id;
                        detail.tentative_confirmation = tentative_confirmation;
                        detail.notified_yn = '{{\App\Enums\YesNoFlag::YES}}';
                        console.log(detail);

                        var url = '{{ route('product.product-confirm-notify') }}';
                        console.log(url);

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: detail,
                            success: function (resp) {
                                console.log(resp);

                                if (resp.o_status_code == 1) {


                                    $(that).closest('tr').find('.tentative-delivery').attr('disabled', 'disabled');
                                    $(that).closest('tr').find('.btn').html('ReNotify');

                                    alertify.success(resp.o_status_message);
                                } else {
                                    alertify.error(resp.o_status_message);
                                }
                            },
                            error: function (resp) {
                                alert('error');
                            }
                        });



                    }
                    , function () {
                        alertify.error('Cancel')
                    }
                );


            });

            $('#tbl_product_completed_list').DataTable({
                order: [],
                columnDefs: [ { orderable: false, targets: [0] } ]
            });

        });

    </script>

@endsection

