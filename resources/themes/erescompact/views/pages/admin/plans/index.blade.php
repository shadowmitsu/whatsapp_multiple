<x-layout-dashboard title="{{ __('Manage Plans') }}">
    <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
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
	@php
		$features = [
			'messages_limit' => __('Messages Limit'),
			'device_limit' => __('Device Limit'),
			'ai_message' => __('AI Message'),
			'schedule_message' => __('Schedule Message'),
			'bulk_message' => __('Bulk Message'),
			'autoreply' => __('Auto Reply'),
			'send_message' => __('Send Message'),
			'send_media' => __('Send Media'),
			'send_list' => __('Send List'),
			'send_template' => __('Send Template'),
			'send_button' => __('Send Button'),
			'send_location' => __('Send Location'),
			'send_poll' => __('Send Poll'),
			'send_sticker' => __('Send Sticker'),
			'send_vcard' => __('Send VCard'),
			'webhook' => __('Webhook'),
			'api' => __('API'),
		];
    @endphp
<div class="card">
				<div class="card-header">
					<h5 class="card-title">{{ __('Manage Plans') }}</h5>
					<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPlanModal" onclick="resetModal()">{{ __('Add New Plan') }}</button>
				</div>
	</div>
	<div class="container mt-3">
    <div class="row mt-4">
        @foreach ($plans as $plan)
            <div class="col-md-4 @if ($plan->is_recommended == 1) alert alert-warning @endif">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $plan->title }}</h5>
                        <h6 class="text-muted" dir="ltr">{{ number_format($plan->price) }} {{$plan->symbol}} / <span dir="{{ in_array(app()->getLocale(), ['ar', 'he', 'fa']) ? 'rtl' : 'ltr' }}">{{ $plan->days }} {{ __('days') }}</span></h6>
                        <p class="text-muted">{{ __('Trial') }}: {{ $plan->trial_days }} {{ __('days') }}</p>
                        <hr>
                        <ul class="list-unstyled text-start">
                            @foreach ($plan->data as $key => $label)
                                <li>
                                    @if (!empty($label) && $label)
                                        ✅
                                    @else
                                        ❌
                                    @endif
									@if ($key == "messages_limit" || $key == "device_limit")
										{{ $features[$key] }} ({{number_format($label)}})
									@else
										{{ $features[$key] }}
									@endif
                                </li>
                            @endforeach
                        </ul>
                        <button class="btn btn-warning btn-sm" onclick="editPlan({{ json_encode($plan) }})">{{ __('Edit') }}</button>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletePlanModal" onclick="confirmDelete({{ $plan->id }})">{{ __('Delete') }}</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Add/Edit Plan Modal -->
    <div class="modal fade" id="addPlanModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="addPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="planForm" action="{{ route('admin.plans.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPlanModalLabel">{{ __('Manage Plan') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="planId" name="id">
                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('Title') }}</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
						<div class="mb-3">
                            <label for="is_recommended" class="form-label">{{ __('Recommended?') }}</label>
                            <select name="is_recommended" id="is_recommended" class="form-control">
								<option value="0">{{ __('No') }}</option>
								<option value="1">{{ __('Yes') }}</option>
							</select>
                        </div>
						<div class="mb-3">
                            <label for="status" class="form-label">{{ __('Status') }}</label>
                            <select name="status" id="status" class="form-control" required>
								<option value="1">{{ __('Enable') }}</option>
								<option value="0">{{ __('Disable') }}</option>
							</select>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">{{ __('Price') }}</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
						<div class="mb-3">
                            <label for="symbol" class="form-label">{{ __('Currency Symbol') }}</label>
                            <select name="symbol" id="symbol" class="form-control" required>
								<option value="USD">$ - Dollar USD</option>
								<option value="EUR">€ - Euro</option>
								<option value="GBP">£ - Pound GBP</option>
								<option value="JPY">¥ - Yen JPY</option>
								<option value="INR">₹ - Rupee INR</option>
								<option value="RUB">₽ - Russian Ruble RUB</option>
								<option value="SAR">SAR - Saudi Riyal</option>
								<option value="AED">AED - UAE Dirham</option>
								<option value="IDR">IDR - Indonesian Rupiah</option>
								<option value="AUD">AUD - Australian Dollar</option>
								<option value="CAD">CAD - Canadian Dollar</option>
								<option value="CHF">CHF - Swiss Franc</option>
								<option value="CNY">CNY - Chinese Yuan</option>
								<option value="SEK">SEK - Swedish Krona</option>
								<option value="NZD">NZD - New Zealand Dollar</option>
								<option value="MXN">MXN - Mexican Peso</option>
								<option value="SGD">SGD - Singapore Dollar</option>
								<option value="HKD">HKD - Hong Kong Dollar</option>
								<option value="NOK">NOK - Norwegian Krone</option>
								<option value="KRW">KRW - South Korean Won</option>
								<option value="TRY">TRY - Turkish Lira</option>
								<option value="ZAR">ZAR - South African Rand</option>
								<option value="BRL">BRL - Brazilian Real</option>
								<option value="MYR">MYR - Malaysian Ringgit</option>
								<option value="THB">THB - Thai Baht</option>
								<option value="EGP">EGP - Egyptian Pound</option>
								<option value="PKR">PKR - Pakistani Rupee</option>
								<option value="BDT">BDT - Bangladeshi Taka</option>
								<option value="LKR">LKR - Sri Lankan Rupee</option>
								<option value="NGN">NGN - Nigerian Naira</option>
								<option value="KES">KES - Kenyan Shilling</option>
								<option value="GHS">GHS - Ghanaian Cedi</option>
								<option value="DZD">DZD - Algerian Dinar</option>
								<option value="TND">TND - Tunisian Dinar</option>
								<option value="MAD">MAD - Moroccan Dirham</option>
								<option value="ILS">ILS - Israeli Shekel</option>
								<option value="KWD">KWD - Kuwaiti Dinar</option>
								<option value="OMR">OMR - Omani Rial</option>
								<option value="QAR">QAR - Qatari Riyal</option>
								<option value="BHD">BHD - Bahraini Dinar</option>
								<option value="JOD">JOD - Jordanian Dinar</option>
								<option value="IQD">IQD - Iraqi Dinar</option>
								<option value="LYD">LYD - Libyan Dinar</option>
								<option value="AFN">AFN - Afghan Afghani</option>
								<option value="AZN">AZN - Azerbaijani Manat</option>
								<option value="VND">VND - Vietnamese Dong</option>
								<option value="PLN">PLN - Polish Zloty</option>
								<option value="CZK">CZK - Czech Koruna</option>
								<option value="HUF">HUF - Hungarian Forint</option>
								<option value="DKK">DKK - Danish Krone</option>
								<option value="ISK">ISK - Icelandic Krona</option>
								<option value="PHP">PHP - Philippine Peso</option>
								<option value="YER">YER - Yemeni Riyal</option>
							</select>
                        </div>
                        <div class="mb-3">
                            <label for="days" class="form-label">{{ __('Days') }}</label>
                            <input type="number" class="form-control" id="days" name="days" required>
                        </div>
                        <div class="mb-3">
                            <label for="trial_days" class="form-label">{{ __('Trial Days') }}</label>
                            <input type="number" class="form-control" id="trial_days" name="trial_days" required>
                        </div>
						<div class="mb-3">
                            <label for="messages_limit" class="form-label">{{ __('Messages Limit') }}</label>
                            <input type="number" class="form-control" id="messages_limit" name="messages_limit" required>
                        </div>
						<div class="mb-3">
                            <label for="device_limit" class="form-label">{{ __('Device Limit') }}</label>
                            <input type="number" class="form-control" id="device_limit" name="device_limit" required>
                        </div>
                        <div class="row">
                            <h6>{{ __('Features') }}</h6>
                            @foreach ($plan->data ?? [] as $key => $label)
								@if ($key != "messages_limit" && $key != "device_limit")
                                <div class="col-md-6 mb-2">
									<input type="checkbox" id="{{ $key }}" name="data[{{ $key }}]" class="form-check-input">
                                    <label for="{{ $key }}" class="form-check-label">{{ $features[$key] }}</label>
                                </div>
								@endif
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save Plan') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deletePlanModal" tabindex="-1" aria-labelledby="deletePlanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deletePlanModalLabel">{{ __('Delete Confirmation') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ __('Are you sure you want to delete this plan?') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
</div>
    <script>
        function editPlan(plan) {
			const modal = new bootstrap.Modal(document.getElementById('addPlanModal'));
			const dataplan = plan.data;
			document.getElementById('planForm').action = "{{ route('admin.plans.update', '') }}/" + plan.id;
			document.getElementById('planForm').method = "POST";
			document.getElementById('planForm').insertAdjacentHTML('beforeend', '<input type="hidden" name="_method" value="PUT">');
			document.getElementById('planId').value = plan.id;
			document.getElementById('title').value = plan.title;

			const recommendedSelect = document.getElementById('is_recommended');
			recommendedSelect.value = plan.is_recommended;
			$(recommendedSelect).selectpicker('refresh');

			const statusSelect = document.getElementById('status');
			statusSelect.value = plan.status;
			$(statusSelect).selectpicker('refresh');
			
			document.getElementById('price').value = plan.price;
			
			const symbolSelect = document.getElementById('symbol');
			symbolSelect.value = plan.symbol;
			$(symbolSelect).selectpicker('refresh');
			
			document.getElementById('days').value = plan.days;
			document.getElementById('trial_days').value = plan.trial_days;
			document.getElementById('messages_limit').value = dataplan.messages_limit;
			document.getElementById('device_limit').value = dataplan.device_limit;

			for (const key in plan.data) {
				document.getElementById(key).checked = plan.data[key];
			}
			modal.show();
		}

        function resetModal() {
            document.getElementById('planForm').reset();
            document.getElementById('planForm').action = "{{ route('admin.plans.store') }}";
            document.querySelector('input[name="_method"]').remove();
        }

        function confirmDelete(id) {
            document.getElementById('deleteForm').action = "{{ route('admin.plans.destroy', '') }}/" + id;
        }
    </script>
</x-layout-dashboard>
