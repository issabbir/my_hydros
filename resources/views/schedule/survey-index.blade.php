@extends('layouts.default')

@section('title')

@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection
@section('content')

    <div class="row">
        <h1>Add Edit Delete Table Row Example using JQuery - ItSolutionStuff.com</h1>

        <form>

            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" class="form-control" value="Paresh" required="">
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="text" name="email" class="form-control" value="paresh@gmail.com" required="">
            </div>


            <div class="col-sm-8">
                <div class="form-group">
                    <label for="team_id" class="required">Team </label>
                    <select class="custom-select select2 form-control" required id="team_id" name="team_id">
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

            <button type="submit" class="btn btn-success save-btn">Save</button>

        </form>
        <br/>
        <table class="table table-bordered data-table">
            <thead>
            <th>Name</th>
            <th>Email</th>
            <th width="200px">Action</th>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>




    <div class="modal fade" id="edit-survey-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form name="frm-add-to-cart" id="frm-add-to-cart" method="post" action="{{route('external-user.cart-add')}}">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Purchase Request Details </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-sm-12">
                                <div class="form-group">

                                    <label for="team_id" class="required">Team </label>
                                    <select class="custom-select select2 form-control" required id="modal_team_id" name="modal_team_id">
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
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="to_date" class="required">To Date </label>
                                    <input placeholder="YYYY-MM-DD"
                                           type="text"
                                           class="form-control tentative-delivery"
                                           id="to_date"
                                           name="to_date"
                                           data-date-format="yyyy-mm-dd"
                                           required
                                           autocomplete="off"
                                    >
                                    <small class="text-muted form-text"></small>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="file_category_name" class="required">Preferred Format </label>
                                    <select  required class=" form-control" id="file_format_name"
                                             name="file_format_name" >
                                        {{--<option value="">Select One</option>--}}
                                        @if(isset($fileFormats))
                                            @foreach($fileFormats as $fileFormat)
                                                <option value="{{$fileFormat->file_format_name}}"
                                                        @if(isset($product_details->file_format_id) &&
                                                        ($product_details->file_format_id == $fileFormat->file_format_id))
                                                        selected
                                                    @endif
                                                >{{$fileFormat->file_format_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    {{--  <small class="text-muted form-text"></small>--}}
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="order-confirm" type="submit" class="btn btn-primary" >Confirm
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection




@section('footer-script')


<script type="text/javascript">

    $("form").submit(function (e) {
        e.preventDefault();
        var name = $("input[name='name']").val();
        var email = $("input[name='email']").val();
        var team_id = $('#team_id option:selected').val();
        var team_text = $('#team_id option:selected').text();

        var tr = "<tr "+ "data_team_id='"+ team_id +"'" +" data-name='" + name + "' data-email='" + email + "'>";

        tr = tr + "<td>" + name + "</td>";
        tr = tr + "<td>" + email + "</td>";
        tr = tr + "<td>" + team_text + "</td>";

        tr = tr + "<td><button class='btn btn-info btn-xs btn-edit'>Edit</button><button class='btn btn-danger btn-xs btn-delete'>Delete</button></td>";
        tr = tr + "</tr>";

        console.log(tr);

        var trr = "<tr data-name='" + name + "' data-email='" + email + "'><td>" + name + "</td><td>" + email + "</td><td><button class='btn btn-info btn-xs btn-edit'>Edit</button><button class='btn btn-danger btn-xs btn-delete'>Delete</button></td></tr>"

        console.log(trr);
        $(".data-table tbody").append(tr);

        $("input[name='name']").val('');
        $("input[name='email']").val('');
    });

    $("body").on("click", ".btn-delete", function () {
        $(this).parents("tr").remove();
    });

    $("body").on("click", ".btn-edit", function () {

        var  team_id= $(this).parents("tr").attr('data_team_id');
        $('#modal_team_id').val(team_id).change();


        $('#edit-survey-modal').modal({
            show: true,
            backdrop: 'static'
        });
     /*   var name = $(this).parents("tr").attr('data-name');
        var email = $(this).parents("tr").attr('data-email');

        $(this).parents("tr").find("td:eq(0)").html('<input name="edit_name" value="' + name + '">');
        $(this).parents("tr").find("td:eq(1)").html('<input name="edit_email" value="' + email + '">');

        $(this).parents("tr").find("td:eq(2)").prepend("<button class='btn btn-info btn-xs btn-update'>Update</button><button class='btn btn-warning btn-xs btn-cancel'>Cancel</button>")
        $(this).hide();*/
    });

    $("body").on("click", ".btn-cancel", function () {
        var name = $(this).parents("tr").attr('data-name');
        var email = $(this).parents("tr").attr('data-email');

        $(this).parents("tr").find("td:eq(0)").text(name);
        $(this).parents("tr").find("td:eq(1)").text(email);

        $(this).parents("tr").find(".btn-edit").show();
        $(this).parents("tr").find(".btn-update").remove();
        $(this).parents("tr").find(".btn-cancel").remove();
    });

    $("body").on("click", ".btn-update", function () {
        var name = $(this).parents("tr").find("input[name='edit_name']").val();
        var email = $(this).parents("tr").find("input[name='edit_email']").val();

        $(this).parents("tr").find("td:eq(0)").text(name);
        $(this).parents("tr").find("td:eq(1)").text(email);

        $(this).parents("tr").attr('data-name', name);
        $(this).parents("tr").attr('data-email', email);

        $(this).parents("tr").find(".btn-edit").show();
        $(this).parents("tr").find(".btn-cancel").remove();
        $(this).parents("tr").find(".btn-update").remove();
    });

</script>
@endsection
