    <!-- light-dark mode -->

    <a href="javascript: void(0);" id="light-dark-mode" class="mode-btn text-white rounded-end">
        <i class="mdi mdi-sun-compass bx-spin mode-light"></i>
        <i class="mdi mdi-moon-waning-crescent mode-dark"></i>
    </a>

    <!--Navbar Start-->

    <nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky sticky-dark" id="navbar">
        <div class="container">
            <!-- LOGO -->
            <a class="navbar-brand logo" href="{{url('/')}}">
                <x-index-logo></x-index-logo>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <i class="mdi mdi-menu"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mx-auto navbar-center" id="navbar-navlist">
                    <li class="nav-item">
                        <a data-scroll href="#home" class="nav-link">{{__index('HOME')}}</a>
                    </li>
                    <li class="nav-item">
                        <a data-scroll href="#features" class="nav-link">{{__index('FEATURES')}}</a>
                    </li>
                    <li class="nav-item">
                        <a data-scroll href="#pricing" class="nav-link">{{__index('PRICING')}}</a>
                    </li>
                    <li class="nav-item">
                        <a data-scroll href="#contact" class="nav-link">{{__index('CONTACT_US')}}</a>
                    </li>
                </ul>
				<ul class="navbar-nav dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="bi bi-globe"></i>
						{{ __('Language') }}
					</a>
					<ul class="dropdown-menu" aria-labelledby="languageDropdown">
						@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
							<li>
								<a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
									<span class="flag-icon flag-icon-{{ strtolower($localeCode) }}"></span>
									{{ $properties['native'] }}
								</a>
							</li>
						@endforeach
					</ul>
				</ul>
			@if (auth()->check())
				<ul class="navbar-nav navbar-center">
                    <li class="nav-item dropdown dropdown-user-setting">
						<a class="nav-link dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
						  <div class="user-setting d-flex align-items-center">
							<img src="{{asset_index('images/avatar-1.png')}}" class="user-img" alt="">
						  </div>
						</a>
						<ul class="dropdown-menu dropdown-menu-end dropdown-user">
						  <li>
							 <a class="dropdown-item" href="#">
							   <div class="d-flex align-items-center">
								  <img src="{{asset_index('images/avatar-1.png')}}" alt="" class="rounded-circle" width="54" height="54">
								  <div class="ms-3">
									<h6 class="mb-0 dropdown-user-name">{{Auth::user()->username}}</h6>
									<small class="mb-0 dropdown-user-designation text-secondary">{{__(Auth::user()->level)}}</small>
								  </div>
							   </div>
							 </a>
						   </li>
						   <li><hr class="dropdown-divider"></li>
						   
							<li>
							  <a class="dropdown-item" href="{{route('home')}}">
								 <div class="d-flex align-items-center">
								   <div class=""><i class="bi bi-house-fill"></i></div>
								   <div class="ms-3"><span>{{__('Dashboard')}}</span></div>
								 </div>
							   </a>
							</li>
						   <li><hr class="dropdown-divider"></li>
						   
							<li>
							  <a class="dropdown-item" href="{{route('user.settings')}}">
								 <div class="d-flex align-items-center">
								   <div class=""><i class="bi bi-gear-fill"></i></div>
								   <div class="ms-3"><span>{{__('Setting')}}</span></div>
								 </div>
							   </a>
							</li>
							
							<li><hr class="dropdown-divider"></li>
							<li>
							  <form action="{{route('logout')}}" method="post">
								@csrf
								<button class="dropdown-item" type="submit">
								 <div class="d-flex align-items-center">
								   <div class=""><i class="bi bi-lock-fill"></i></div>
								   <div class="ms-3"><span>{{__('Logout')}}</span></div>
								 </div>
							   </button>
							  </form>
							</li>
						</ul>
					  </li>
				</ul>
			@else
                <ul class="navbar-nav navbar-center">
                    <li class="nav-item">
                        <a href="#login" class="nav-link" data-bs-toggle="modal"
                            data-bs-target="#exampleModalCenter">{{__index('SIGN_IN')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#login" class="nav-link" data-bs-toggle="modal"
                            data-bs-target="#exampleModalCenter-1">{{__index('REGISTER')}}</a>
                    </li>
                </ul>
			@endif
            </div>
        </div>
    </nav>
    <!-- Navbar End -->