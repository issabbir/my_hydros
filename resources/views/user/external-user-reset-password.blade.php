@extends('layouts.auth')

@section('header-style')
    <!--Load custom style link or css-->

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css", rel="stylesheet", integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN", crossorigin="anonymous">
@endsection
@section('content')
    <section class="row flexbox-container">
        <div class="col-xl-7 col-10">
            <div class="row m-0">
                <!-- left section-login -->
                <div class="col-md-6 col-12 px-0 bg-rgba-cblack">
                    <form name="forget-passwrod" class="" action="{{ route('forget_password_save') }}"
                          method="post">
                        <div class="card-header pb-0">
                            <div class="card-title">
                                <img src="{{asset('/assets/images/logo/cpa-logo.png')}}" alt="users view avatar"
                                     class="img-fluid mx-auto d-block">
                                <h4 class="text-center mt-1 text-white">User Registration</h4>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">

                                @if ($errors->any())
                                    <div class="alert alert-dismissible alert-danger">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                       <strong></strong> {{ $errors->first() }}
                                    </div>
                                @endif
                                @if (session()->has('message'))
                                    <div class="alert alert-dismissible alert-success">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong></strong> {{ session()->get('message') }}
                                    </div>
                                @endif
                                    <div>
                                        <input  type="hidden" name="forget_password_token" id="forget_password_token"
                                                value="{{$user_registration->forget_password_token}}">
                                    </div>
                                <div class="form-group hidden" >
                                    <label class="text-bold-600 text-white" for="email">Email*</label>
                                    <input type="text"

                                           class="form-control" name="email"
                                           id="email"
                                           placeholder="Enter email"
                                           value="{{old('email',isset($user_registration->email) ?
                                           $user_registration->email : '')}}"
                                    >
                                </div>

                                <div class="form-group">
                                    <label class="text-bold-600 text-white" for="password">Password *</label>
                                    <input type="password" class="form-control" id="user_password"
                                           placeholder="Password" name="user_password"
                                           required>
                                </div>
                                <div class="form-group">
                                    <label class="text-bold-600 text-white" for="confirmPassword">Confirm Password
                                        *</label>
                                    <input type="password" class="form-control" id="confirmPassword"
                                           placeholder="Confirm Password" name="confirm_user_password"
                                           required
                                           autocomplete="off">
                                </div>


                                <div class="form-group">
                                    <div class="captcha">
                                        <span>{!! captcha_img() !!}</span>
                                        <div><i class="fa fa-refresh" id="refresh"></i></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha"
                                           name="captcha" autocomplete="off"></div>

                            </div>
                        </div>

                        <div class="card-content">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary glow position-relative w-100">
                                    Confirm<!--i id="icon-arrow" class="bx bx-right-arrow-alt"></i-->
                                </button>

                            </div>
                            <div class="float-right text-light">
                                <small>Operation and Maintenance by</small>
                                <a class="text-primary font-weight-bold " href="https://site.cnsbd.com" target="_blank">
                                    <img src="{{asset('/assets/images/logo/cns-logo-w.png')}}" alt="cns_logo"
                                         class="img-fluid mb-1"/>
                                </a>
                            </div>
                        </div>
                        {!! csrf_field() !!}
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer-script')
    <script type="text/javascript">
        // Wait for the DOM to be ready
        $(function () {

            $('#refresh').click(function(){
                $.ajax({
                    type:'GET',
                    url:'{{route('refreshcaptcha')}}',
                    success:function(data){
                        $(".captcha span").html(data.captcha);
                    }
                });
            });


            var value = $("#user_password").val();

            $.validator.addMethod("checklower", function(value) {
                return /[a-z]/.test(value);
            });
            $.validator.addMethod("checkupper", function(value) {
                return /[A-Z]/.test(value);
            });
            $.validator.addMethod("checkdigit", function(value) {
                return /[0-9]/.test(value);
            });
            // Initialize form validation on the registration form.
            // It has the name attribute "registration"
            $("form[name='forget-passwrod']").validate({
                errorElement: "span", // contain the error msg in a small tag
                errorClass: 'help-block',
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
                // Specify validation rules
                rules: {
                    // The key name on the left side is the name attribute
                    // of an input field. Validation rules are defined
                    // on the right side
                    user_password: {
                        required: true,
                        minlength: 6,
                        checklower: true,
                        checkupper: true,
                        checkdigit: true
                    },
                    confirm_user_password: {
                        required: true,
                        minlength: 6,
                        equalTo : "#user_password"
                    },
                    agree_term_and_condition: {
                        required: true
                    }

                },
                // Specify validation error messages
                messages: {
                    user_password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 6 characters long",
                        checklower: "Need atleast 1 lowercase alphabet",
                        checkupper: "Need atleast 1 uppercase alphabet",
                        checkdigit: "Need atleast 1 digit"

                    },
                    confirm_user_password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 6 characters long",
                        equalTo : "Password does not match"

                    }
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
                    form.submit();
                }
            });
        })
    </script>

@endsection
