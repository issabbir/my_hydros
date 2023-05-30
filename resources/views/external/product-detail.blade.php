@extends('layouts.external')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
    <style>
        .f_size{
            font-size: 1.5rem;
        }
    </style>
@endsection
@section('content')


    <div class="row">


        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{--@json($product_details)--}}
                    <div class="row">
                        <div class="col-12 p-1 text-left">
                            <h1><strong> {{$product->name}}</strong></h1>
                        </div>
                    </div>
                    <h3 class="text-justify f_size"> {{$product->description}}</h3>
                    <hr>
                    @foreach($product_details as $product_detail)

                        <div class="row mt-3">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-6 text-center">
                                        {{--<img src="../../../public/assets/images/cards/product_img.jpg"
                                             style="width: 170px; height: 180px;" title="Product Image" alt="Dummy Image"
                                             class="ml-1 shadow-lg">--}}
                                        @if(isset($product->file_info_id) && isset($product->file_info))
                                            <img src="data:{{$product->file_info->file_type}};base64,{{$product->file_info->file_content}}"
                                                 style="width: 160px; height: 160px;" title="Product Image" alt="Dummy Image"
                                                 class="ml-1 shadow-lg">
                                        @else
                                            <img src="{{asset('assets/images/cards/product_img.jpg')}}"
                                                 style="width: 160px; height: 180px;" title="Product Image"
                                                 alt="Dummy Image"
                                                 class="ml-1 shadow-lg">

                                        @endif
                                    </div>
                                    <div class="col-6" id="{{$product_detail->file_format->file_format_name}}">
                                        <h3><span class="font-weight-bold">Format : </span>
                                            {{$product_detail->file_format->file_format_name}}
                                        </h3>
                                     {{--   <h3><span
                                                class="font-weight-bold">Price :</span> {{$product_detail->price}}
                                            BDT</h3>
                                        <h3><span class="font-weight-bold">Availability : </span> In Stock</h3>
                                     --}}
                                        {{--<form action="{{ route('external-user.cart-add') }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" value="{{ $product_detail->product_detail_id }}" id="id" name="id">
                                            <input type="hidden" value="{{ $product->name }}" id="name" name="name">
                                            <input type="hidden" value="{{ $product_detail->price }}" id="price" name="price">
                                            <input type="hidden" value="{{$product_detail->file_format->file_format_name}}" id="file_format_name" name="file_format_name">
                                            --}}{{--  <input type="hidden" value="{{ $pro->image_path }}" id="img" name="img">
                                              <input type="hidden" value="{{ $pro->slug }}" id="slug" name="slug">
                                              --}}{{--
                                            <input type="hidden" value="1" id="quantity" name="quantity">
                                           --}}
                                        <button id="{{$product_detail->product_detail_id}}" type="button" class="btn btn-primary mt-1 btn-lg add-item">Add to Cart
                                        </button>
                                       {{-- </form>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 text-left">
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="checkout-details-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form name="frm-add-to-cart" id="frm-add-to-cart" method="post" action="{{route('external-user.cart-add')}}">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Purchase Request Details </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <input type="hidden" id="cart_product_id" name="id" value="1">
                            <input type="hidden" id="name" name="name" value="{{$product->name}}">
                            <input type="hidden" id="price" name="price" value="1">
{{--                            <input type="hidden" id="quantity" name="quantity" value="1">--}}
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="from_date" class="required">From Date </label>
                                    <input placeholder="YYYY-MM-DD"
                                           type="text"
                                           class="form-control tentative-delivery"
                                           id="from_date"
                                           name="from_date"
                                           data-date-format="yyyy-mm-dd"
                                           required
                                           autocomplete="off"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="to_date" class="required">To Date </label>
                                    <input placeholder="YYYY-MM-DD"
                                           type="text"
                                           class="form-control tentative-delivery"
                                           id="to_date"
                                           name="to_date"
                                           data-date-format="yyyy-mm-dd"
                                           required
                                           autocomplete="off"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="quantity" class="required">Quantity </label>
                                    <input
                                        type="number"
                                        required
                                        class="integer form-control"
                                        id="quantity"
                                        name="quantity"
                                        autocomplete="off">

                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="file_category_name" class="required">Preferred Format </label>
                                    <input
                                           type="text"
                                           class="form-control"
                                           id="file_format_name"
                                           name="file_format_name"
                                           readonly="readonly"
                                           id="file_format_name"
                                           name="file_format_name">

                                    {{--<select  required class=" form-control" id="file_format_name"
                                             name="file_format_name" readonly="readonly">
                                        --}}{{--<option value="">Select One</option>--}}{{--
                                        @if(isset($fileFormats))
                                            @foreach($fileFormats as $fileFormat)
                                                <option value="{{$fileFormat->file_format_name}}"
                                                        @if(isset($product_details->file_format_id) &&
                                                        ($product_details->file_format_id == $fileFormat->file_format_id))
                                                        selected
                                                    @endif
                                                >{{$fileFormat->file_format_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>--}}
                                    {{--  <small class="text-muted form-text"></small>--}}
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="order-confirm" type="submit" class="btn btn-primary" >Confirm
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">


        // Cart Hover
        $(".description").tooltip();
        $(".add_cart").tooltip();
        $(".prd_img").tooltip();

        $('.tentative-delivery').datepicker({
            autoclose: true,
            todayHighlight: true,
            endDate: '+0d',

            orientation: "bottom auto",
        });


        //tbl_customer_list
        $(function () {
            $('#menu-dashboard').addClass('active');

            $(document).on("click", ".add-item", function (){

                $('#frm-add-to-cart').trigger('reset');
                var id= $(this).attr('id');

                $('#cart_product_id').val(id);


                var file_format_id = $(this).parent().attr('id');
                console.log(file_format_id);
                $('#file_format_name').val(file_format_id);



                $('#checkout-details-modal').modal({
                    show: true,
                    backdrop: 'static'
                });
            });



            $("form[name='frm-add-to-cart']").validate({
                errorElement: "span", // contain the error msg in a small tag
                errorClass: 'help-block error',
                errorPlacement: function (error, element) { // render error placement for each input type
                    if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
                        error.insertAfter($(element).closest('.form-group').children('div').children().last());
                    } else if (element.hasClass("ckeditor")) {
                        error.appendTo($(element).closest('.form-group'));
                    } else {
                        error.insertAfter(element);
                        // for other inputs, just perform default behavior
                    }
                },
                ignore: "",

                submitHandler: function (form) {
                    var from_date = $('#from_date').val();

                    if(from_date == null || from_date == undefined || from_date == ""){
                        alertify.error('From date is required');
                        return;
                    }
                    var parts = from_date.split('-');
// Please pay attention to the month (parts[1]); JavaScript counts months from 0:
// January - 0, February - 1, etc.
                    var fdt = new Date(parts[0], parts[1] - 1, parts[2]);

                    var to_date = $('#to_date').val();

                    if(to_date == null || to_date == undefined || to_date == ""){
                        alertify.error('To date is required');
                        return;
                    }

                    var tparts = to_date.split('-');
// Please pay attention to the month (parts[1]); JavaScript counts months from 0:
// January - 0, February - 1, etc.
                    var tdt = new Date(tparts[0], tparts[1] - 1, tparts[2]);

                    console.log('fdt',fdt);
                    console.log('tdt',tdt);
                    if(tdt < fdt){
                        alertify.error('From date/To date is not valid!');
                        return;
                    }
                    var quantity = $('#quantity').val();
                    if(quantity == null || quantity == undefined || quantity == ""){
                        alertify.error('To quantity is required');
                        return;
                    }
                    //alertify.success('OK');

                    form.submit();
                }
            });

        });

        $("input.integer").bind("change keyup input", function() {
            var position = this.selectionStart - 1;
            //remove all but number and .
            var fixed = this.value.replace(/[^0-9]/g, "");

            if (this.value !== fixed) {
                this.value = fixed;
                this.selectionStart = position;
                this.selectionEnd = position;
            }
        });
    </script>

@endsection











