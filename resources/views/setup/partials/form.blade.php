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
                                                <h4 class="card-title">Survey Member Setup</h4>
                                                <hr>
                                                <div class="row">
                                                    <input type="hidden" id="hidden_team_employee_id"
                                                           name="hidden_team_employee_id">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="designation_id"
                                                                   class="required">Designation</label>
                                                            <select
                                                                class=" custom-select form-control pl-0 pr-0 designation_id"

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
                                                            <select required class="form-control ipl-0 pr-0 emp_id"
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
                                                                   class="form-control mobile_no"

                                                                   name="mobile_no[]"
                                                                   placeholder="Enter Mobile Number"
                                                            >
                                                            <small class="text-muted form-text"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="description">Email</label>
                                                            <input type="email"
                                                                   class="form-control email"

                                                                   name="email[]"
                                                                   placeholder="Enter email"

                                                            >
                                                            <small class="text-muted form-text"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="team_leader_yn" class="required">Team
                                                                Leader</label>
                                                            <select required name="team_leader_yn[]"
                                                                    class="custom-select mr-sm-2 team_leader_yn">
                                                                <option value="{{\App\Enums\YesNoFlag::NO}}"

                                                                >NO
                                                                </option>
                                                                <option value="{{\App\Enums\YesNoFlag::YES}}"
                                                                >YES
                                                                </option>


                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="active_yn" class="required">Active?</label>
                                                            <select required name="active_yn[]"
                                                                    class="custom-select mr-sm-2 active_yn">
                                                                <option
                                                                    value="{{\App\Enums\YesNoFlag::YES}}"
                                                                    >YES
                                                                </option>
                                                                <option
                                                                    value="{{\App\Enums\YesNoFlag::NO}}"
                                                                  > NO
                                                                </option>

                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-md-2 form-group d-flex align-items-center justify-content-end pt-2">
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
                                <h5 class="card-title">Team List</h5>
                                <hr>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="team_id" class="required">Team </label>
                                        <select class="custom-select select2 form-control" required id="team_id"
                                                name="team_id">
                                            <option value="">Select One</option>
                                            @if(isset($teams))
                                                @foreach($teams as $t)
                                                    <option value="{{$t->team_id}}"
                                                            @if(isset($team->team_id) &&
                                                            ($team->team_id == $t->team_id))
                                                            selected
                                                        @endif
                                                    >{{$t->team_name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="repeatingSection">
                                    <div data-repeater-item>
                                        <div class="row justify-content-between">
                                            <div class="row">
                                                <div class="card-body">
                                                    <h4 class="card-title">Survey Member Setup</h4>
                                                    <hr>
                                                    <div class="row">
                                                        <input type="hidden" id="hidden_team_employee_id"
                                                               name="hidden_team_employee_id">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="designation_id"
                                                                       class="required">Designation</label>
                                                                <select
                                                                    class="select2 custom-select form-control pl-0 pr-0 designation_id"

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
                                                                <select required class="select2 form-control ipl-0 pr-0 emp_id"
                                                                        name="emp_id[]">
                                                                    <option value="">Select One</option>
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
                                                                       class="form-control mobile_no"

                                                                       name="mobile_no[]"
                                                                       placeholder="Enter Mobile Number"
                                                                >
                                                                <small class="text-muted form-text"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="description">Email</label>
                                                                <input type="email"
                                                                       class="form-control email"

                                                                       name="email[]"
                                                                       placeholder="Enter email"

                                                                >
                                                                <small class="text-muted form-text"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="team_leader_yn" class="required">Team
                                                                    Leader</label>
                                                                <select required name="team_leader_yn[]"
                                                                        class="custom-select mr-sm-2 team_leader_yn">
                                                                    <option value="{{\App\Enums\YesNoFlag::YES}}"
                                                                            @if($team_employee && ($team_employee->team_leader_yn == \App\Enums\YesNoFlag::YES))
                                                                            selected
                                                                        @endif
                                                                    >YES
                                                                    </option>
                                                                    <option value="{{\App\Enums\YesNoFlag::NO}}"
                                                                            @if($team_employee && ($team_employee->team_leader_yn != \App\Enums\YesNoFlag::YES))
                                                                            selected
                                                                            @elseif(!$team_employee)
                                                                            selected
                                                                        @endif
                                                                    >NO
                                                                    </option>

                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="active_yn" class="required">Active?</label>
                                                                <select required name="active_yn[]"
                                                                        class="custom-select mr-sm-2 active_yn">
                                                                    <option
                                                                        value="{{\App\Enums\YesNoFlag::YES}}"
                                                                        @if($team_employee && ($team_employee->active_yn == \App\Enums\YesNoFlag::YES))
                                                                        selected
                                                                        @elseif(!$team_employee)
                                                                        selected
                                                                        @endif >YES
                                                                    </option>
                                                                    <option
                                                                        value="{{\App\Enums\YesNoFlag::NO}}"
                                                                        @if($team_employee && ($team_employee->active_yn != \App\Enums\YesNoFlag::YES))
                                                                        selected
                                                                        @endif> NO
                                                                    </option>

                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-md-2 form-group d-flex align-items-center justify-content-end pt-2">
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
                                <div class="form-group">
                                    <div class="col p-0">
                                        <button class="btn btn-primary addFight" data-repeater-create type="button"><i
                                                class="bx bx-plus"></i>
                                            Add
                                        </button>
                                    </div>
                                    <div class="col-md-12 pr-0 d-flex justify-content-end">
                                        <div class="form-group">
                                            <button id="team-employee-save" type="button"
                                                    class="btn btn-primary mr-1 mb-1">Save
                                            </button>
                                            <input id="team-employee-reset" type="reset"
                                                   class="btn btn-light-secondary mb-1" value="Reset"/>
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



