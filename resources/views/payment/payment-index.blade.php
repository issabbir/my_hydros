@extends('layouts.external')

@section('title')

@endsection

@section('header-style')

    <style>
        .f_family {
            font-family: sans-serif;
        }

        .lines {
            width: 100px;
            height: 45px;
            position: relative;

        }

        .lines::after, .lines::before {
            content: '',
            position: absolute,
            margin: auto;
            height: 2px;
            background: #fff;
            width: 45%;
            top: 45%;
        }

        .lines::after {
            left: 0;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="{{ Config::get('bkash.bkashScriptURL') }}"></script>

    <!--Load custom style link or css-->
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            {{-- @json($selling_requests)--}}
            {{-- <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">Please pay {{$amount}} Taka</h4>
                            <div class="card-content">

                                <button type="button" class="btn">
                                    <img class="city_bank" src="{{URL::asset('/assets/images/cards/city_bank.jpg')}}" alt="City Bank Logo" height="100" width="150" title="Payment by City Bank"/>
                                </button>
                               <button id="bKash_button" type="button" class="btn ml-2">
                                 <img class="bkash" src="{{URL::asset('/assets/images/cards/bkash.jpg')}}" alt="B-Kash Logo" height="100" width="150" title="Payment by B-Kash"/>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="container bg-light p-3 rounded">
                {{-- <div class="container p-3"> --}}

                <div class="row justify-content-center">
                    <div class="col-12">
                        <h1 class="display-3  f_family">Choose Your Payment Gateway</h1>
                        <hr>
                    </div>

                    @if(isset($city_enable) && $city_enable == 'Y')

                        <div class="col-12 mt-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-white" style="font-size: 1.5rem"><strong>
                                            <span>Payment Using Card </span> </strong></p>
                                    <div class="card" style="width: 18rem;">
                                        <div class="card-body">
                                            {{-- <h5 class="card-title">Card title</h5>
                                            <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> --}}
                                            <button type="button" class="btn">
                                                <img class="city_bank"
                                                     src="{{URL::asset('/assets/images/cards/city_bank.jpg')}}"
                                                     alt="City Bank Logo" height="100" width="150"
                                                     title="Payment by City Bank"/>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endif


                    @if(isset($bkash_enable) && $bkash_enable == 'Y')

                        <div class="col-12  justify-content-center">
                            <div class="row mt-2">
                                <div class="col-6">
                                    <p class="text-white" style="font-size: 1.5rem"><strong> <span> Payment Through Mobile Banking (SC 2%)</span>
                                        </strong></p>
                                    <span class="lines"></span>
                                    <div class="card" style="width: 18rem;">
                                        <div class="card-body">
                                            {{-- <h5 class="card-title">Card title</h5>
                                            <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> --}}
                                            <button id="bKash_button" type="button" class="btn ml-2"
                                                    style="cursor: pointer">
                                                <img class="bkash"
                                                     src="{{URL::asset('/assets/images/cards/bkash.jpg')}}"
                                                     alt="bKash Logo" height="100" width="150"
                                                     title="Payment by bKash"/>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <p class="text-white" style="font-size: 1.5rem"><strong> <span> Payment Through Sonali Sheba</span>
                                        </strong></p>
                                    <span class="lines"></span>
                                    <div class="card" style="width: 18rem;">
                                        <div class="card-body">
                                            {{-- <h5 class="card-title">Card title</h5>
                                            <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> --}}
                                            <button id="sonaliSheba_button" type="button" class="btn ml-2"
                                                    style="cursor: pointer">
                                                {{--<img class="sonaliSheba"
                                                     src="{{URL::asset('/assets/images/cards/sonalibank.png')}}"
                                                     alt="bKash Logo" height="100" width="150"
                                                     title="Payment by Sonali Sheba"/>
                                                <a ml="4" target="_blank" src="{{URL::asset('/assets/images/cards/sonalibank.png')}}" alt="Sonali Logo"
                                                   href="{{route('setup.team-employee-index',['teamId'=>$queryResults->team_id, 'queryResults' => $queryResults->team_name])}}"
                                                   class="text-primary teamEmployeeEdit"><i
                                                        class="bx bx-plus-circle cursor-pointer"></i></a>--}}
                                                <a target="_self"
                                                   href="{{route('external-user.sonali-payment-index',['transaction_id'=>$transaction_id, 'customer_id' => $customer_id, 'amount' => $amount_s, 'product_order_id' => $product_order_id])}}"
                                                   class="text-primary sonaliSheba" title="Payment by Sonali Sheba">
                                                    <img class="sonaliSheba"
                                                         src="{{URL::asset('/assets/images/cards/sonalibank.png')}}"
                                                         alt="sonali Logo" height="100" width="150"
                                                         title="Payment by Sonali Sheba"/>
                                                </a>
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endif
                </div>

            </div>

        </div>
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">

        $(function () {


            $('#menu-approval-status').addClass('active');
            /*
                        $('#breadcrumb-header').html('Approved Request Index');
                        $('#breadcrumb-header').attr('href', "{{route('external-user.approved-request-index')}}");
*/

            // Bkash & City Bank Title Show
            $(".bkash").tooltip();
            $(".city_bank").tooltip();

            var paymentID = '';
            // var id_token = '';
            bKash.init({
                paymentMode: '{{\App\Enums\BkashConstant::PAYMENT_MODE}}', //fixed value ‘checkout’
                //paymentRequest format: {amount: AMOUNT, intent: INTENT}
                //intent options
                //1) ‘sale’ – immediate transaction (2 API calls)
                //2) ‘authorization’ – deferred transaction (3 API calls)
                paymentRequest: {
                    amount: '{{number_format($amount * 1.02, 2)}}', //max two decimal points allowed
                    intent: '{{\App\Enums\BkashConstant::INTENT}}'
                },
                createRequest: function (request) { //request object is basically the paymentRequest object, automatically pushed by the script in createRequest method
                    $.ajax({
                        url: '{{route('external-user.bkash-create')}}',
                        type: 'POST',
                        contentType: 'application/json',
                        success: function (data) {
                            console.log('data', data);
                            if (data && data.paymentID != null) {
                                paymentID = data.paymentID;
                                //id_token = data.id_token;
                                //   console.log('paymentID',paymentID);

                                //   data = JSON.stringify(data);

                                bKash.create().onSuccess(data); //pass the whole response data in bKash.create().onSucess() method as a parameter
                            } else {
                                alert(data.errorMessage);
                                bKash.create().onError();
                            }
                        },
                        error: function () {
                            bKash.create().onError();
                        }
                    });
                },
                executeRequestOnAuthorization: function () {
                    console.log('executeRequestOnAuthorization');
                    $.ajax({
                        url: '{{route('external-user.bkash-execute')}}',
                        type: 'POST',
                        //contentType: 'application/json',
                        data: {
                            "paymentID": paymentID
                        },
                        success: function (data) {
                            console.log('executeRequestOnAuthorization', data);
                            // data = JSON.parse(data);
                            if (data && data.paymentID != null) {
                                window.location.href = "{{route('external-user.bkash-success')}}";//Merchant’s success page
                            } else {
                                alert(data.errorMessage);
                                bKash.execute().onError();
                            }
                        },
                        error: function () {
                            bKash.execute().onError();
                        }
                    });
                },
                onClose: function () {
                    window.location.href = "{{route('external-user.payment-reject')}}";//your cancel page

                }
            });

        })
    </script>

@endsection

