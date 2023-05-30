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
            <div class="card border border-danger m-auto" style="width: 35%; height: 50rem">

                <button id="" type="button" class="btn ml-2 marg">
                    <img class="" src="{{URL::asset('/assets/images/cards/oops.jpg')}}" alt="" height="150" width="150" title=""/>
                </button>
                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                <div class="card-body">
                    <h5 class="card-title text-warning text-center">Oops !</h5>
                    <p class="card-text text-center mb-5">Something went wrong We couldn't process your payment.</p>
                    <a href="{{route('external-user.approved-request-index')}}" type="button" class="btn btn-outline-warning btn-lg btn-block mt-1">Try Again</a>
                </div>
            </div>
        </div>
    </div>





@endsection

@section('footer-script')
    <script type="text/javascript">


    </script>

@endsection

