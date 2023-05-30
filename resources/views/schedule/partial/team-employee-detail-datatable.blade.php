
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>

        </div>
    </div>
</div>
<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('New message to ' + recipient)
        modal.find('.modal-body input').val(recipient)
    })
</script>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <h4 class="card-title">Team Employee List</h4>

                <div class="card-content">
                    <div class="table-responsive">
                        <table id="tbl_employee_team" class="table table-sm datatable mdl-data-table dataTable">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Team Name</th>
                                <th>Designation</th>
                                <th>Emp Name</th>
                                <th>Mobile no</th>
                                <th>Team Leader</th>

                                <th>Active</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if(isset($queryResult) && count($queryResult) > 0)
                                @foreach($queryResult as $queryResults)

                                    <tr id="{{$queryResults->team_employee_id}}">
                                        {{--<td> {{$queryResults->team_employee_id}} </td>--}}
                                        <td> {{$queryResults->sl}} </td>
                                        <td> {{$queryResults->team_name}} </td>
                                        <td> {{$queryResults->designation}} </td>
                                        <td> {{$queryResults->emp_name}} </td>
                                        <td> {{$queryResults->mobile_no}} </td>
                                        <td> {{$queryResults->team_leader_yn == 'Y' ? 'Yes':'No'}} </td>


                                        <td> {{$queryResults->active_yn == 'Y' ? 'Yes':'No'}} </td>


                                        <td>
                                <a ml="4" target="_blank" href="{{route('setup.team-employee-index',['teamId'=>$queryResults->team_id, 'queryResults' => $queryResults->team_name])}}"  class="text-primary teamEmployeeEdit"><i class="bx bx-plus-circle cursor-pointer"></i></a>

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


