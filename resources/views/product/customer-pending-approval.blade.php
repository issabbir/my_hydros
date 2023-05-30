@extends('layouts.default')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection
@section('content')
    <div class="row">
        <div class="col-12">

{{--
            @json($customers)
--}}
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">All Customer List</h4>
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table id="tbl_customer_list" class="table table-sm datatable mdl-data-table
                                    dataTable">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Customer Name</th>
                                            <th>Customer Description</th>
                                            <th>Mobile No</th>
                                            <th>Application Date</th>

                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($customers as $customer)
                                            <tr id="{{$customer->customer_temp_registration_id}}">
                                                <td> {{$customer->customer_temp_registration_id}} </td>
                                                <td> {{$customer->customer_name}} </td>
                                                <td> {{$customer->customer_description}} </td>
                                                <td> {{$customer->mobile_number}} </td>
                                                <td> {{ date( 'Y-m-d' , strtotime($customer->application_time) )}}
                                                </td>


                                                <td>

                                                    <a class="text-primary approvebutton"  onclick=""><i class="bx bx-check-circle
                                                     cursor-pointer"></i>&nbsp;|</a>
                                                    <a class="text-primary rejectbutton"  onclick=""><i class="bx
                                                     bx-minus-circle cursor-pointer"></i></a>

                                                </td>

                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
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

        //tbl_customer_list
        $(function () {
            $('#tbl_customer_list').DataTable();

            $('.approvebutton').click(function (e) {
                e.preventDefault();
                console.log('approvebutton');

                if(confirm("Are you sure to approve?")){
                    var id = $(this).closest('tr').attr('id');
                    var approved_yn = '{{\App\Enums\YesNoFlag::YES}}';
                   // approveRejectCustomer(id,approved_yn,re,this);
                    var that = this;

                    var remarks = 'This is demo remarks';
                    var url = '{{ route("product.customer-approval-confirmation", ":id") }}';
                    url = url.replace(':id', id);
                    console.log(id);

                    var approveData = {};
                    approveData.approved_yn = approved_yn;
                    approveData.remarks = remarks;

                    console.log(approveData);
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: approveData,
                        success: function (resp) {
                            console.log(resp);

                            if(resp.o_status_code == "1"){

                                alert(resp.o_status_message);
                                $(that).closest('tr').remove();

                            }else {
                                alert(resp.o_status_message);
                            }
                        },
                        error: function (resp) {
                            console.log(resp);
                            alert('error');
                        }
                    });

                }


            });


            $('.rejectbutton').click(function (e) {
                e.preventDefault();

                if(confirm("Are you sure to reject?")){

                    var id = $(this).closest('tr').attr('id');
                    var approved_yn = '{{\App\Enums\YesNoFlag::NO}}';
                    // approveRejectCustomer(id,approved_yn,re,this);
                    var that = this;

                    var remarks = 'This is demo remarks';
                    var url = '{{ route("product.customer-approval-confirmation", ":id") }}';
                    url = url.replace(':id', id);
                    console.log(id);

                    var approveData = {};
                    approveData.approved_yn = approved_yn;
                    approveData.remarks = remarks;

                    console.log(approveData);
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: approveData,
                        success: function (resp) {
                            console.log(resp);

                            if(resp.o_status_code == "1"){

                                alert(resp.o_status_message);
                                $(that).closest('tr').remove();

                            }else {
                                alert(resp.o_status_message);
                            }
                        },
                        error: function (resp) {
                            console.log(resp);
                            alert('error');
                        }
                    });

                }



            });
        });

    </script>

@endsection

