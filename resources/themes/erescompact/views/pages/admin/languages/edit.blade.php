<x-layout-dashboard title="{{__('Edit Language')}}">
<div class="content-body">
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title">{{ __('Edit') }} {{ $getName }}</h5>
                </div>
                <div class="card-body">
                    <form id="form-{{ $lang }}">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="col-5 text-wrap">{{ __('Key') }}</th>
                                    <th class="col-5 text-wrap">{{ __('Value') }}</th>
                                    <th class="col-2 text-wrap">{{ __('Translated') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paginatedTranslations->items() as $translation)
                                <tr>
                                    <td class="text-wrap">{{ $translation['key'] }}</td>
                                    <td class="text-wrap">
                                        <input type="text" class="form-control" @if (in_array(strtolower($lang), ['ar', 'he', 'fa'])) dir="rtl" @endif name="translations[{{ $translation['key'] }}]" value="{{ $translation['value'] }}">
                                    </td>
                                    <td class="text-wrap">
                                        <span class="badge {{ $translation['is_translated'] ? 'bg-success' : 'bg-danger' }}">
                                            {{ $translation['is_translated'] ? __('Yes') : __('No') }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $paginatedTranslations->links('pagination::bootstrap-4') }}
                        </div>
						
						<div class="mt-3">
							<a href="{{ route('languages.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
							<button type="button" class="btn btn-primary" onclick="updateTranslations('{{ $lang }}')">{{ __('Save') }}</button>
						</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    <script>
        function updateTranslations(lang) {
            const form = document.getElementById(`form-${lang}`);
            const formData = new FormData(form);

            fetch('{{ route('languages.update', $lang) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            }).then(response => response.json())
              .then(data => toastr.success(data.message));
        }
    </script>
</x-layout-dashboard>
