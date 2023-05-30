@extends('layouts.external')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
    <style>
        ul {
            list-style-type: none;
        }
        .pointer {
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            {{--@json($products)--}}
            <div class="row mb-2">
                <div class="col-12">
                    <h1 class="text-primary">Welcome To Hydrography Product Selling Portal</h1>
                    {{-- <h4 class="card-title">Payment Gateway List</h4> --}}
                    {{-- <div class="card-content">
                        <h2>Card Content</h2>
                    </div> --}}
                </div>
            </div>

            @foreach($products as $product)

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="row">
                                    <div class="col-6">
                                        @if(isset($product->file_info_id))

                                        @else
                                            <img src="{{asset('assets/images/cards/product_img.jpg')}}"
                                                style="width: 160px; height: 160px;" title="Product Image" alt="Dummy Image"
                                                class="ml-1 shadow-lg">

                                        @endif
                                    </div>
                                    <div class="col-6 text-left">
                                         <h2><strong>{{$product->name}} {{-- Demo Product--}}</strong></h2>
                                       {{-- <span class="mt-1"> {{$product->format_available}} Format(s)</span>--}}
                           {{--             <p class="text-muted mb-2">Minumum Price: <span> {{$product->min_price}} BDT</span></p>
                           --}}             <form method="GET"
                                            action="{{route('external-user.product-detail',$product->product_id)}}">
                                            <button type="submit" class="btn btn-success mt-1">View Details</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-7 basic-info text-right" id="{{$product->product_id}}">&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                                &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                                &nbsp; <u class="font-weight-bold pointer"> Basic Info</u> <span style='font-size: 20px;'> &#8594;</span>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach

            {{-- <div class="card">
               <div class="card-body">
                 <div class="row">
                     <div class="col-2">
                       <img src="../../public/assets/images/cards/product_img.jpg" style="width: 160px; height: 160px;" title="Product Image"  alt="Dummy Image" class="ml-1 shadow-lg">
                     </div>
                     <div class="col-3 mt">
                       <h2> <strong>CHART2</strong></h2>
                       <span class="mt-1"> 3 Format</span>
                       <p class="text-muted mb-2">Minumum Price: <span> 10 BDT</span></p>
                       <button type="button" class="btn btn-success mt-1">View Details</button>
                     </div>
                     <div class="col-5"></div>
                     <div class="col-2">&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; <u class="font-weight-bold"> Basic Info</u> <span style='font-size: 20px;'> &#8594;</span> </div>
                 </div>
               </div>
             </div>

             <div class="card">
               <div class="card-body">
                 <div class="row">
                     <div class="col-2">
                       <img src="../../public/assets/images/cards/product_img.jpg" style="width: 160px; height: 160px;" title="Product Image"  alt="Dummy Image" class="ml-1 shadow-lg">
                     </div>
                     <div class="col-3 mt">
                       <h2> <strong>MAP</strong></h2>
                       <span class="mt-1"> 3 Format</span>
                       <p class="text-muted mb-2">Minumum Price: <span> 10 BDT</span></p>
                       <button type="button" class="btn btn-success mt-1">View Details</button>
                     </div>
                     <div class="col-5"></div>
                     <div class="col-2">&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; <u class="font-weight-bold"> Basic Info</u> <span style='font-size: 20px;'> &#8594;</span> </div>
                 </div>
               </div>
             </div>--}}
        </div>
    </div>

    <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Product Description</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12"  id="product-description">

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>--}}
                </div>
            </div>
        </div>

    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">
        $(function () {

            $('#menu-order-tracking-index').addClass('active');
            $('#breadcrumb-header').html('Order Tracking');
            $('#breadcrumb-header').attr('href',"{{route('external-user.order-tracking-index')}}");

        });

    </script>

@endsection

