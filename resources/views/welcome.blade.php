{{--
Hello wolrd {{ $author }}

<form action="{{url('/save')}}" method="POST">
    <input type="text" name="someName" />
    <input type="submit">
</form>
--}}


        <!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>


    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap-datepicker/css/datepicker.css') }}">
    <script src="{{ asset('assets/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>

    --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>


</head>
<body>

<div class="container">

	<strong> My config file  
	{{ Config::get('app.url') }}
 </strong>

    <form action="{{ route('admin.save-zone-area')}}" method="POST" >

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">SheetNo</label>
                <input type="text" class="form-control" id="sheet_no" name="sheet_no" >
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Proposed Name</label>
                <input type="text" class="form-control" id="proposed_name" name="proposed_name" >
            </div>
        </div>
        <input type="submit" value="save">
    </form>

    <a href="{{ url('/param/group',[1])  }}">hello [$val->id]</a>
    <h1>My First Bootstrap Page</h1>
    <p>This part is inside a .container class.</p>
    <p>The .container class provides a responsive fixed width container.</p>
    <p>Resize the browser window to see that its width (max-width) will change at different breakpoints.</p>

    <div class="col-md-12">
        <form action="{{url('/saveStudent')}}" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="akash">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name">DOB</label>
                    <input type="text" class="form-control" id="datetimepicker" name="dob" autocomplete="off" >
                </div>
            </div>

            <div class="form-group">
                <label for="profilePicture">Profile Picture</label>
                <input type="file" class="form-control-file" id="profilePicture" name="profilePicture">
            </div>
            <button type="submit" class="btn btn-primary">Sign in</button>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker').datepicker({
            format: 'dd-M-yy'
        });
		
		var APP_URL = "{{Config::get('app.url')}}";
		console.log(APP_URL);

    });
</script>
</body>
</html>
