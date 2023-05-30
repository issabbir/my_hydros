@extends('layouts.external')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
    <style>
        .undo {
            margin-left: 2px;
            font-size: 12px;
        }

        .dlt {
            font-size: 20px;
            margin-left: 5px;
        }

        .prd_txt {
            font-size: 25px;
        }

        .txt-for {
            font-size: 15px;
        }

        .prd_frmt {
            font-size: 18px;
        }

        .price_txt {
            font-size: 20px;
        }


    </style>
@endsection
@section('content')
<div class=".container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-6">
                            <h1><strong>Items In Your Cart</strong></h1>
                        </div>
                        <div class="col-6 text-right">

                            @if(count($cartCollection)>0)
                                <form action="{{ route('external-user.cart-clear') }}" method="POST">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-outline-danger"> Delete All</button>
                                    {{--  --}}
                                </form>
                            @endif

                        </div>
                    </div>
                    <hr>

                    @foreach($cartCollection as $item)
                    <div class="row p-1">
                        <div class="col-12">
                            <div class="row my-col">
                                <div class="col-3 f-col">
                                    {{--@json($item->attributes)--}}
                                    {{--<img src="{{asset('assets/images/cards/product_img.jpg')}}"
                                             style="width: 140px; height: 150px;" title="Product Image"
                                             alt="Dummy Image"
                                             class="ml-1 shadow-lg">--}}
                                    @if($item->attributes->file_type != "")
                                        <img src="data:{{$item->attributes->file_type}};base64,{{$item->attributes->file_content}}"
                                             style="width: 160px; height: 160px;" title="Product Image" alt="Dummy Image"
                                             class="ml-1 shadow-lg">
                                    @else
                                        <img src="{{asset('assets/images/cards/product_img.jpg')}}"
                                             style="width: 160px; height: 180px;" title="Product Image"
                                             alt="Dummy Image"
                                             class="ml-1 shadow-lg">

                                    @endif
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="mt-0"><strong class="prd_txt">{{ $item->name }}</strong></h5>
                                    <label for="prd_frmt" class="mr-1 prd_frmt">Format : </label>
                                    <select name="#" id="prd_frmt" disabled>
                                        <option value="1">{{$item->attributes->file_format_name}}</option>
                                    </select> <br>
                                    <label class="mr-1 prd_frmt">From : {{ $item->attributes->from_date }}</label> <br>
                                    <label class="mr-1 prd_frmt">To : {{ $item->attributes->to_date }}</label><br>
                                    <label class="mr-1 prd_frmt">Quantity: {{ $item->quantity }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 text-right">
                                    <form action="{{ route('external-user.cart-remove') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ $item->id }}" id="id" name="id">
                                        <button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash"></i></button>
                                        {{-- <button class="btn btn-dark btn-sm" style="margin-right: 10px;"></button> --}}
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>


                        {{--@json($item)--}}

                    @endforeach


                    {{--<hr>
                    <div class="row mt-3">
                      <div class="col-6">
                          <div class="row">
                              <div class="col-4">
                                  <img src="{{asset('assets/images/cards/product_img.jpg')}}"
                                  style="width: 160px; height: 180px;" title="Product Image"
                                  alt="Dummy Image"
                                  class="ml-1 shadow-lg">
                              </div>
                              <div class="col-6">
                                  <div class="row">
                                      <div class="col-8 text-left">
                                          <h5 class="mt-0"> <strong class="prd_txt">Demo Product</strong> </h5>
                                           <label for="prd_frmt" class="mr-1">Formate : </label>
                                             <select name="#" id="#">
                                                 <option value="1">PDF</option>
                                                 <option value="1">Excl</option>
                                                 <option value="1">Word</option>
                                             </select>
                                      </div>
                                      <div class="col-4"></div>
                                  </div>
                              </div>
                              <div class="col-2"></div>
                          </div>
                      </div>
                      <div class="col-6 text-right">
                        <h5>Delete <i class="fas fa-trash-restore-alt ml-1"></i></h5>
                        <p class="mt-3">  <span>Price: </span>  <span>BDT 20</span> </p>
                      </div>
                    </div>

                    <hr>
                    <div class="row mt-3">
                      <div class="col-6">
                          <div class="row">
                              <div class="col-4">
                                  <img src="{{asset('assets/images/cards/product_img.jpg')}}"
                                  style="width: 160px; height: 180px;" title="Product Image"
                                  alt="Dummy Image"
                                  class="ml-1 shadow-lg">
                              </div>
                              <div class="col-6">
                                  <div class="row">
                                      <div class="col-8 text-left">
                                          <h5 class="mt-0"> <strong class="prd_txt">Demo Product</strong> </h5>
                                           <label for="prd_frmt" class="mr-1">Formate : </label>
                                             <select name="#" id="#">
                                                 <option value="1">PDF</option>
                                                 <option value="1">Excl</option>
                                                 <option value="1">Word</option>
                                             </select>
                                      </div>
                                      <div class="col-4"></div>
                                  </div>
                              </div>
                              <div class="col-2"></div>
                          </div>
                      </div>
                      <div class="col-6 text-right">
                        <h5>Delete <i class="fas fa-trash-restore-alt ml-1"></i></h5>
                        <p class="mt-3">  <span>Price: </span>  <span>BDT 20</span> </p>
                      </div>
                    </div>--}}


                    @if(\Cart::getTotalQuantity()>0)
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <h2>Total Product :
                                    <span
                                        class="font-weight-light">
                                        {{ \Cart::getTotalQuantity()}}
                                    </span></h2>
                            </div>
                        {{--    <div class="col-6 text-right">
                                <h2>Total Price : <span class="font-weight-light"> BDT {{ \Cart::getTotal() }}</span>
                                </h2>
                            </div>--}}
                        </div>
                    @else
                        <h4>No Product(s) In Your Cart</h4><br>
                      {{--  <a href="{{route('external-user.dashboard')}}" class="btn btn-dark">Continue Shopping</a>--}}
                    @endif

                    <div class="row">
                        <div class="col-8"></div>
                        <div class="col-4 col-sm-12 text-right">
                            @if(\Cart::getTotalQuantity()>0)
                            <a href="{{route('external-user.checkout')}}"
                               type="button" class="btn btn-outline-success float-right">
                                Request Submit
                            </a>
                            @endif
                            <a href="{{route('external-user.dashboard')}}" type="button"
                               class="btn btn-outline-info float-right mr-2">
                                Continue Shopping
                            </a>
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

        // Cart Hover
        $(".description").tooltip();
        $(".add_cart").tooltip();
        $(".prd_img").tooltip();


        //tbl_customer_list
        $(function () {
            $('#tbl_customer_list').DataTable();
        });

    </script>

@endsection

