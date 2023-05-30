@extends('layouts.default')

@section('title')
    Shift Setup
@endsection

@section('header-style')
    <!--Load custom style link or css-->

@endsection
@section('content')

    <div class="content-body">
        <section id="form-repeater-wrapper">
            <!-- form default repeater -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @if(Session::has('message'))
                            <div
                                class="alert {{Session::get('m-class') ? Session::get('m-class') : 'alert-danger'}} show"
                                role="alert">
                                {{ Session::get('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="card-content">
                            <div class="card-body">
                                <form enctype="multipart/form-data"
                                      @if(isset($data->shift_id)) action="{{route('schedule.shift-setup-update',[$data->shift_id])}}"
                                      @else action="{{route('schedule.shift-setup-post')}}" @endif method="post">
                                    @csrf
                                    @if (isset($data->shift_id))
                                        <input type="hidden" name="shift_id" value="{{$data->shift_id}}">
                                        @method('PUT')
                                    @endif

                                    <h5 class="card-title">Shift Setup</h5>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3 mt-1">
                                            <div class="form-group">
                                                <label for="shift_from_time" class="required">Time From</label>
                                                <input type="text" required
                                                       autocomplete="off"
                                                       class="form-control from-timepicker"
                                                       id="shift_from_time"
                                                       name="shift_from_time"
                                                       placeholder="HH:mm"
                                                       value="{{old('shift_from_time',isset
                                           ($data->shift_from_time) ?
                                           date('H:i',strtotime($data->shift_from_time)) : '')}}"/>
                                                <small class="text-muted form-text"> </small>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 mt-1">
                                            <div class="form-group">
                                                <label for="shift_to_time" class="required">Time To</label>
                                                <input type="text"
                                                       autocomplete="off"
                                                       class="form-control"
                                                       id="shift_to_time"
                                                       name="shift_to_time"
                                                       placeholder="HH:mm"
                                                       required
                                                       value="{{old('shift_to_time',isset
                                           ($data->shift_to_time) ?
                                           date('H:i',strtotime($data->shift_to_time)) : '')}}"/>
                                                <small class="text-muted form-text"> </small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12 pr-0 d-flex justify-content-end">
                                            <div class="form-group">
                                                @if(!isset($data))
                                                    <button id="boat-employee-save" type="submit"
                                                            class="btn btn-primary mr-1 mb-1">Save
                                                    </button>
                                                @else
                                                    <button id="boat-employee-save" type="submit"
                                                            class="btn btn-primary mr-1 mb-1">Update
                                                    </button>
                                                @endif
                                                <a type="reset" href="{{route("schedule.shift-setup-index")}}"
                                                   class="btn btn-light-secondary mb-1"> Back</a>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ form default repeater -->

        </section>
    </div>

    <div class="card">
        <div class="card-body">
            <section id="horizontal-vertical">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Shift List</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table id="shift-list"
                                               class="table table-sm datatable mdl-data-table dataTable">
                                            <thead>
                                            <tr>
                                            <tr>
                                                <th>#</th>
                                                <th>Shift Start Time</th>
                                                <th>Shift End Time</th>
                                                <th>Action</th>
                                            </tr>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection

@section('footer-script')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">

        $('#shift-list tbody').on('click', '.removeData', function () {
            let row_id = $(this).data("pilotageid");
            dltData(row_id);
        });

        function dltData(row_id) {
            let url = '{{route('schedule.shift-remove')}}';
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'GET',
                        url: url,
                        data: {row_id: row_id},
                        success: function (msg) {
                            if (msg == 0) {
                                Swal.fire({
                                    title: 'Can not remove data. Something went wrong.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                Swal.fire({
                                    title: 'Entry Successfully Deleted!',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(function () {
                                    $('#shift-list').DataTable().ajax.reload();
                                });
                            }
                        }
                    });
                }
            });
        }

        function shiftList() {
            let url = '{{route('schedule.shift-setup-datatable-list')}}';
            let oTable = $('#shift-list').DataTable({
                processing: true,
                serverSide: true,
                order: [],
                ajax: {
                    url: url,
                    'type': 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'shift_from_time', name: 'shift_from_time', searchable: true},
                    {data: 'shift_to_time', name: 'shift_to_time', searchable: true},
                    {data: 'action', name: 'action', searchable: false},
                ]
            });
        };

        $('.from-timepicker').wickedpicker({
            title: 'From',
            twentyFour: true,
            now: "9:00"
        });


        $('#shift_to_time').wickedpicker({
            title: 'To',
            twentyFour: true,
            now: "17:00",
        });


        $(document).ready(function () {
            shiftList();
            //$('#shift_to_time').val('');
            //$('.from-timepicker').val('');
        });
    </script>

@endsection

