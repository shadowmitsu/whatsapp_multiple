<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar', 'he', 'fa']) ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8" />
    <title>{{ config('config.site_name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset_index('images/favicon.png') }}">
    <!-- css -->
    <link href="{{ asset_index('css/bootstrap.' . (in_array(app()->getLocale(), ['ar', 'he', 'fa']) ? 'rtl' : 'ltr') . '.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_index('css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_index('css/style.' . (in_array(app()->getLocale(), ['ar', 'he', 'fa']) ? 'rtl' : 'ltr') . '.min.css') }}" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	{{-- csrf --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body>


	<x-index-header></x-index-header>
	
	{{ $slot }}
	
	<x-index-footer></x-index-footer>


    <!-- login Modal Start -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content login-page">
                <div class="modal-body">
                    <div class="text-center">
                        <h3 class="title mb-4">{{__index('HI_WELCOME', ['site_name' => config('config.site_name')])}}</h3>
                        <h4 class="text-uppercase text-primary"><b>{{__index('SIGN_IN')}}</b></h4>
                    </div>
                    <div class="login-form mt-4">
                        <form class="form-body" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="username">{{__index('USERNAME')}}</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="{{__index('USERNAME')}}">
                            </div>
                            <div class="form-group">
                                <label for="password">{{__index('ENTER_PASSWORD')}}</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="{{__index('Enter Password')}}">
                            </div>
                            <a href="{{ route('password.request') }}" class="float-end text-muted font-size-15">{{ __index('RESET_PASSWORD') }}</a>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label font-size-15" for="customCheck1">{{ __index('REMEMBER_ME') }}</label>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary">{{ __index('SIGN_IN') }} <i class="icon-size-15 icon ms-1"
                                        data-feather="arrow-right-circle"></i></button>
                            </div>
                        </form>
                        <div class="text-center mt-4">
                            <p class="text-muted mb-0">{{__index("DONT_HAVE_ACCOUNT")}} <a href="{{ route('register') }}" class="text-primary">{{__index('SIGN_UP_HERE')}}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- login Modal End -->

    <!-- Register Modal Start-->
    <div class="modal fade" id="exampleModalCenter-1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content login-page">
                <div class="modal-body">
                    <div class="text-center">
                        <h3 class="title mb-4">{{ __index('HI_WELCOME', ['site_name' => config('config.site_name')]) }}</h3>
                        <h4 class="text-uppercase text-primary"><b>{{__index('REGISTER')}}</b></h4>
                    </div>
                    <div class="login-form mt-4">
                        <form class="form-body" action="{{ route('register') }}" method="POST">
                        @csrf
                            <div class="form-group">
                                <label for="username">{{__index('USERNAME')}}</label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="{{__index('USERNAME')}}">
                            </div>
                            <div class="form-group">
                                <label for="email">{{__index('EMAIL')}}</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="{{__index('Email')}}">
                            </div>
                            <div class="form-group">
                                <label for="password">{{__index('ENTER_PASSWORD')}}</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="{{__index('ENTER_PASSWORD')}}">
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary">{{__index('REGISTER')}} <i class="icon-size-15 icon ms-1" data-feather="arrow-right-circle"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Modal Start-->


    <!-- javascript -->
    <script src="{{ asset_index('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset_index('js/smooth-scroll.polyfills.min.js') }}"></script>
    <script src="{{ asset_index('js/gumshoe.polyfills.min.js') }}"></script>
    <!-- feather icon -->
    <script src="{{ asset_index('js/feather.js') }}"></script>
    <!-- unicons icon -->
    <script src="{{ asset_index('js/unicons.js') }}"></script>
    <!-- Main Js -->
    <script src="{{ asset_index('js/app.js') }}"></script>

</body>

</html>