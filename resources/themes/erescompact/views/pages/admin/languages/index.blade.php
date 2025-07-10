<x-layout-dashboard title="{{__('Languages')}}">
<div class="content-body">
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h5 class="card-title">{{ __('Available Languages') }}</h5>
					<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLanguageModal">{{ __('Add New Language') }}</button>
				</div>
				<div class="card-body">
					<table class="table">
						<thead>
							<tr>
								<th>{{ __('Language') }}</th>
								<th>{{ __('Translated') }}</th>
								<th>{{ __('Remaining') }}</th>
								<th>{{ __('Progress') }}</th>
								<th>{{ __('Actions') }}</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($languages as $lang)
							<tr>
								<td>[{{ strtoupper($lang) }}] - {{ $supportedLocales[$lang]['native'] ?? strtoupper($lang) }}</td>
								<td>{{ $progressData[$lang]['translated'] }}</td>
								<td>{{ $progressData[$lang]['remaining'] }}</td>
								<td>
									<div class="progress" style="height: 15px;">
										<div class="progress-bar" role="progressbar" style="width: {{ $progressData[$lang]['percentage'] }}%;" aria-valuenow="{{ $progressData[$lang]['percentage'] }}" aria-valuemin="0" aria-valuemax="100">
											{{ $progressData[$lang]['percentage'] }}%
										</div>
									</div>
								</td>
								<td class="d-flex gap-2">
									@if (strtolower($lang) == $baseLang)
										<button class="btn btn-primary btn-sm" disabled>{{ __('Edit') }}</button>
									@else
										<button onclick="window.location.href='{{ route('languages.edit', $lang) }}'" class="btn btn-primary btn-sm">{{ __('Edit') }}</button>
										<button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $lang }}">
											<i class="fas fa-trash-alt"></i>
										</button>
									@endif
								</td>
							</tr>

							@if (strtolower($lang) != $baseLang)
							<div class="modal fade" id="deleteModal{{ $lang }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $lang }}" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="deleteModalLabel{{ $lang }}">{{ __('Confirm Delete') }}</h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											{{ __('Are you sure you want to delete') }} [{{ strtoupper($lang) }}] {{ __('language file?') }}
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('No') }}</button>
											<form action="{{ route('languages.destroy', $lang) }}" method="POST" style="display: inline;">
												@csrf
												@method('DELETE')
												<button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
											</form>
										</div>
									</div>
								</div>
							</div>
							@endif
							@endforeach
						</tbody>
					</table>
				</div>
			</div>

			<div class="modal fade" id="addLanguageModal" tabindex="-1" aria-labelledby="addLanguageModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="addLanguageModalLabel">{{ __('Add New Language') }}</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<form id="addLanguageForm">
								<div class="form-group">
									<label for="languageSelect">{{ __('Select Language') }}</label>
									<select id="languageSelect" name="language" class="form-control">
										@foreach ($filteredLanguages as $code => $name)
                                @if (!in_array($code, $existingLanguages))
                                    <option value="{{ $code }}">{{ $name }}</option>
                                @endif
                            @endforeach
									</select>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
							<button type="button" class="btn btn-primary" onclick="addNewLanguage()">{{ __('Add') }}</button>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
</div>
	<script>
	function addNewLanguage() {
		const language = document.getElementById('languageSelect').value;

		fetch('{{ route('languages.add') }}', {
			method: 'POST',
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}',
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({ language }),
		})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				toastr.success(data.message);
				location.reload();
			} else {
				toastr.success(data.message);
			}
		})
		.catch(error => console.error('Error:', error));
	}
	</script>
</x-layout-dashboard>
