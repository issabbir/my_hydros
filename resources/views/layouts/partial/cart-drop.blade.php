@if(count(\Cart::getContent()) > 0)
    @foreach(\Cart::getContent() as $item)
        <li class="list-group-item">
            <div class="row">
                <div class="col-lg-3" style="margin-right: 21px;">

                    @if($item->attributes->file_type != "")
                        <img src="data:{{$item->attributes->file_type}};base64,{{$item->attributes->file_content}}"
                             style="width: 83px; height: 74px;" title="Product Image" alt="Dummy Image"
                             class="ml-1 shadow-lg">
                    @else
                        <img src="{{asset('assets/images/cards/product_img.jpg')}}"
                             style="width: 160px; height: 180px;" title="Product Image"
                             alt="Dummy Image"
                             class="ml-1 shadow-lg">

                    @endif

                   {{-- <img src="{{asset('assets/images/cards/product_img.jpg')}}"
                         style="width: 50px; height: 50px;"title="Product Image"
                         alt="Dummy Image"
                         class="ml-1 shadow-lg">--}}
                </div>
                <div class="col-lg-6">
                    <b>{{$item->name}}</b>
                    {{-- <br><small>Qty: {{$item->quantity}}</small> --}}
                    <br><small>Format : {{$item->attributes->file_format_name}}</small>
                </div>
                {{--<div class="col-lg-3">
                    <p> BDT {{ \Cart::get($item->id)->getPriceSum() }}</p>
                </div>--}}
                <hr>
            </div>
        </li>
    @endforeach
    <br>
    <li class="list-group-item">
        <div class="row">
            <div class="col-lg-10">
                <b>Total : </b> {{ \Cart::getTotal() }}
            </div>
            <div class="col-lg-2">
                <form action="{{ route('external-user.cart-clear') }}" method="POST">
                    {{ csrf_field() }}
                    <button class="btn btn-sm"><i class="fa fa-trash"></i></button>
                </form>
            </div>
        </div>
    </li>
    <br>
    <div class="row" style="margin: 0px;">
        <a class="btn btn-dark btn-sm btn-block" href="{{ route('external-user.cart') }}">
            CART <i class="fa fa-arrow-right"></i>
        </a>
        {{--external-user.checkout--}}
        {{--<a class="btn btn-dark btn-sm btn-block" href="{{ route('external-user.checkout') }}">
            CHECKOUT <i class="fa fa-arrow-right"></i>
        </a>--}}
    </div>
@else
    <li class="list-group-item">Your Cart is Empty</li>
@endif
