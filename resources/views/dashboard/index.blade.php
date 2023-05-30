@extends('layouts.default')

@section('title')
Dashboard
@endsection

@section('header-style')

{{-- <link rel="stylesheet" href="custome_style.css"> --}}

<style type="text/css">


    .swiper-container {
        padding: 0px 130px;
    }

    .swiper-slide {
        width: 60%;
        min-height: 200px;
    }

    .swiper-slide:nth-child(2n) {
        width: 40%;
    }

    .swiper-slide:nth-child(3n) {
        width: 20%;
    }

    .card.cardSlide {
        min-height: 180px;
    }

    .first_row {
        min-height: 530px;
    }

    .second_row {
        min-height: 275px;
    }

    .third_row {
        min-height: 500px;
    }

    .forth_row {
        min-height: 410px;
    }
    ol.breadcrumb{
        display: none;
    }

    @media only screen and (max-width: 1400px) {
        .swiper-container {
            padding: 0px !important;
        }

        .swiper-slide {
            width: 50%;
            min-height: 200px;
        }

        .swiper-slide:nth-child(2n) {
            width: 50%;
        }

        .swiper-slide:nth-child(3n) {
            width: 50%;
        }

        .swiper-slide h5 {
            font-size: 15px !important;
        }

        #dashboard-analytics h2 {
            font-size: 22px !important;
        }

        #dashboard-analytics h4, #dashboard-analytics h6 {
            font-size: 15px !important;
        }

        #dashboard-analytics span {
            font-size: 12px;
        }

        #dashboard-analytics table tr th {
            font-size: 13px;
        }
    }

    @media only screen and (max-width: 640px) {
        .swiper-container {
            padding: 0px !important;
        }

        .swiper-slide {
            width: 100% !important;
            min-height: 200px;
        }

        .swiper-slide:nth-child(2n) {
            width: 100% !important;
        }

        .swiper-slide:nth-child(3n) {
            width: 100% !important;
        }

        .shadow-lg.p-2 {
            padding: 0 !important;
        }
    }

    /* Hover */

    .card-common {
        box-shadow: 1px 2px 5px #999;
        transition: all .3s;
    }

    .card-common:hover {
        box-shadow: 2px 3px 15px #999;
        transform: translateY(-1px);
    }

    table {
        table-layout: fixed;
    }

    .table td {
        padding: 0.75rem;
        font-size: smaller;
    }

    #dashboard-analytics table tr th {
        font-size: 11px;
        padding: 9px;
    }


    html body.navbar-sticky .app-content .content-wrapper {
        padding: 0rem 2.5rem;
        margin-top: 0px;
    }

</style>

{{-- Font Awesome CDN --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"> --}}


@endsection

@section('content')
<section id="dashboard-analytics">
    {{-- Dashboard Start --}}
    <div class="container-fluid">
        <!-- <div class="row">
            <div class="col-md-12">
                <div class="card card-mt">
                    <div class="card-content">
                        <div class="card-body card-body-p">
                            <div class="text-center">
                                <h3>Welcome To {{ Config::get('app.name') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="row mt-40">
            <div class="col-xl-12 col-md-8 col-lg-12 ml-auto">
                <div class="row">

                    <div class="col-xl-3 col-sm-3 pl-1 mt-2">
                        <div class="card card-common card-mt1">
                            <div class="card-body card-body-p" style="background: linear-gradient(#fffc95b8, #b8bb8ad1);">
                                <div class="d-flex justify-content-between">
                                    <i class="fas fa-shopping-cart fa-3x text-warning"></i>
                                    <div class="text-right text-secondary">
                                        <h5>Total Customer</h5>
                                        @foreach ($vw_dashboard_count as $item)
                                        <h5>  <?php echo $item->customer_count; ?> </h5>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-3 pl-1 mt-2">
                        <div class="card card-common">
                            <div class="card-body card-body-p" style="background: linear-gradient(#2bffd8b8, #d9ff3bdb);">
                                <div class="d-flex justify-content-between">
                                    <i class="fas fa-money-bill-alt fa-3x text-success"></i>
                                    <div class="text-right text-secondary">
                                        <h5>Total Sell</h5>

                                        @foreach ($vw_dashboard_count as $item)
                                        <h5>  <?php echo $item->total_amount; ?> </h5>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-3 pl-1 mt-2">
                        <div class="card card-common">
                            <div class="card-body card-body-p" style="background: linear-gradient(#41f3f3e0, #fff79b);">
                                <div class="d-flex justify-content-between">
                                    <i class="fas fa-users fa-3x text-info"></i>
                                    <div class="text-right text-secondary">
                                        <h5>Total Employee</h5>
                                        @foreach ($vw_dashboard_count as $data)
                                        <h5>  <?php echo $data->total_employee; ?> </h5>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(auth()->user()->getRoles()->pluck( 'role_key' )->contains('hydrography_admin'))

                    <div class="col-xl-3 col-sm-3 pl-1 mt-2">
                        <div class="card card-common">
                            <div class="card-body card-body-p" >
                                <div class="d-flex justify-content-between">
                                    <i class="fas fa-bell fa-4x text-info" aria-hidden="true"></i>
                                    <form>
                                        <div class="text-right text-secondary">
                                            <a class="btn" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                <h5>Notifications <i class="ficon bx bx-bell bx-tada bx-flip-horizontal bg-color_name"></i>{{count($hydros_notification)}}</h5>
                                            </a>
                                            <div class="collapse text-left" id="collapseExample">
                                                {{--@json($hydros_notification)--}}
                                                @foreach ($hydros_notification as $notifications)
                                                    <ul><li onclick="update_notification('{{$notifications->hydro_notification_id}}')" id ="{{$notifications->hydro_notification_id}}" class="sec-title hydro_notification"><span>{{$notifications->message}}</span></li></ul>
                                                @endforeach
                                            </div>

                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                        @endif
                </div>
            </div>
        </div>

        <div class="row mb-2 mt-40">

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12 card card-body-p">
{{--                        <div class="text-left text-secondary">--}}

{{--                            <h5>Notifications {{count($hydros_notification)}}</h5>--}}
{{--{{dd($hydros_notification)}}--}}
{{--                            @foreach ($hydros_notification as $notifications)--}}
{{--                             <ul><li>{{$notifications->message}}</li></ul>--}}
{{--                            @endforeach--}}

{{--                        </div>--}}
{{--                        <p>--}}
{{--                            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">--}}
{{--                                Notifications <i class="ficon bx bx-bell bx-tada bx-flip-horizontal text-white"></i>--}}
{{--                                {{count($hydros_notification)}}--}}
{{--                            </a>--}}

{{--                        </p>--}}
{{--                        <div class="collapse" id="collapseExample">--}}

{{--                                @foreach ($hydros_notification as $notifications)--}}
{{--                                    <ul><li>{{$notifications->message}}</li></ul>--}}
{{--                                @endforeach--}}

{{--                        </div>--}}
                        <h3 class="text-muted text-center mb-1">Recent Payment</h3>
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead class="thead-light">
                                <tr class="text-muted">
                                    <th>Order id</th>
                                    <th>Customer name</th>
                                    <th>Order Date</th>
                                    <th>Payment Date</th>
                                    <th>Delivery Date</th>
                                    <th>Confirmed By</th>
                                    <th>Confirmed Date</th>

                                </tr>
                            </thead>
                            <tbody>

                                {{--SELECT c.CUSTOMER_NAME,
                                    (SELECT EMP_NAME FROM V_EMPLOYEE VE WHERE VE.EMp_ID = PO.CONFIRMED_BY) CONFIRMED_BY,
                                    (SELECT EMP_NAME FROM V_EMPLOYEE VE WHERE VE.EMp_ID = PO.FILE_UPLOAD_COMPLETE_BY) FILE_UPLOAD_COMPLETE_BY,

                                    PO.ORDER_DATE,PO.PAYMENT_COMPLETED_DATE,PO.TENTATIVE_CONFIRMATION,PO.FILE_UPLOAD_COMPLETE_DATE
                                    FROM PRODUCT_ORDER PO
                                    LEFT JOIN CUSTOMER C ON PO.CUSTOMER_ID = C.CUSTOMER_ID
                                    WHERE PO.PAYMENT_COMPLETED_YN = 'Y'
                                    ORDER BY PO.PRODUCT_ORDER_ID DESC;
                                    --}}
                                    @if(isset($vw_recent_payment) && count($vw_recent_payment) > 0)

                                    @foreach ($vw_recent_payment as $item)
                                    {{--   @json($item)--}}
                                    <tr>
                                        <td>@if(isset($item->product_order_id)){{$item->product_order_id}}@endif</td>
                                        <td>
                                            @if(isset($item->customer_name))

                                            {{$item->customer_name}}

                                            @endif

                                        </td>
                                        <td>


                                            @if(isset($item->order_date))
                                            {{date('Y-m-d', strtotime($item->order_date))}}

                                            @endif

                                        </td>
                                        <td>
                                            @if(isset($item->payment_completed_date))
                                            {{date('Y-m-d', strtotime($item->payment_completed_date))}}

                                            @endif
                                        </td>

                                        <td>
                                            @if(isset($item->tentative_confirmation))
                                            {{date('Y-m-d', strtotime($item->tentative_confirmation))}}

                                            @endif


                                            <td>

                                                @if(isset($item->file_upload_complete_by))

                                                {{$item->file_upload_complete_by}}
                                                @endif
                                            </td>
                                            <td>


                                                @if(isset($item->file_upload_complete_date))
                                                {{date('Y-m-d', strtotime($item->file_upload_complete_date))}}

                                                @endif

                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 card card-body-p">
                                    <h3 class="text-muted text-center mb-1">Schedule Plan</h3>
                                    <table id="example" class="table table-striped text-nowrap table-bordered" style="width:100%">
                                        <thead class="thead-light">
                                            <tr class="text-muted">
                                                <th>Schedule Name</th>
                                                <th>Schedule Type</th>
                                                <th>From Date</th>
                                                <th>To Date</th>
                                                <th>Status</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($approved_schedules) && count($approved_schedules) > 0)

                                            @foreach ($approved_schedules as $approved_schedule)
                                            <tr>
                                                <td>

                                                    @if(isset($approved_schedule->schedule_name))
                                                        {{$approved_schedule->schedule_name}}
                                                    @endif

                                                </td>
                                                <td>
                                                    @if(isset($approved_schedule->schedule_type))

                                                    {{$approved_schedule->schedule_type->schedule_type_name}}

                                                    @endif

                                                </td>
                                                <td>


                                                    @if(isset($approved_schedule->schedule_from_date))
                                                    {{date('Y-m-d', strtotime($approved_schedule->schedule_from_date))}}

                                                    @endif

                                                </td>
                                                <td>
                                                    @if(isset($approved_schedule->schedule_to_date))
                                                    {{date('Y-m-d', strtotime($approved_schedule->schedule_to_date))}}

                                                    @endif
                                                </td>

                                                <td>
                                                    @if($approved_schedule->approved_yn == 'Y')
                                                        <span class="badge badge-pill badge-primary">Approved</span>
                                                    @endif
                                                </td>

                                            </tr>
                                            @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" align="center"><span>No data Found</span></td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{--<div class="row">
                          <div class="col-md-6">
                            <div id="piechart" class="card-common">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="chart_div" class="pie-chart  card-common"></div>
                        </div>
                    </div>--}}
                    {{--  Static Table  --}}

                    {{-- <div class="row">
                        <div class="col-md-6">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                  <h3 class="box-title text-center">Latest Orders</h3>

                              </div>
                              <!-- /.box-header -->
                              <div class="box-body" style="">
                                  <div class="table-responsive">
                                    <table class="table no-margin">
                                      <thead>
                                          <tr>
                                            <th>Order ID</th>
                                            <th>Item</th>
                                            <th>Status</th>
                                            <th>Popularity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                        <td>Call of Duty IV</td>
                                        <td><span class="label label-success">Shipped</span></td>
                                        <td>
                                          <div class="sparkbar" data-color="#00a65a" data-height="20"><canvas style="display: inline-block; vertical-align: top;"></canvas></div>
                                      </td>
                                  </tr>
                                  <tr>
                                    <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                    <td>Samsung Smart TV</td>
                                    <td><span class="label label-warning">Pending</span></td>
                                    <td>
                                      <div class="sparkbar" data-color="#f39c12" data-height="20"><canvas style="display: inline-block; vertical-align: top;"></canvas></div>
                                  </td>
                              </tr>
                              <tr>
                                <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                <td>iPhone 6 Plus</td>
                                <td><span class="label label-danger">Delivered</span></td>
                                <td>
                                  <div class="sparkbar" data-color="#f56954" data-height="20"><canvas style="display: inline-block; vertical-align: top;"></canvas></div>
                              </td>
                          </tr>
                          <tr>
                            <td><a href="pages/examples/invoice.html">OR7429</a></td>
                            <td>Samsung Smart TV</td>
                            <td><span class="label label-info">Processing</span></td>
                            <td>
                              <div class="sparkbar" data-color="#00c0ef" data-height="20"><canvas style="display: inline-block; vertical-align: top;"></canvas></div>
                          </td>
                      </tr>
                      <tr>
                        <td><a href="pages/examples/invoice.html">OR1848</a></td>
                        <td>Samsung Smart TV</td>
                        <td><span class="label label-warning">Pending</span></td>
                        <td>
                          <div class="sparkbar" data-color="#f39c12" data-height="20"><canvas style="display: inline-block; vertical-align: top;"></canvas></div>
                      </td>
                  </tr>

              </tbody>
          </table>
      </div>
      <!-- /.table-responsive -->
  </div>
  <!-- /.box-body -->
  <div class="box-footer clearfix" style="">
      <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
      <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-right">Place New Order</a>


  </div>

</div>
</div>
</div> --}}

</section>

@endsection

@section('footer-script')

    <script type="text/javascript">


        function update_notification(id){
            console.log(id);
            var url = '{{ route("dashboard-notification-update") }}';


            var notification_data = {};
            notification_data.hydro_notification_id= id;


            console.log(notification_data);
            $.ajax({
                type: "POST",
                url: url,
                data: notification_data,
                success: function (resp) {
                    console.log(resp);

                    if(resp.o_status_code == "1"){
                        alertify.success(resp.o_status_message);
                    }else {
                        alertify.error(resp.o_status_message);
                    }
                },
                error: function (resp) {
                    console.log(resp);
                    alert('error');
                }
            });
        }
        $(document).ready(function(){

            $("ol.breadcrumb").addClass('hidden');

            $('.example-popover').popover({
                container: 'body'
            })



            $(".hydro_notification").on("click",function () {

                var id = $(this).attr(id);
                console.log(id);

            });

            $(".sec-title").click(function(){
                $(this).addClass("text-success");
            });
        });
    </script>

    <!-- jQuery library -->


@endsection
