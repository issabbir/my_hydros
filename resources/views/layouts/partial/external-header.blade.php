<nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top navbar-light">

	<div class="navbar-wrapper" style="background:#122b5a;">
		<div class="navbar-container content">
			<div class="navbar-collapse" id="navbar-mobile">
				<div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
					<ul class="nav navbar-nav">
						<li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon bx bx-menu text-white"></i></a></li>
					</ul>

				</div>

				<div class="mx-auto order-0 d-none d-lg-block font-weight-bold">
					<a class="navbar-brand text-white" href="{{route('external-user.dashboard')}}">CHITTAGONG PORT AUTHORITY</a>
				</div>

				<ul class="nav navbar-nav float-right">

					<li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon bx bx-fullscreen text-white"></i></a></li>

					{{--<li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon bx bx-bell bx-tada bx-flip-horizontal text-white"></i><span class="badge badge-pill badge-danger badge-up">1</span></a>
						<ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
							<li class="dropdown-menu-header">
								<div class="dropdown-header px-1 py-75 d-flex justify-content-between"><span class="notification-title">1 new Notification</span><span class="text-bold-400 cursor-pointer">Mark all as read</span></div>
							</li>
							<li class="scrollable-container media-list"><a class="d-flex justify-content-between" href="javascript:void(0)">
									<div class="media d-flex align-items-center">
										<!--div class="media-left pr-0">
                                            <div class="avatar mr-1 m-0"><img src="../../../app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="39" width="39"></div>
                                        </div-->
										<div class="media-body">
											<h6 class="media-heading"><span class="text-bold-500">National Holiday</span> for Durga Puja</h6><small class="notification-text">Oct 06 12:32pm</small>
										</div>
									</div></a>

							</li>
							<li class="dropdown-menu-footer"><a class="dropdown-item p-50 text-primary justify-content-center" href="javascript:void(0)">Read all notifications</a></li>
						</ul>
					</li>--}}

                    <li class="dropdown dropdown-notification nav-item">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle"
                           href="#" role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false"
                        >

                          {{--  <i class="fa fa-shopping-cart" style="width: 18px; height: 16px"></i> {{ \Cart::getTotalQuantity()}}--}}
                             <span class="badge badge-pill badge-success" style="padding-right: 8px">
                            <i class="fa fa-shopping-cart" style="width: 15px; height: 13px; margin: 2px; padding-right: 1px"></i> {{ \Cart::getTotalQuantity()}}
                        </span>

                        </a>


                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="width: 450px; padding: 0px; border-color: #9DA0A2">
                            <ul class="list-group" style="margin: 20px;">
                                @include('layouts.partial.cart-drop')
                            </ul>

                        </div>
                    </li>
					<li class="dropdown dropdown-user nav-item">
						<a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
{{--
							@auth--}}
							{{--<span>
                                    <img class="round"
										 @if (!Auth::user()->employee->emp_photo)
										 src="data:image/png;base64,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"
										 @else
										 src="{{Auth::user()->employee->emp_photo}}"
										 @endif

										 alt="avatar" height="40" width="40"/>
                                    </span>--}}
							<div class="user-nav d-sm-flex d-none text-white">
                                        <span class="user-name">
                                            {{--@json( Auth::guard('customer')->user())--}}

											@if(Auth::guard('customer')->check())
												<span>{{Auth::guard('customer')->user()->customer_name}}</span>
											@endif
                                        </span>
								<span class="user-status">&nbsp;
									{{ Auth::guard('customer')->user()->email }}
                                        </span>
							</div>
						</a>
						<div class="dropdown-menu dropdown-menu-right pb-0">
                            {{--<a class="dropdown-item" href="#"><i class="bx bx-user mr-50"></i>Profile</a><!--a class="dropdown-item" href="app-email.html"><i class="bx bx-envelope mr-50"></i> My Inbox</a><a class="dropdown-item" href="app-todo.html"><i class="bx bx-check-square mr-50"></i> Task</a><a class="dropdown-item" href="app-chat.html"><i class="bx bx-message mr-50"></i> Chats</a-->
							<div class="dropdown-divider mb-0"></div>--}}
							<a class="dropdown-item" href="{{ route('logout', [app()->getLocale()]) }}"
							   onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">
								{{ __('Logout') }}
							</a>

							<form id="logout-form" action="{{ route('logout',[app()->getLocale()]) }}" method="POST" style="display: none;">
								@csrf
							</form>
						</div>
						{{--@endauth--}}
					</li>
				</ul>
			</div>
		</div>

		<div class="row">
            <div class="col-md-12">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-dark text-white border-0 rounded-0" id="basic-addon1">All NEWS :</span>
                    </div>

                    @php
                        $sql = "select cpa_security.cpa_general.get_active_news from dual";
                        $_news = DB::select($sql);
                    @endphp
                    <marquee class="form-control rounded-0" onmouseover="this.stop();" onmouseout="this.start();">
                        <div class="d-flex align-items-center">
                            @foreach($_news as $news)



                                <a href="#" style="color: black;" news_id="{{$news->news_id}}" class="dynamicModal"> <i class="bx bx-label"></i>
                                    <span>&nbsp;{{$news->title_bn}}</span>
                                </a>
                            @endforeach
                        </div>
                    </marquee>
                </div>
            </div>

            <div id="dynamicNewsModal" class="modal fade bd-example-modal-lg pr-0"  role="dialog" aria-labelledby="myLargeModalLabel"  data-backdrop="false"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content " id="dynamicNewsModalContent">

                    </div>
                </div>
            </div>

			{{--<div class="col-md-12 bg-white">
				<ol class="breadcrumb pb-0 mb-0 bg-rgba-secondary rounded-0">
					<li class="breadcrumb-item"><a href="{{ route('external-user.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
					@if(\App\Helpers\HelperClass::breadCrumbs(\Illuminate\Support\Facades\Route::currentRouteName()))
						@foreach(\App\Helpers\HelperClass::breadCrumbs(\Illuminate\Support\Facades\Route::currentRouteName()) as $bm)
                            --}}{{--<div>
                                @json($bm)
                            </div>--}}{{--
							--}}{{--<li class="breadcrumb-item mb-1 {{!empty($bm['action_name'])?'active':''}}">
								<a href="{{!empty($bm['action_name'])?(route($bm['action_name'])):'#'}}">{{$bm['submenu_name']}}</a>
							</li>--}}{{--
						@endforeach

                        @else
                        <li class="breadcrumb-item mb-1 active">
                            <a id="breadcrumb-header" href="{{ route('external-user.dashboard') }}">Dashbaord</a>
                        </li>
					@endif
				</ol>
			</div>--}}
		</div>


	</div>
</nav>
