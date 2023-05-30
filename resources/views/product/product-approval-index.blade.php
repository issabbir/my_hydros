@extends('layouts.default')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection
@section('content')
    <div class="row">
        <div class="col-12">

            {{--@json($product_orders)
            --}}
            <div class="card">
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
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">Purchase request Pricing</h4>
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table id="tbl_customer_list" class="table table-sm datatable mdl-data-table
                                    dataTable">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Order Id</th>
                                            <th>Order Date</th>
                                            <th>Customer Name</th>
                                            <th>Items</th>
                                            <th style="text-align: center">Order Detail</th>
                                            <th style="text-align: center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {{--@php
                                            $getKey = json_encode(Auth::user()->roles->pluck('role_key'));
                                            $getKey = json_decode($getKey, true);
                                        @endphp--}}
                                        {{--{{dd($product_orders)}}--}}
                                        @if(isset($product_orders) && count($product_orders)> 0)
                                            @foreach($product_orders as $product_order)
                                                {{--@if(in_array($product_order->user_role, $getKey))--}}
                                                <tr id="{{$product_order->product_order_id}}">
                                                    <td> {{$loop->iteration}} </td>
                                                    <td> {{$product_order->product_order_id}} </td>
                                                    <td style="white-space: nowrap;"> {{ date( 'Y-m-d' , strtotime($product_order->order_date) )}}
                                                    </td>
                                                    <td>
                                                        <a id="{{$product_order->customer->customer_id}}"
                                                           class="customer-detail">
                                                            {{$product_order->customer->customer_name}}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {{count($product_order->product_order_detail)}}
                                                    </td>
                                                    <td style="padding: 0px;">
                                                        <table class="table table-bordered tblProductDetail">
                                                            <thead>
                                                            <th>Product Name</th>
                                                            <th>Requested Format</th>
                                                            <th>From Date</th>
                                                            <th>To Date</th>
                                                            <th>Qty</th>

                                                            </thead>
                                                            <tbody>
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
                                                                    <td style="white-space: nowrap;">

                                                                        {{$product_order_detail->qty}}

                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    <td>

                                                        <div class="btn-group" style="margin-top: 26px;">
                                                            <button id="{{$product_order->product_order_id}}"
                                                                    type="button"
                                                                    class="btn btn-success btn-sm btnConfirmOrder">
                                                                Confirm
                                                            </button>
                                                            <button id="{{$product_order->product_order_id}}"
                                                                    type="button"
                                                                    class="btn btn-danger btn-sm btnRejectOrder">
                                                                Reject
                                                            </button>

                                                        </div>


                                                    </td>
                                                </tr>
                                                {{--@endif--}}
                                            @endforeach

                                        @else

                                            <tr>
                                                <td id="emplyRow" colspan="7" style="text-align: center;">
                                                    No purchase request
                                                </td>
                                            </tr>
                                        @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('approval.workflowmodal')

                </div>
            </div>


        </div>
    </div>

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

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <button id="order-confirm" type="button" class="btn btn-primary" data-dismiss="modal">Confirm
                     </button>--}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">
        var userRoles = '@php echo json_encode(Auth::user()->roles->pluck('role_key')); @endphp';
        //tbl_customer_list
        $(function () {
            // $('#tbl_customer_list').DataTable();

            var order_id = '{{request()->get('id')}}';

            if (order_id) {
                approval(order_id);
            }

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

            $(document).on("click", ".approve-price", function () {
                var product_order_detail_id = $(this).closest('tr').attr('id');

                var price_text_box = $(this).closest('tr').find('.product-detail-price');

                var product_order_detail_price = price_text_box.val();
//                price_text_box.attr("disabled", "disabled");
                console.log(product_order_detail_price);


                var url = '{{ route('product.product-approval-update') }}';


                var detail = {};

                detail.product_order_detail_id = product_order_detail_id;
                detail.price = product_order_detail_price;


                $.ajax({
                    type: "POST",
                    url: url,
                    data: detail,
                    success: function (resp) {
                        console.log(resp);
                        if (resp.o_status_code == 1) {
                            // $(that).closest('tr').remove();
                            alertify.success(resp.o_status_message);
                        } else {
                            alertify.error(resp.o_status_message);
                        }
                    },
                    error: function (resp) {
                        alert('error');
                    }
                });


            });

            /*$(document).on("click", ".btnConfirmOrder", function () {

                console.log('btnConfirmOrder');
                var table = $(this).closest('tr').find('.tblProductDetail');
                console.log(table);

                var validation_failed = false;


                var product_order_details = [];

                $(table).find('tbody').children().each(function() {
                   //  var id = $(this).children(".ProductName").find("a");
                     var product_order_detail_id = $(this).closest('tr').attr('id');
                     console.log(product_order_detail_id);
                    var price_text_box = $(this).closest('tr').find('.product-detail-price');

                    var price = price_text_box.val();
//                price_text_box.attr("disabled", "disabled");
                    console.log(price);


                    if(price == "" || price < 0){
                        validation_failed = true;
                    }

                    var product_order_detail = {};
                    product_order_detail.product_order_detail_id = product_order_detail_id;
                    product_order_detail.price = price;

                    product_order_details.push(product_order_detail);

                 });

                if(validation_failed){
                    alertify.error('Please set all the product price!');
                    return;
                }






                var that = this;


                alertify.confirm('Confirm', 'Are you sure?',
                    function () {

                        var product_order_id = $(that).closest('tr').attr('id');
                        console.log(product_order_id);

                        var product_order_id = $(that).attr('id');


                        var detail = {};
                        detail.product_order_id = product_order_id;
                        detail.confirmed_yn = '{{\App\Enums\YesNoFlag::YES}}';
                        detail.product_order_details = product_order_details;

                        var url = '{{ route('product.product-approval-confirmation') }}';


                        $.ajax({
                            type: "POST",
                            url: url,
                            data: detail,
                            success: function (resp) {
                                console.log(resp);
                                if (resp.o_status_code == 1) {

                                    $(that).closest('tr').remove();

                                    alertify.alert('Purchase Request', resp.o_status_message);

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

            });*/

            $(document).on("click", ".btnConfirmOrder", function () {
                var product_order_id = $(this).attr('id');
                approval(product_order_id);
            });

            function approval(product_order_id) {

                //alert(id)
               // var table = $(this).closest('tr').find('.tblProductDetail');
                // $(table).find('tbody').children().each(function () {
                //     var product_order_detail_id = $(this).closest('tr').attr('id');
                //     console.log(product_order_detail_id);

                    var myModal = $('#status-show');
                    $("#workflow_id").val(3);
                    //$("#object_id").val(product_order_detail_id);
                    $("#object_id").val(product_order_id);
                    $("#get_url").val(window.location.pathname.slice(1)+'?id='+product_order_id);

                    $.ajax({
                        type: 'GET',
                        url: '/schedule/approval',
                        data: {workflowId: 3, objectid: product_order_id},
                        success: function (msg) {
                            let wrkprc = msg.workflowProcess;
                            if (typeof wrkprc === 'undefined' || wrkprc === null || wrkprc.length === 0) {
                                $('#current_status').hide();
                            } else {
                                $('#current_status').show();
                                $("#step_name").text(msg.workflowProcess[0].workflow_step.workflow);
                                $("#step_approve_by").text('By ' + msg.workflowProcess[0].user.emp_name);
                                $("#step_time").text(msg.workflowProcess[0].insert_date);
                                $("#step_approve_desig").text(msg.workflowProcess[0].user.designation);
                                $("#step_note").text(msg.workflowProcess[0].note);
                            }

                            let steps = "";
                            $('.step-progressbar').html(steps);
                            $.each(msg.progressBarData, function(j){
                                steps += "<li data-step="+msg.progressBarData[j].process_step+" class='step-progressbar__item'>"+ msg.progressBarData[j].workflow +"</li>"
                            });
                            $('.step-progressbar').html(steps);

                            let content = "";
                            $.each(msg.workflowProcess, function (i) {
                                let note = msg.workflowProcess[i].note;
                                if (note == null) {
                                    note = '';
                                }
                                content += "<div class='row d-flex justify-content-between px-1'>" +
                                    "<div class='hel'>" +
                                    "<span class='ml-1 font-medium'>" +
                                    "<h5 class='text-uppercase'>" + msg.workflowProcess[i].workflow_step.workflow + "</h5>" +
                                    "</span>" +
                                    "<span>By " + msg.workflowProcess[i].user.emp_name + "</span>" +
                                    "</div>" +
                                    "<div class='hel'>" +
                                    "<span class='btn btn-secondary btn-sm mt-1' style='border-radius: 50px'>" + msg.workflowProcess[i].insert_date + "</span>" +
                                    "<br>" +
                                    "<span style='margin-left: .3rem'>" + msg.workflowProcess[i].user.designation + "</span>" +
                                    "</div>" +
                                    "</div>" +
                                    "<hr>" +
                                    "<span class='m-b-15 d-block border p-1' style='border-radius: 5px'>" + note + "" +
                                    "</span><hr>";//msg.workflowProcess[i].insert_date;
                            });

                            $('#content_bdy').html(content);

                            if(msg.current_step && msg.current_step.process_step){
                                $('.step-progressbar li').each(function(i){

                                    if ($(this).data('step') > msg.current_step.process_step) {
                                        $(this).addClass('step-progressbar__item step-progressbar__item--active');
                                    }
                                    else {
                                        $(this).addClass('step-progressbar__item step-progressbar__item--complete');
                                    }
                                })
                            }
                            else {
                                $('.step-progressbar li').addClass('step-progressbar__item step-progressbar__item--active');
                            }

                            $("#status_id").html(msg.options);

                            if(JSON.stringify(userRoles).indexOf(msg.next_step[0].user_role) > -1){
                                $(document).find('.no-permission').hide();
                                if(msg.next_step[0].approve_yn == "Y"){
                                    $("#radio_btn_por").css("display","block");
                                }else{
                                    $("#radio_btn_por").css("display","none");
                                }
                                if(msg.next_step[0].process_step == 1 || msg.next_step[0].process_step == 2 || msg.next_step[0].process_step == 3){
                                    $("#hide_price_bdt").css("display","none");
                                    $("#hide_price_usd").css("display","none");
                                    $("#price_bdt").removeAttr('required');
                                    $("#price_usd").removeAttr('required');
                                }else{
                                    $("#hide_price_bdt").css("display","block");
                                    $("#hide_price_usd").css("display","block");
                                    $("#price_bdt").attr('required', '');
                                    $("#price_usd").attr('required', '');
                                    $("#price_bdt").val('');
                                    $("#price_usd").val('');
                                    $("#price_bdt").val(msg.current_step.price_bdt);
                                    $("#price_usd").val(msg.current_step.price_usd);
                                    $("#hide_note").css("display","none");
                                }
                                $(document).find('.no-permission').hide();
                                $(document).find('#status_note').show();
                                $(document).find('#button_portion').show();
                            }
                            else {
                                $(".no-permission").css("display","block");
                                $(document).find('#status_note').hide();
                                $(document).find('#button_portion').hide();
                            }
                        }
                    });
                    myModal.modal({show: true});
                    return false;

               // });
            }

            $('input[type=radio][name=final_approve_yn]').change(function() {
                if (this.value == 'Y') {
                    $("#save_btn").css("display","none");
                    $("#close_btn").css("display","none");
                    $("#bonus_id_prm").val(48);
                    $(document).find('#hide_status').hide();
                    $(document).find('#hide_note').hide();
                    $("#approve_btn").css("display","block");
                }
                else if (this.value == 'N') {
                    //$(document).find('#hide_div').show();
                    $("#save_btn").css("display","block");
                    $("#close_btn").css("display","block");
                    $("#approve_btn").css("display","none");
                    $("#bonus_id_prm").val('');
                    $(document).find('#hide_status').show();
                    $(document).find('#hide_note').hide();
                }
            });

            $(document).ready(function () {
                $("#workflow_form").attr('action', '{{ route('schedule.approval-post') }}');
            });

            /**/
            $(document).on("click", ".btnRejectOrder", function () {

                var that = this;


                alertify.confirm('Confirm', 'Are you sure?',
                    function () {

                        var product_order_id = $(that).closest('tr').attr('id');
                        console.log(product_order_id);

                        var product_order_id = $(that).attr('id');


                        var detail = {};
                        detail.product_order_id = product_order_id;
                        detail.confirmed_yn = 'R';

                        var url = '{{ route('product.product-approval-rejection') }}';


                        $.ajax({
                            type: "POST",
                            url: url,
                            data: detail,
                            success: function (resp) {
                                console.log(resp);
                                if (resp.o_status_code == 1) {

                                    $(that).closest('tr').remove();

                                    alertify.alert('Purchase Request', resp.o_status_message);

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

                /*
                                alertify.prompt('Input (text):').set('type', 'text').set('onshow',function(){
                                    $(this.elements.content).find('.ajs-input').attr('required', true);
                                });;*/

                /*alertify.prompt(
                    'Warning!',
                    'Are you sure you wish to CANCEL the order?',
                    'Input (text):',
                    function (e, reason) {
                        if( reason == '' ) {
                            e.cancel = true;
                        }
                        // my code on confirm...
                    },
                    function () {
                        return;
                    }
                ).set('type', 'text'); */


            });


        });

    </script>

@endsection

