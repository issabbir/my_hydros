@extends('layouts.default')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection
@section('content')
    {{--
    @json($contact_managements)
--}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">Contact Management Detail</h4>
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table id="tbl_team_employee"
                                           class="table table-sm datatable mdl-data-table dataTable">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Place</th>
                                            <th>Contactor name</th>
                                            <th>Contractor mobile</th>
                                            <th>Contact date</th>
                                            <th>Contact Type</th>
                                            <th>Completion Date</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($contact_managements) && count($contact_managements) > 0)

                                            @foreach($contact_managements as $contact_management)
                                                <tr id="{{$contact_management->contact_management_id}}">
                                                    <td> {{$loop->iteration}} </td>
                                                    <td> {{$contact_management->place}} </td>
                                                    <td> {{$contact_management->contactor_name}} </td>

                                                    <td> {{$contact_management->contractor_mobile}} </td>
                                                    <td> {{$contact_management->contact_date}} </td>
                                                    <td> {{$contact_management->contact_type}} </td>
                                                    <td> {{$contact_management->completion_date}} </td>
                                                    <td>

                                                        @if($contact_management->status == 'FINISHED')

                                                            <span
                                                                class="badge badge-pill badge-success">FINISHED
                                                            </span>

                                                        @else
                                                            <span
                                                                class="badge badge-pill badge-danger">
                                                                ONGOING
                                                            </span>

                                                        @endif

                                                    </td>

                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td id="emptyRow" colspan="5">
                                                    No data found
                                                </td>
                                            </tr>
                                        @endif

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


    </script>

@endsection

