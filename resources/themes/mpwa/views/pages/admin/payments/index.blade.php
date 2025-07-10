<x-layout-dashboard title="{{ __('Payment Gateways') }}">
	<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
							
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ __('Admin') }}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Payment Gateways') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <h5>{{ __('Payment Gateways') }}</h5>
        </div>
	</div>
        <div class="card-body">
            <form action="{{ route('admin.payments.update') }}" method="POST">
    @csrf
	@foreach ($gateways as $gateway)
    <div class="card">
        <div class="card-header">
            <h6>{{ ucfirst($gateway['name']) }}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach ($gateway['config'] as $key => $option)
					@if($key != 'html')
						<div class="col-md-6">
							<label for="{{$key}}" class="form-label mt-2" id="{{$key}}">{{str_replace('_', ' ', ucfirst($key))}}</label>
							@if($key == 'status')
								<select name="gateway[{{$gateway['name']}}][{{$key}}]" class="form-control">
									<option value="disable">Disable</option>
									<option value="enable" @if($option == 'enable') selected @endif>Enable</option>
								</select>
							@elseif($key == 'is_production')
								<select name="gateway[{{$gateway['name']}}][{{$key}}]" class="form-control">
									<option value="false">No</option>
									<option value="true" @if($option == 'true') selected @endif>Yes</option>
								</select>
							@else
								<input name="gateway[{{$gateway['name']}}][{{$key}}]" id="{{$key}}" class="form-control" value="{{$option}}" />
							@endif
						</div>
					@else
						<div class="col-md-12">
							<label for="{{$key}}" class="form-label mt-2" id="{{$key}}">{{str_replace('_', ' ', ucfirst($key))}}</label>
							<div id="editor-container" style="height: 200px; background: white;">{!! base64_decode($option) !!}</div>
							<input type="hidden" id="htmlcrypt" name="gateway[{{$gateway['name']}}][{{$key}}]">
						</div>
					@endif
                @endforeach
            </div>
        </div>
    </div>
	@endforeach

    <button type="submit" class="btn btn-primary mt-3">{{ __('Save Changes') }}</button>
</form>
        </div>
    <script>
		document.addEventListener('DOMContentLoaded', function () {
			var quill = new Quill('#editor-container', {
				theme: 'snow',
				modules: {
					toolbar: [
						['bold', 'italic', 'underline', 'strike'],
						['blockquote', 'code-block'],
						[{ 'header': 1 }, { 'header': 2 }],
						[{ 'list': 'ordered'}, { 'list': 'bullet' }],
						[{ 'indent': '-1'}, { 'indent': '+1' }],
						[{ 'direction': 'rtl' }],
						[{ 'size': ['small', false, 'large', 'huge'] }],
						[{ 'color': [] }, { 'background': [] }],
						[{ 'align': [] }],
						['link'],
						['clean']
					]
				}
			});

			document.querySelector('form[action="{{ route('admin.payments.update') }}"]').addEventListener('submit', function (e) {
				document.getElementById('htmlcrypt').value = quill.root.innerHTML;
			});

		});
	</script>
</x-layout-dashboard>
