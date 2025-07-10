<x-layout-dashboard title="{{__('No permission')}}">
<div class="content-body">
    <div class="container-fluid">
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
</div>
</div>
</x-layout-dashboard>