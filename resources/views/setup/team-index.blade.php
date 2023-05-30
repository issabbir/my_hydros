@extends('layouts.default')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection
@section('content')
    {{--@json($team)--}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Table Start -->
                <div class="card-body">
                    <h4 class="card-title">Team Setup</h4>
                    <hr>
                    @if(Session::has('message'))
                        <div class="alert {{Session::get('m-class') ? Session::get('m-class') : 'alert-danger'}} show"
                             role="alert">
                            {{ Session::get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <form id="frmTeamSetup" name="frmTeamSetup" @if(isset($team->team_id)) action="{{route('setup.team-update',
                    [$team->team_id])}}"
                          @else action="{{route('setup.team-post')}}" @endif method="post">
                        @csrf
                        @if (isset($team->team_id))
                            @method('PUT')
                        @endif
                        <div class="row">


                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="team_type_id" class="required">Team Type</label>
                                    <select class="custom-select select2 form-control" required id="team_type_id"
                                            name="team_type_id" readonly="readonly">
                                        <option value="">Select One</option>
                                        @if(isset($teamTypes))
                                            @foreach($teamTypes as $teamType)
                                                <option value="{{$teamType->team_type_id}}"
                                                        @if(isset($team->team_type_id) &&
                                                        ($team->team_type_id == $teamType->team_type_id))
                                                        selected
                                                    @endif
                                                >{{$teamType->team_type_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="water_vessel_no" class="required">Team Name</label>
                                    <input required
                                           type="text"
                                           class="form-control"
                                           id="team_name"
                                           name="team_name"
                                           placeholder="Enter Team Name"
                                           value="{{old('team_name',isset($team->team_name) ? $team->team_name : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="water_vessel_name_bn">Team Name(Bangla)</label>
                                    <input type="text"
                                           class="form-control bn-lang-val-check"
                                           id="team_name_bn"
                                           name="team_name_bn"
                                           placeholder="Enter Team Name(Bangla)"
                                           value="{{old('team_name_bn',isset($team->team_name_bn) ? $team->team_name_bn : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>


                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="team_description">Team Description</label>
                                    <input type="text"
                                           class="form-control"
                                           id="team_description"
                                           name="team_description"
                                           placeholder="Enter Team Description"
                                           value="{{old('team_description',isset($team->team_description) ? $team->team_description : '')}}"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="active_to" class="required">Formation Date</label>
                                    <input type="text"
                                           autocomplete="off"
                                           class="form-control"
                                           data-toggle="datetimepicker"
                                           id="team_formation_date"
                                           data-target="#active_to"
                                           name="team_formation_date"
                                           placeholder="YYYY-MM-DD"
                                           required
                                           data-date-format="yyyy-mm-dd"
                                           value="{{old('team_formation_date',isset
                                           ($team->team_formation_date) ?
                                           date('Y-m-d',strtotime($team->team_formation_date)) : '')}}"/>
                                    <small class="text-muted form-text"> </small>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="active_to">Termination Date</label>
                                    <input type="text"
                                           autocomplete="off"
                                           class="form-control"
                                           data-toggle="datetimepicker"
                                           id="team_termination_date"
                                           data-target="#active_to"
                                           name="team_termination_date"
                                           placeholder="YYYY-MM-DD"

                                           data-date-format="yyyy-mm-dd"
                                           value="{{old('team_termination_date',isset
                                           ($team->team_termination_date) ?
                                            date('Y-m-d',strtotime($team->team_termination_date)): '')}}"/>
                                    <small class="text-muted form-text"> </small>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="active_yn" class="required">Active?</label>
                                    <ul class="list-unstyled mb-0">
                                        <li class="d-inline-block mr-2 mb-1">
                                            <fieldset>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="active_yn"
                                                           id="active_yes"
                                                           value="{{\App\Enums\YesNoFlag::YES}}"
                                                           @if($team && ($team->active_yn == \App\Enums\YesNoFlag::YES))
                                                           checked
                                                           @elseif(!$team)
                                                           checked
                                                        @endif
                                                    />
                                                    <label class="custom-control-label" for="active_yes"> Yes </label>
                                                </div>
                                            </fieldset>
                                        </li>
                                        <li class="d-inline-block mr-2 mb-1">
                                            <fieldset>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="active_yn"
                                                           id="active_no"
                                                           value="{{\App\Enums\YesNoFlag::NO}}"
                                                           @if($team && ($team->active_yn != \App\Enums\YesNoFlag::YES))
                                                           checked
                                                        @endif
                                                    />
                                                    <label class="custom-control-label" for="active_no"> No </label>
                                                </div>
                                            </fieldset>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 pr-0 d-flex justify-content-end">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary mr-1 mb-1">Save</button>

                                <a href="{{route('setup.team-index')}}">
                                    <input type="button" class="btn btn-light-secondary mb-1" value="Reset" />
                                </a>

                            </div>
                        </div>
                    </form>
                </div>
                <!-- Table End -->
            </div>


            @include('setup.team-datatable-list')


        </div>
    </div>


    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Team Type
    </button>

    <!-- Modal -->
    <div class="modal fade" id="teamTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Team Type</h5>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>

                {{-- Main Body --}}

                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">

                            @if(isset($teamTypes))
                                @foreach($teamTypes as $teamType)
                                    {{--         <option value="{{$teamType->team_type_id}}"
                                                     @if(isset($team->team_type_id) &&
                                                     ($team->team_type_id == $teamType->team_type_id))
                                                     selected
                                                 @endif
                                             >{{$teamType->team_type_name}}</option>
                                    --}}
                                    <div class="col-md-6">
                                        <button id="{{$teamType->team_type_id}}" type="button"
                                                class="btn btn-secondary select-team-type">{{$teamType->team_type_name}}</button>
                                    </div>


                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('footer-script')
    <script type="text/javascript">


        function teamList() {
            $('#tbl_team').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{route('setup.team-datatable-list')}}',
                    'type': 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', "name": 'DT_RowIndex'},

                    {data: 'team_name'},
                    {data: 'team_description'},
                    {data: 'active'},
                    {data: "action"},
                ]
            });
        }


        $(document).ready(function () {

            /*var team_edit = '{{$team_id}}';
            //console.log('team_edit',team_edit);

            if(team_edit == null || team_edit == ''){

                $('#teamTypeModal').modal({
                    backdrop: 'static',
                    keyboard: false  // to prevent closing with Esc button (if you want this too)
                });
            }*/


            $(document).on("click", ".select-team-type", function () {
                var team_type_id = $(this).attr('id');

                $('#team_type_id').val(team_type_id).change();
                $("#team_type_id").css("pointer-events","none");
                $('#team_type_id').attr('disabled', 'disabled');
                $('#teamTypeModal').modal('hide');
            });


            function makeDate(dateStr) {
                var formparts = dateStr.split("-");
                var fromDate = new Date(formparts[0], formparts[1] - 1, formparts[2]);
                return fromDate;
            }


            $("form[name='frmTeamSetup']").validate({
                errorElement: "span", // contain the error msg in a small tag
                errorClass: 'help-block error',
                errorPlacement: function (error, element) { // render error placement for each input type
                    if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
                        error.insertAfter($(element).closest('.form-group').children('div').children().last());
                    } else if (element.hasClass("ckeditor")) {
                        error.appendTo($(element).closest('.form-group'));
                    } else {
                        error.insertAfter(element);
                        // for other inputs, just perform default behavior
                    }
                },
                ignore: "",
                rules: {

                    team_name:{
                        required: true
                    }
                    /*team_termination_date: {
                        required: true,
                    },*/
                    //        team_termination_date: {teamDateGreaterThan: "#team_formation_date"}

                },
                // Specify validation error messages
                messages: {
                    // team_termination_date: "Please enter a termination date greater than formation date",
                },
                highlight: function (element) {
                    $(element).closest('.help-block').removeClass('valid');
                    // display OK icon
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                    // add the Bootstrap error class to the control group
                },
                unhighlight: function (element) { // revert the change done by hightlight
                    $(element).closest('.form-group').removeClass('has-error');
                    // set error class to the control group
                },
                success: function (label, element) {
                    label.addClass('help-block valid');
                    // mark the current input as valid and display OK icon
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                },
                // Make sure the form is submitted to the destination defined
                // in the "action" attribute of the form when valid
                submitHandler: function (form) {

                    var team_formation_date = $('#team_formation_date').val();
                    var team_termination_date = $('#team_termination_date').val();

                    if (!(team_termination_date == "" || team_termination_date == undefined || team_termination_date == null)

                        && (makeDate(team_formation_date) > makeDate(team_termination_date)

                        )

                    ) {

                        alertify.error('Termination date must greater than formation date');
                        return;
                    }

                    var url =  $(form).attr('action');
                    console.log(url);
                    $('#team_type_id').removeAttr('disabled');
                    var data = {};
                    data.team_type_id = $('#team_type_id').val();
                    data.team_name = $('#team_name').val();
                    data.team_name_bn = $('#team_name_bn').val();
                    data.team_description = $('#team_description').val();
                    data.team_formation_date = $('#team_formation_date').val();
                    data.team_termination_date = $('#team_termination_date').val();

                    console.log(data);

                  //  $(form).trigger("reset");
                    form.submit();
                    return;

                }
            });


            $('#team_formation_date').datepicker({
                autoclose: true,
                todayHighlight: true,
                startDate: "now()",
                orientation: "bottom auto",
            });

            $('#team_termination_date').datepicker({
                autoclose: true,
                todayHighlight: true,
                //minDate:new Date()
                //startDate: "now()"
                orientation: "bottom auto",
            });
            /*$('#team_formation_date').datepicker({
                autoclose: true,
                todayHighlight: true,
                //minDate:new Date()
                //startDate: "now()"
            });*/
            teamList();
        });
    </script>

@endsection

