<x-layout-dashboard title="{{__('No permission')}}">
	<!--breadcrumb-->
	<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
		<div class="breadcrumb-title pe-3">{{__('Alert')}}</div>
		<div class="ps-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">{{__('No permission')}}</li>
				</ol>
			</nav>
		</div>
	</div>
	<div class="row mt-4">
		<div class="col">
			<div class="card">
				<div class="card-header d-flex justify-content-between">
					<h5 class="card-title">{{__('No permission')}}</h5>
				</div>
				<div class="container mt-5 mb-5 text-center">
					<h5 class="text-muted mb-3">{{ __('You do not have access to this feature, you can purchase a new plan, or upgrade your plan.') }}</h5>
					<a href="{{ route('index') }}#pricing" class="btn btn-primary">{{ __('plans') }}</a>
				</div>
			</div>
		</div>
	</div>
</x-layout-dashboard>