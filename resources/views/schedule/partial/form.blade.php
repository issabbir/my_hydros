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
                            <div class="defaultSection" style="display: none">
                                <div data-repeater-item>
                                    <div class="row justify-content-between">
                                        <div class="row">
                                            <div class="card-body">
                                                <h4 class="card-title">Boat Member Setup</h4>
                                                <hr>
                                                <div class="row">
                                                    <input type="hidden" id="hidden_boat_employee_id" name="hidden_boat_employee_id">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="designation_id"
                                                                   class="required">Designation</label>
                                                            <select class="form-control pl-0 pr-0 designation_id"

                                                                    required
                                                                    name="designation_id[]">
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
                                                        <div class="form-group">
                                                            <label for="emp_id" class="required">Employee</label>
                                                            <select required class="form-control pl-0 pr-0 emp_id"
                                                                    name="emp_id[]">
                                                                <option value="">Select One</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="name">Mobile Number</label>
                                                            <input required
                                                                   type="text"
                                                                   class="form-control mobile_number"

                                                                   name="mobile_number[]"
                                                                   placeholder="Enter Mobile Number"
                                                            >
                                                            <small class="text-muted form-text"></small>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="team_leader_yn" class="required">Team Leader</label>
                                                            <select required name="team_leader_yn[]" class="custom-select mr-sm-2 team_leader_yn">
                                                                <option  value="{{\App\Enums\YesNoFlag::YES}}"
                                                                >YES</option>
                                                                <option value="{{\App\Enums\YesNoFlag::NO}}"
                                                                >NO</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    {{--<div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="required">Assign From</label>
                                                            <input type="date"
                                                                   autocomplete="off"
                                                                   class="form-control"
                                                                   name="start_date[]"
                                                                   value=""
                                                                   placeholder="YYYY-MM-DD"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="required">Assign To</label>
                                                            <input type="date"
                                                                   autocomplete="off"
                                                                   class="form-control"
                                                                   name="end_date[]"
                                                                   value=""
                                                                   placeholder="YYYY-MM-DD"
                                                            >
                                                        </div>
                                                    </div>--}}

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="active_yn" class="required">Active?</label>
                                                            <select required name="active_yn[]" class="custom-select mr-sm-2 active_yn">
                                                                <option
                                                                    value="{{\App\Enums\YesNoFlag::YES}}"
                                                                    @if($boat_employee && ($boat_employee->active_yn == \App\Enums\YesNoFlag::YES))
                                                                    selected
                                                                    @elseif(!$boat_employee)
                                                                    selected
                                                                    @endif >YES</option>
                                                                <option
                                                                    value="{{\App\Enums\YesNoFlag::NO}}"
                                                                    @if($boat_employee && ($boat_employee->active_yn != \App\Enums\YesNoFlag::YES))
                                                                    selected
                                                                    @endif> NO</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 form-group d-flex align-items-center justify-content-end pt-2">
                                                        <button class="btn btn-danger  text-nowrap px-1 deleteFight"
                                                                data-repeater-delete type="button"><i
                                                                class="bx bx-x"></i>
                                                            Delete
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                    <hr>
                                </div>
                            </div>
                            <form class="form repeater-default">
                                @csrf

                                <h5 class="card-title">Boat List</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 pl-1">
                                        <div class="form-group">
                                            <label for="team_id" class="required">Boat </label>
                                            <select class="custom-select select2 form-control" required id="vehicle_id" name="vehicle_id">
                                                <option value="">Select One</option>
                                                @if(isset($vehicles))
                                                    @foreach($vehicles as $vehicle)
                                                        <option value="{{$vehicle->vehicle_id}}">
                                                            {{$vehicle->vehicle_name}}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    {{--<div class="col-md-4 mt-2 pl-1 pr-0 d-flex justify-content-end">
                                        <div class="form-group">
                                            <button id="add-boat" type="button"
                                                    class="btn btn-primary mr-1 mb-1">Add Boat
                                            </button>
                                        </div>
                                    </div>--}}
                                </div>
                                <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h4 class="card-title">Boat Employee List</h4>
                                                    <div class="card-content">
                                                        <div class="table-responsive">
                                                            <table id="tbl_employee_team" class="table table-sm datatable mdl-data-table dataTable">
                                                                <thead>
                                                                <tr>
                                                                    <th>SL</th>
                                                                    <th>Boat Name</th>
                                                                    <th>Emp Name</th>
                                                                    <th>Designation</th>
                                                                    <th>Mobile number</th>
                                                                    <th>Start Date</th>
                                                                    <th>End Date</th>
                                                                    <th>Team Leader</th>
                                                                    <th>Active</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if(isset($boat_employees) && count($boat_employees) > 0)
                                                                    @foreach($boat_employees as $boat_employee)
                                                                        <tr id="{{$boat_employee->boat_employee_id}}">
                                                                            <td> {{$boat_employee->boat_employee_id}} </td>
                                                                            <td> {{$boat_employee->team_name}} </td>
                                                                            <td> {{$boat_employee->emp_name}} </td>
                                                                            <td>
                                                                                @if(isset($boat_employee->mobile_number))
                                                                                    {{$boat_employee->mobile_number}}
                                                                                @endif

                                                                            </td>
                                                                            <td> {{$boat_employee->designation}} </td>
                                                                            <td> {{$boat_employee->team_leader_yn == 'Y' ? 'Yes':'No'}} </td>
                                                                            <td> {{$boat_employee->active_yn == 'Y' ? 'Yes':'No'}} </td>


                                                                            <td>
                                                                                <a ml="4" target="_self" href="#" class="text-primary teamEmployeeEdit"><i class="bx bx-edit cursor-pointer"></i></a>
                                                                                <a target="_self" href="#" class=" text-danger teamEmployeeRemove" role="button"><i class="bx bx-trash cursor-pointer"></i></a>
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
                                                                <tfoot>
                                                                <tr><td colspan="8"><button class="btn btn-secondary" type="button" onclick="$('#form_boot_emp').toggle('slow'); datePicker('.datetimepicker-input');">Add New</button></td></tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                               <div style="display: none" id="form_boot_emp">
                                        @foreach ($defaultData as $k => $emps)
                                            <div class="repeatingSection">
                                            <div data-repeater-item>
                                                <div class="row justify-content-between">
                                                    <div class="row">
                                                        <div class="card-body">
                                                            <h4 class="card-title">Boat Member Setup</h4>
                                                            <hr>
                                                            <div class="row">
                                                                <input type="hidden" id="hidden_boat_employee_id" name="hidden_boat_employee_id">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="designation_id"
                                                                               class="required">Designation</label>
                                                                        <select class="select2 form-control pl-0 pr-0 designation_id"
                                                                                required
                                                                                name="designation_id[]">
                                                                            <option value="">Select One</option>
                                                                            @if(isset($designations))
                                                                                @foreach($designations as $designation)
                                                                                    <option
                                                                                        value="{{$designation->designation_id}}"
                                                                                        @if(isset($team_employee->designation_id) &&
                                                                                            ($team_employee->designation_id == $designation->designation_id))
                                                                                            selected
                                                                                        @elseif ($k == $designation->designation_id)
                                                                                            selected
                                                                                        @endif
                                                                                    >{{$designation->designation}}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="emp_id" class="required">Employee</label>
                                                                        <select required class="form-control ipl-0 pr-0 emp_id select2"
                                                                                name="emp_id[]">
                                                                            <option value="">Select One</option>
                                                                            @if($emps)
                                                                                 @php  $employees = $emps; @endphp
                                                                            @endif
                                                                            @if(isset($employees))
                                                                                @foreach($employees as $employee)
                                                                                    <option value="{{$employee->emp_id}}"
                                                                                            @if(isset($team_employee->emp_id) &&
                                                                                            ($team_employee->emp_id == $employee->emp_id))
                                                                                            selected
                                                                                        @endif
                                                                                    >{{$employee->emp_name}}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="name">Mobile Number</label>
                                                                        <input required
                                                                               type="text"
                                                                               class="form-control mobile_number"

                                                                               name="mobile_number[]"
                                                                               placeholder="Enter Mobile Number"
                                                                        >
                                                                        <small class="text-muted form-text"></small>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label for="team_leader_yn" class="required">Team Leader</label>
                                                                        <select required name="team_leader_yn[]" class="custom-select mr-sm-2 team_leader_yn">
                                                                            <option  value="{{\App\Enums\YesNoFlag::YES}}"
                                                                                     @if($boat_employee && ($boat_employee->team_leader_yn == \App\Enums\YesNoFlag::YES))
                                                                                     selected
                                                                                @endif
                                                                            >YES</option>
                                                                            <option value="{{\App\Enums\YesNoFlag::NO}}"
                                                                                    @if($boat_employee && ($boat_employee->team_leader_yn != \App\Enums\YesNoFlag::YES))
                                                                                    selected
                                                                                    @elseif(!$boat_employee)
                                                                                    selected
                                                                                @endif
                                                                            >NO</option>

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                {{--<div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="required">Assign From</label>
                                                                        <input type="date"
                                                                               autocomplete="off"
                                                                               class="form-control"

                                                                               name="start_date[]"
                                                                               value=""
                                                                               placeholder="YYYY-MM-DD"
                                                                        >
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="required">Assign To</label>
                                                                        <input type="date"
                                                                               autocomplete="off"
                                                                               class="form-control"

                                                                               name="end_date[]"
                                                                               value=""
                                                                               placeholder="YYYY-MM-DD"
                                                                        >
                                                                    </div>
                                                                </div>--}}
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label for="active_yn" class="required">Active?</label>
                                                                        <select required name="active_yn[]" class="custom-select mr-sm-2 active_yn">
                                                                            <option
                                                                                value="{{\App\Enums\YesNoFlag::YES}}"
                                                                                @if($boat_employee && ($boat_employee->active_yn == \App\Enums\YesNoFlag::YES))
                                                                                selected
                                                                                @elseif(!$boat_employee)
                                                                                selected
                                                                                @endif >YES</option>
                                                                            <option
                                                                                value="{{\App\Enums\YesNoFlag::NO}}"
                                                                                @if($boat_employee && ($boat_employee->active_yn != \App\Enums\YesNoFlag::YES))
                                                                                selected
                                                                                @endif> NO</option>

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 form-group d-flex align-items-center justify-content-end pt-2">
                                                                    <button class="btn btn-danger  text-nowrap px-1 deleteFight"
                                                                            data-repeater-delete type="button"><i
                                                                            class="bx bx-x"></i>
                                                                        Delete
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                            @php  $employees = []; @endphp
                                        @endforeach
                                        <div class="form-group">
                                    <div class="col p-0">
                                        <button class="btn btn-primary addFight" data-repeater-create type="button"><i
                                                class="bx bx-plus"></i>
                                            Add
                                        </button>
                                    </div>
                                            <div class="col-md-12 pr-0 d-flex justify-content-end">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="required">Assign From</label>
                                                        <input type="date"
                                                               autocomplete="off"
                                                               class="form-control"

                                                               name="start_date"
                                                               value=""
                                                               placeholder="YYYY-MM-DD"
                                                        >
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="required">Assign To</label>
                                                        <input type="date"
                                                               autocomplete="off"
                                                               class="form-control"

                                                               name="end_date"
                                                               value=""
                                                               placeholder="YYYY-MM-DD"
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                    <div class="col-md-12 pr-0 d-flex justify-content-end">
                                        <div class="form-group">
                                            <button id="boat-employee-save" type="button"
                                                    class="btn btn-primary mr-1 mb-1">Save
                                            </button>
                                            <input id="boat-employee-reset" type="reset"
                                                   class="btn btn-light-secondary mb-1" value="Reset"/>
                                        </div>
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



