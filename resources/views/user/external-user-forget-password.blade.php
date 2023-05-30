@extends('layouts.auth')

@section('content')
	<section class="row flexbox-container">
		<div class="col-xl-7 col-10">
			<div class="row m-0">
				<!-- left section-login -->
				<div class="col-md-6 col-12 px-0 bg-rgba-cblack">
					<form name="forget-password" class="" action="{{ route('forget_password_check') }}" method="post">
						<div class="card-header pb-0">
							<div class="card-title">
								<img src="{{asset('/assets/images/logo/cpa-logo.png')}}" alt="users view avatar" class="img-fluid mx-auto d-block">
								<h4 class="text-center mt-1 text-white">Forget Password</h4>
								<h4 class="text-center mt-1 text-white">Please enter your email</h4>
							</div>
						</div>
						<div class="card-content">
							<div class="card-body">
								@if ($errors->has('error'))
									<div class="alert alert-dismissible alert-danger">
										<button type="button" class="close" data-dismiss="alert">&times;</button>
										<strong></strong> {{ $errors->first('error') }}
									</div>
								@endif
								@if (session()->has('message'))
									<div class="alert alert-dismissible {{session()->get('m-class')}}">
										<button type="button" class="close" data-dismiss="alert">&times;</button>
										<strong></strong> {{ session()->get('message') }}
									</div>
								@endif
								<div class="form-group">
									<label class="text-bold-600 text-white" for="exampleInputPassword1">Email *</label>
									<input type="text" class="form-control" name="email" id="email"
										   placeholder="Email" >
								</div>

							</div>
						</div>

						<div class="card-content">
							<div class="card-body">
								<button type="submit" class="btn btn-primary glow position-relative w-100">
									Check<!--i id="icon-arrow" class="bx bx-right-arrow-alt"></i-->
								</button>
								<hr>
								<div class="text-center row">
								 <div class="col-md-12">

									 <a href="{{ route('external-user-registration') }}"
										class="text-white col-md-2"><small>Register</small></a>

									 <a href="{{ route('external-user-login') }}" class="text-white col-md-8
"><small>Login</small></a>

								 </div>
								</div>
							</div>
							<div class="float-right text-light">
								<small>Operation and Maintenance by</small>
								<a class="text-primary font-weight-bold " href="https://site.cnsbd.com" target="_blank">
									<img src="{{asset('/assets/images/logo/cns-logo-w.png')}}" alt="cns_logo" class="img-fluid mb-1"/>
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
            $("form[name='forget-password']").validate({
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
                // Specify validation rules
                rules: {

                    email: {
                        required: true,
                        email: true
                    },

                },
                // Specify validation error messages
                messages: {
                    email: "Please enter a valid email address",

                },

                submitHandler: function (form) {
                    form.submit();
                }
            });
        })
    </script>

@endsection
