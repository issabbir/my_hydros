<div id="status-show" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-uppercase text-left">
                    Edit Employee
                </h4>
                <button class="close" type="button" data-dismiss="modal" area-hidden="true">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <form id="workflow_form" method="post" action="{{route('schedule.boat-employee-setup-update')}}">
                    {!! csrf_field() !!}
                    <div class="row mb-1">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <ul class="step-progressbar">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="card-body">
                                    <h4 class="card-title">Boat Member Setup</h4>
                                    <hr>
                                    <div class="row">
                                        <input type="hidden" id="hidden_boat_employee_id_modal" name="hidden_boat_employee_id_modal">
                                        <input type="hidden" id="vehicle_id_modal" name="vehicle_id_modal">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="designation_id"
                                                       class="required">Designation</label>
                                                <select class="form-control pl-0 pr-0 designation_id_modal select2"
                                                        required
                                                        name="designation_id_modal">
                                                    <option value="">Select One</option>
                                                    @if(isset($designations))
                                                        @foreach($designations as $designation)
                                                            <option
                                                                value="{{$designation->designation_id}}"
                                                            >{{$designation->designation}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group empId">
                                                <label for="emp_id" class="required">Employee</label>
                                                <select class="form-control select2 emp_id_modal" required name="emp_id_modal">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="name">Mobile Number</label>
                                                <input required
                                                       type="text"
                                                       class="form-control mobile_number_modal"
                                                       name="mobile_number_modal"
                                                       placeholder="Enter Mobile Number"
                                                >
                                                <small class="text-muted form-text"></small>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="team_leader_yn" class="required">Team Leader</label>
                                                <select required name="team_leader_yn_modal" class="custom-select mr-sm-2 team_leader_yn_modal">
                                                    <option  value="{{\App\Enums\YesNoFlag::YES}}"
                                                    >YES</option>
                                                    <option value="{{\App\Enums\YesNoFlag::NO}}"
                                                    >NO</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="required">Assign From</label>
                                                <input type="text"
                                                       autocomplete="off"
                                                       class="form-control datetimepicker-input start_date_modal"
                                                       data-toggle="datetimepicker"
                                                       id="start_date_modal"
                                                       data-target="#start_date_modal"
                                                       name="start_date_modal"
                                                       value=""
                                                       placeholder="YYYY-MM-DD"
                                                >
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="required">Assign To</label>
                                                <input type="text"
                                                       autocomplete="off"
                                                       class="form-control datetimepicker-input end_date_modal"
                                                       data-toggle="datetimepicker"
                                                       id="end_date_modal"
                                                       data-target="#end_date_modal"
                                                       name="end_date_modal"
                                                       value=""
                                                       placeholder="YYYY-MM-DD"
                                                >
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="active_yn" class="required">Active?</label>
                                                <select required name="active_yn_modal" class="custom-select mr-sm-2 active_yn_modal">
                                                    <option
                                                        value="{{\App\Enums\YesNoFlag::YES}}"
                                                        >YES</option>
                                                    <option
                                                        value="{{\App\Enums\YesNoFlag::NO}}"> NO</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 form-group d-flex align-items-center justify-content-end pt-2">
                                            <button class="btn btn-secondary  text-nowrap px-1 updateBtn" type="submit">
                                                Update
                                            </button>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .modal {
        padding: 0 !important;
    }

    .modal .modal-dialog {

        max-width: none;
        height: 80%;
        margin: 80px 150px;
    }

    .modal .modal-content {
        height: 100%;
        border: 0;
        border-radius: 0;
    }

    .modal .modal-body {
        font-size: small;
        overflow-y: auto;
    }

    /*.modal-body .table td, .modal-body .table th {
        padding: 7px;
        vertical-align: top;
    }*/

    .step-progressbar {
        list-style: none;
        counter-reset: step;
        display: flex;
        padding: 0;
    }

    .step-progressbar__item {
        display: flex;
        flex-direction: column;
        flex: 1;
        text-align: center;
        position: relative;
    }

    .step-progressbar__item:before {
        width: 3em;
        height: 3em;
        content: counter(step);
        counter-increment: step;
        align-self: center;
        background: #999;
        color: #fff;
        border-radius: 100%;
        line-height: 3em;
        margin-bottom: 0.5em;
    }

    .step-progressbar__item:after {
        height: 2px;
        width: calc(100% - 4em);
        content: "";
        background: #999;
        position: absolute;
        top: 1.5em;
        left: calc(50% + 2em);
    }

    .step-progressbar__item:last-child:after {
        content: none;
    }

    .step-progressbar__item--active:before {
        background: #000;
    }

    .step-progressbar__item--complete:before {
        content: "✔";
    }
</style>

