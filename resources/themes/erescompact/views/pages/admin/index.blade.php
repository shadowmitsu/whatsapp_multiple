<x-layout-dashboard title="{{ __('Edit Welcome Page') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css" />
<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
<div class="content-body">
<div class="container-fluid">
    <div class="row">
        <div class="col">
		<div class="row">
            <div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h5 class="card-title">{{ __('Edit Welcome Page') }}</h5>
					<form method="POST" action="{{ route('admin.index.enable') }}">
						@csrf
					
					@if (env('ENABLE_INDEX') == "no")
						<button class="btn btn-primary" name="enableindex" value="yes">{{ __('Enable Welcome Page') }}</button>
					@else
						<button class="btn btn-danger" name="enableindex" value="no">{{ __('Disable Welcome Page') }}</button>
					@endif
					</form>
				</div>
				<div class="card-body">
					<div class="container">
						<form method="POST" action="{{ route('admin.index.update') }}">
							@csrf

							<h5>{{__('Text')}}</h5>
							<div>
								<ul class="nav nav-tabs">
									@foreach($translations as $lang => $texts)
									<li class="nav-item">
										<a class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab" href="#tab-{{ $lang }}">{{ strtoupper($languages[$lang]['name']) }}</a>
									</li>
									@endforeach
								</ul>
								<div class="tab-content">
									@foreach($translations as $lang => $texts)
									<div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tab-{{ $lang }}">
										<div class="row">
											@foreach($texts as $key => $value)
											<div class="col-6 mt-3">
												<div class="input-group">
													<span class="input-group-text col-4">{{ $key }}</span>
													<input type="text" class="form-control" name="translations[{{ $lang }}][{{ $key }}]" value="{{ $value }}" @if (in_array(strtolower($lang), ['ar', 'he', 'fa'])) dir="rtl" @endif>
												</div>
											</div>
											@endforeach
										</div>
									</div>
									@endforeach
								</div>
							</div>
							<button type="submit" class="btn btn-primary mt-3">{{__('Save')}}</button>
						</form>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h5 class="card-title">{{__('Colors')}}</h5>
				</div>
				<div class="card-body">
					<form method="POST" action="{{ route('admin.index.color') }}">
						@csrf
						<div class="row gy-3">
							<div class="col-md-4">
								<label for="bs-primary" class="form-label">{{ __('Primary Color') }}</label>
								<input type="color" id="bs-primary" name="colors[--bs-primary]" 
									   class="form-control form-control-color p-0" 
									   value="{{ $cssVariables['--bs-primary'] ?? '#000000' }}">
							</div>
							<div class="col-md-4">
								<label for="bs-footer-bg" class="form-label">{{ __('Footer Background') }}</label>
								<input type="color" id="bs-footer-bg" name="colors[--bs-footer-bg]" 
									   class="form-control form-control-color p-0" 
									   value="{{ $cssVariables['--bs-footer-bg'] ?? '#000000' }}">
							</div>
							<div class="col-md-4">
								<label for="bs-footer-alt-bg" class="form-label">{{ __('Footer Alt Background') }}</label>
								<input type="color" id="bs-footer-alt-bg" name="colors[--bs-footer-alt-bg]" 
									   class="form-control form-control-color p-0" 
									   value="{{ $cssVariables['--bs-footer-alt-bg'] ?? '#000000' }}">
							</div>
						</div>
						<div class="mt-4">
							<button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
						</div>
					</form>
				</div>
			</div>
			</div>
        </div>
    </div>
</div>
</div>

</x-layout-dashboard>
