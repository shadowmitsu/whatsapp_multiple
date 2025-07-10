<x-layout-dashboard title="{{__('Send Notification')}}">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{__('Admin')}}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{__('Send Notification')}}</li>
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
	<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <div class="row mt-4">
        <div class="col">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title">{{__('Send Notification')}}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.notifications.send') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <div id="editor-container" style="height: 300px; background: white;"></div>
							<input type="hidden" id="message" name="message">
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Send to all') }}</button>
                    </form>
                </div>
            </div>
        </div>
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

			document.querySelector('form[action="{{ route('admin.notifications.send') }}"]').addEventListener('submit', function (e) {
				document.getElementById('message').value = quill.root.innerHTML;
			});


			quill.root.innerHTML = `{!! $notification->message ?? '' !!}`;
		});
	</script>
</x-layout-dashboard>