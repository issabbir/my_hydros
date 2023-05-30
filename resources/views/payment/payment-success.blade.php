@extends('layouts.external')

@section('title')

@endsection

@section('header-style')

<style>
    .f_family {
        font-family:sans-serif;
    }
    .marg {
        margin-top: 30%
    }
</style>

    <!--Load custom style link or css-->
@endsection
@section('content')



    <div class="row">
        <div class="col-md-12 h-100 d-flex justify-content-center">
            <div class="card border border-success m-auto" style="width: 35%; height: 50rem">

                <button id="" type="button" class="btn ml-2 marg">
                    <img class="payment" src="{{URL::asset('/assets/images/cards/success__msg.png')}}" alt="Payment Completed" height="100" width="100" title="Payment Completed"/>
                </button>
                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                <div class="card-body">
                    <h5 class="card-title text-success text-center">Payment Successful</h5>
                    <h6 class="mb-2 text-center">Order ID : <span class=""> {{$product_order_id}} </span></h6>
                    <p class="card-text text-center mb-5">Thank you for purchasing. Your payment was successful.</p>
                    <a href="{{route('external-user.confirmed-order-index')}}" type="button" class="btn btn-outline-success btn-lg btn-block mt-1">See Details</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">


    </script>

@endsection

