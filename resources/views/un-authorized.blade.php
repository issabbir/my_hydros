<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .code {
            border-right: 2px solid;
            font-size: 26px;
            padding: 0 15px 0 15px;
            text-align: center;
        }

        .message {
            font-size: 18px;
            text-align: center;
        }
        body {
            background-color: #2a3f54;
            text-align: center;
            color:#73879c;
        }
        ul {
            list-style-type: none;
        }

        a {
            color:#73879c;

        }
        a:link {
            text-decoration: none;
        }
        a:hover, a:active {
            color:#0D8BBD;
        }
    </style>
</head>
<body>

<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- Table Start -->
            <div class="card-body">
                <div class="col-sm-8">
                    <div class="main-error mb-xlg">
                        <br>
                        <h2 style="font-size:100px; font-weight: bold">404 <i class="fa fa-file"></i>
                        </h2>
                        <p style="font-size:25px; font-weight: bold">We're sorry, but the page you were looking for doesn't exist.</p>
                    </div>
                </div>

                <div class="col-sm-4">
                    <h4 style="font-size:30px; font-weight: bold" class="text">Here are some useful links</h4>
                    <form id="logout-form" action="{{ route('logout',[app()->getLocale()]) }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <ul>
                        <li style="font-size:20px; font-weight: bold"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <br>
                        <li style="font-size:20px; font-weight: bold"><a href="javascript:formSubmit()">Log Out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function formSubmit() {
        document.getElementById("logout-form").submit();
    }

</script>

</body>
</html>
