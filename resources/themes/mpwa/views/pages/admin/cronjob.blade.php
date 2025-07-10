<x-layout-dashboard title="{{__('Cronjob')}}">
	<!--breadcrumb-->
	<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">{{__('Admin')}}</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">{{__('Cronjob')}}</li>
				</ol>
			</nav>
		</div>
	</div>
	<!--end breadcrumb-->
	@if (session()->has('alert'))
	<x-alert>
		@slot('type', session('alert')['type'])
		@slot('msg', session('alert')['msg'])
	</x-alert>
	@endif
	@if ($errors->any())
	<div class="alert alert-danger">
		<ul>
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h5><small>{{ __('Execute Start Blast') }}</small></h5>
			</div>
			<div class="card-body">
				<div class="bg-dark text-white ps-2"><p class="text-white pt-2 pb-2">{{$cron_path}} -s "{{ route('blast-start') }}" >/dev/null 2>&1</p></div>
				<strong>{{ __('Every 1 Min') }}</strong>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h5><small>{{ __('Execute Start Schedule') }}</small></h5>
			</div>
			<div class="card-body">
				<div class="bg-dark text-white ps-2"><p class="text-white pt-2 pb-2">{{$cron_path}} -s "{{ route('schedule-run') }}" >/dev/null 2>&1</p></div>
				<strong>{{ __('Every 1 Min') }}</strong>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h5><small>{{ __('Execute Check User Subscribe') }}</small></h5>
			</div>
			<div class="card-body">
				<div class="bg-dark text-white ps-2"><p class="text-white pt-2 pb-2">{{$cron_path}} -s "{{ route('subscription-check') }}" >/dev/null 2>&1</p></div>
				<strong>{{ __('Every 10 Min') }}</strong>
			</div>
		</div>
	</div>
</div>
</x-layout-dashboard>