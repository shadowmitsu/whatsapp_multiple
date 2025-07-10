<x-index-layout>
    <!-- Home Start -->
    <section class="hero-1-bg" style="background-image: url({{ asset_index('images/hero-1-bg-img.png') }})" id="home">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6">
                    <h1 class="hero-1-title fw-bold text-shadow mb-4">{{ __index('BOOST_MPWA')}}</h1>
                    <div class="w-75 mb-5 mb-lg-0">
                        <p class="text-muted mb-5 pb-5 font-size-17">{{ __index('BOOST_MPWA_MSG')}}</p>
                        <p>{!! __index('BOOST_MPWA_FOOTER') !!}</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-10">
                    <div class=" mt-5 mt-lg-0">
                        <img src="{{ asset_index('images/hero-1-img.png') }}" alt="" class="img-fluid d-block mx-auto rounded shadow animate-float">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Home End -->

    <!-- Feathers Start -->
    <section class="section" id="features">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 align-self-center">
                    <div class="mb-4 mb-lg-0">
                        <video autoplay muted loop>
						  <source src="{{ asset_index('images/autoreply.webm') }}" type="video/webm">
						</video>
                    </div>
                </div>
                <div class="col-lg-8 align-self-center">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="wc-box rounded text-center wc-box-primary p-4 mt-md-5">
                                <div class="wc-box-icon">
                                    <i class="mdi mdi-collage"></i>
                                </div>
                                <h5 class="fw-bold mb-2 wc-title mt-4">{{ __index('AI_REPLY')}}</h5>
                                <p class="text-muted mb-0 font-size-15 wc-subtitle">{{ __index('AI_REPLY_MSG')}}</p>
                            </div>
                            <div class="wc-box rounded text-center wc-box-primary p-4">
                                <div class="wc-box-icon">
                                    <i class="mdi mdi-trending-up"></i>
                                </div>
                                <h5 class="fw-bold mb-2 wc-title mt-4">{{ __index('TEMPLATE_MESSAGING')}}</h5>
                                <p class="text-muted mb-0 font-size-15 wc-subtitle">{{ __index('TEMPLATE_MESSAGING_MSG')}}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="wc-box rounded text-center wc-box-primary p-4">
                                <div class="wc-box-icon">
                                    <i class="mdi mdi-security"></i>
                                </div>
                                <h5 class="fw-bold mb-2 wc-title mt-4">{{ __index('AUTO_REPLY')}}</h5>
                                <p class="text-muted mb-0 font-size-15 wc-subtitle">{{ __index('AUTO_REPLY_MSG')}}</p>
                            </div>
                            <div class="wc-box rounded text-center wc-box-primary p-4">
                                <div class="wc-box-icon">
                                    <i class="mdi mdi-database-lock"></i>
                                </div>
                                <h5 class="fw-bold mb-2 wc-title mt-4">{{ __index('ACTIONS_BUTTONS')}}</h5>
                                <p class="text-muted mb-0 font-size-15 wc-subtitle">{{ __index('ACTIONS_BUTTONS_MSG')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Feathers End -->

    <!-- Pricing Start -->
    <section class="section bg-light" id="pricing">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center mb-5">
                        <h3 class="title mb-3">{{ __index('CHOOSE_PLAN')}}</h3>
                        <p class="text-muted font-size-15">{{__index('CHOOSE_PLAN_MSG')}}</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
				@foreach($plans ?? [] as $index => $plan)
					@if($index != 0 && $index % 3 == 0)
						</div>
						<div class="row justify-content-center mt-4">
					@endif
					<div class="col-lg-4 {{ count($plans) > 3 && $index >= 3 ? 'col-lg-4 mx-auto' : '' }}">
						<div class="pricing-box rounded text-center {{ $plan->is_recommended == 1 ? 'border border-4 active' : 'border border-1' }} p-4">
							<div class="pricing-icon-bg my-4">
								<i class="mdi mdi-account-group h1"></i>
							</div>
							<h4 class="title mb-3">{{ $plan->title }}</h4>
							<h1 class="fw-bold mb-0"><b><sup class="h4 me-2 fw-bold">{{$plan->symbol}}</sup>{{ number_format($plan->price) }}</b></h1>
							<p class="text-muted font-weight-semibold">{{ __index('USER_MONTH')}}</p>
							<ul class="list-unstyled pricing-item m-0 mb-3 p-0 text-start px-0">
								@foreach($plan->data ?? [] as $key => $data)
								<li class="d-flex align-items-center m-0 p-0">
									<i class="mdi {{ $data == false ? 'mdi-cancel text-danger' : 'mdi-check-circle text-success' }} me-2"></i> 
									{{ __index(strtoupper($key)) }} {{$key == 'messages_limit' || $key == 'device_limit' ? "(".number_format($data).")" : ""}}
								</li>
								@endforeach
							</ul>
							@if($plan->is_trial != 1)
								<a href="{{ route('payments.checkout', $plan->id) }}" class="btn {{ $plan->is_recommended == 1 ? 'btn-primary' : 'btn-outline-primary' }} pr-btn w-100">{{ __index('BUY_NOW') }}</a>
							@else
								<a href="{{ route('payments.checkout', $plan->id) }}" class="btn {{ $plan->is_recommended == 1 ? 'btn-primary' : 'btn-outline-primary' }} pr-btn w-100">{{ __index('BUY_NOW') }}</a>
								<a href="{{ route('payments.trial', $plan->id) }}" class="mt-2 btn {{ $plan->is_recommended == 1 ? 'btn-danger' : 'btn-outline-primary' }} pr-btn w-100">{{__index('TRIAL_DAYS', ['trial_days' => $plan->trial_days])}}</a>
							@endif
							<div class="mt-4">
								<div class="hero-bottom-img">
									<img src="{{ asset_index('images/pricing-bottom-bg.png') }}" alt="" class="img-fluid d-block mx-auto">
								</div>
							</div>
						</div>
					</div>
				@endforeach
			</div>
        </div>
    </section>
    <!-- Pricing End -->

    <!-- Contact Us Start -->
    <section class="section bg-light" id="contact">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center mb-5">
                        <h3 class="title mb-3">{{ __index('CONTACT_US')}}</h3>
                        <p class="text-muted font-size-15">{{ __index('CONTACT_US_MSG')}}</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-7 align-self-center">
                    <div class="custom-form mb-5 mb-lg-0">
                        <form method="post" name="myForm" onsubmit="return validateForm()">
                            <p id="error-msg"></p>
                            <div id="simple-msg"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __index('NAME')}}*</label>
                                        <input name="name" id="name" type="text" class="form-control"
                                            placeholder="{{ __index('NAME')}}...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">{{ __index('EMAIL')}}*</label>
                                        <input name="email" id="email" type="email" class="form-control"
                                            placeholder="{{ __index('EMAIL')}}...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="comments">{{ __index('MESSAGE')}}*</label>
                                        <textarea name="comments" id="comments" rows="4" class="form-control"
                                            placeholder="{{ __index('MESSAGE')}}..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" id="submit" name="send" class="btn btn-primary">{{ __index('SEND_MESSAGE')}}
                                        <i class="icon-size-15 ms-2 icon" data-feather="send"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5 align-self-center">
                    <div class="contact-detail text-muted ms-lg-5">
                        <p class=""><i class="icon-xs icon me-1" data-feather="mail"></i> :
                            <span>{{__index('FOOTER_EMAIL')}}</span>
                        </p>
                        <p class=""><i class="icon-xs icon me-1" data-feather="link"></i> : <span>{{__index('FOOTER_LINK')}}</span>
                        </p>
                        <p class=""><i class="icon-xs icon me-1" data-feather="phone-call"></i> : <span dir="ltr">{{__index('FOOTER_PHONE')}}</span></p>
                        <p class=""><i class="icon-xs icon me-1" data-feather="clock"></i> : <span>{{__index('FOOTER_CLOCK')}}</span></p>
                        <p class=""><i class="icon-xs icon me-1" data-feather="map-pin"></i> : <span>{{__index('FOOTER_MAP')}}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Us End -->

</x-index-layout>