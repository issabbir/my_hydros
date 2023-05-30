@extends('layouts.external')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
    <style>
        #searchbar{
            margin-left: 15%;
            padding:15px;
            border-radius: 10px;
        }

        input[type=text] {
            width: 30%;
            -webkit-transition: width 0.15s ease-in-out;
            transition: width 0.15s ease-in-out;
        }

        /* When the input field gets focus,
             change its width to 100% */
        input[type=text]:focus {
            width: 70%;
        }

        #list{
            font-size:  1.5em;
            margin-left: 90px;
        }

        .animals{
            display: list-item;
        }
        ul {
            list-style-type: none;
        }
        .pointer {
            cursor: pointer;
        }

        html body.navbar-sticky .app-content .content-wrapper {
            padding: 1.20rem 2.5rem;
            margin-top: 0rem;
        }

        @media (min-width: 768px){
            .col-md-6 {
                max-width: 49%;
                margin-right: 8px;
            }
        }

        .card-mb{
            margin-bottom: 0rem;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12 card card-mb">
            <div class="p-1 justify-content-center d-flex">
                <h3 class="text-primary">Welcome To Hydrography Product Selling Portal</h3>
            </div>
        </div>
        <div class="col-12 card card-mb">
            <form action="{{route('external-user.dashboard-search')}}" method="POST" role="search">
                {{ csrf_field() }}
                <div class="p-1 justify-content-end d-flex">
                    <input type="text" class="form-control" name="searchItem"
                           placeholder="Search users"> <span class="input-group-btn">
                    <button type="submit" class="btn btn-default color-box">
                       <i class="fas fa-search"></i>
                    </button>
                    </span>
                </div>
            </form>
        </div>

        @if($products)
        <div class="row" style="width: 100%;">
            <div class="col-md-12">
                    <div class="row p-2">
                            @foreach($products as $product)
                                <div class="col-md-6 card p-2">
                                    <div class="row" name="product_name">
                                        <div class="col-6">
                                            @if(isset($product->file_info_id))
                                                <img src="data:{{$product->file_type}};base64,{{$product->file_content}}"
                                                     style="width: 160px; height: 160px;" title="Product Image" alt="Dummy Image"
                                                     class="ml-1 shadow-lg">
                                            @else
                                                <img src="{{asset('assets/images/cards/product_img.jpg')}}"
                                                     style="width: 160px; height: 160px;" title="Product Image" alt="Dummy Image"
                                                     class="ml-1 shadow-lg">
                                            @endif
                                        </div>
                                        <div class="col-6" text-right">
                                            <h3 class="text-uppercase"><strong>{{$product->name}}</strong></h3>
                                            {{-- <span class="mt-1"> {{$product->format_available}} Format(s)</span>--}}
                                            {{--             <p class="text-muted mb-2">Minumum Price: <span> {{$product->min_price}} BDT</span></p>
                                            --}}             <form method="GET"
                                                                       action="{{route('external-user.product-detail',$product->product_id)}}">
                                                <button type="submit" class="btn btn-success mt-1">View Details</button>
                                            </form>
                                            <div class="basic-info mt-2" id="{{$product->product_id}}">
                                                <u class="font-weight-bold pointer"> Basic Info</u> <span style='font-size: 20px;'> &#8594;</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                    </div>
            </div>
        </div>
        @else
            <div class="col-md-12 card mt-1 p-2 text-center">
                <p>Sorry! No result found for search content.</p>
            </div>
        @endif
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

                    $('#menu-dashboard').addClass('active');
                    // Description & Cart Hover
                    $(".description").tooltip();
                    $(".add_cart").tooltip();
                    $(".prd_img").tooltip();
                    $(document).on("click", ".basic-info", function () {
                        var product_id = $(this).attr('id');
//                console.log(product_id);

                        var url = '{{ route('external-user.product_detail_by_id') }}';


                        var detail = {};
                        detail.product_id = product_id;

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: detail,
                            success: function (resp) {
                                //                      console.log(resp);

                                $('#product-description').html(resp.description);

                                $('#basicExampleModal').modal({
                                    show: true,
                                    backdrop: 'static'
                                });

                            },
                            error: function (resp) {
                                alert('error');
                            }
                        });



                    })

                });


            </script>

@endsection

