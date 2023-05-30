<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow expanded" data-scroll-to-active="true" style="touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
	<div class="navbar-header expanded">
		<ul class="nav navbar-nav flex-row">
			<li class="nav-item mr-auto">
				<a class="navbar-brand mt-0" href="{{route('external-user.dashboard')}}">
					<img src="{{asset('assets/images/logo/cpa-logo.png')}}" alt="users view avatar" class="img-fluid">
				</a>
			</li>
			<li class="nav-item nav-toggle">
				<a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
					<i class="bx bx-x d-block d-xl-none font-medium-4 primary"></i>
					<i class="toggle-icon bx-disc font-medium-4 d-none d-xl-block primary bx" data-ticon="bx-disc"></i>
				</a>
			</li>
		</ul>
	</div>
	<div class="shadow-bottom"></div>
	<div class="main-menu-content mt-1 ps">
		<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="lines">
			<li class="nav-item none open has-sub"><a href=""><i class="bx bx-notepad" data-icon="users"></i><span class="menu-item" data-i18n="Invoice List">
                        Hydrography  Portal</span>
                </a>
				<ul class="menu-content">

                    <li id="menu-dashboard" class="">
                        <a href="{{route('external-user.dashboard')}}" class="link_item"><i class="bx bx-right-arrow-alt"></i><span
                                class="menu-item" data-i18n="Third Level">Dashboard</span></a>
                    </li>

                    <li id="menu-request-submitted" class="">
                        <a href="{{route('external-user.product-request-index')}}" class="link_item"><i class="bx bx-right-arrow-alt"></i><span
                                class="menu-item" data-i18n="Third Level">Request Submit</span></a>
                    </li>

                    <li id="menu-approval-status" class="">
                        <a href="{{route('external-user.approved-request-index')}}" class="link_item"><i class="bx bx-right-arrow-alt"></i><span
                                class="menu-item" data-i18n="Third Level">Payment</span></a>
                    </li>



                    <li id="menu-confirmed-order-index" class="">
                        <a href="{{route('external-user.confirmed-order-index')}}" class="link_item"><i class="bx bx-right-arrow-alt"></i><span
                                class="menu-item" data-i18n="Third Level">Order Process</span></a>
                    </li>



                    <li id="menu-product-download" class="">
                        <a href="{{route('external-user.product-download-index')}}" class="link_item"><i class="bx bx-right-arrow-alt"></i><span
                                class="menu-item" data-i18n="Third Level">Product Download</span></a>
                    </li>


                    <li id="menu-order-tracking-index" class="">
                        {{-- <a href="{{route('external-user.order-tracking-index')}}" class="link_item"><i class="bx bx-right-arrow-alt"></i><span
                                class="menu-item" data-i18n="Third Level">Order tracking</span></a> --}}
                    </li>

				</ul>
			</li>
		</ul>
		<div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
</div>
