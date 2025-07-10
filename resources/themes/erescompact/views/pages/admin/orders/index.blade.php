<x-layout-dashboard title="{{ __('Orders') }}">
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
		<div class="card">
			<div class="card-header">
				<h5>{{ __('Orders') }}</h5>
			</div>
			<div class="card-body">
            <div class="table-responsive">
                <table class="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('User')}}</th>
                            <th>{{__('Plan')}}</th>
                            <th>{{__('Order ID')}}</th>
                            <th>{{__('Amount')}}</th>
							<th>{{ __('Payment Gateway') }}</th>
                            <th>{{__('Status')}}</th>
                            <th>{{__('Created At')}}</th>
							<th>{{__('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
					@if (count($orders) != 0)
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->user->username }}</td>
                            <td>{{ $order->plan->title }}</td>
                            <td>{{ $order->order_id }}</td>
                            <td>{{ number_format($order->amount) }}</td>
							<td>{{ ucfirst($order->payment_gateway ?? __('Unknown')) }}</td>
                            <td>
                                <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'failed' ? 'danger' : 'primary') }}" id="status-{{$order->id}}">
                                    {{__(ucfirst($order->status)) }}
                                </span>
                            </td>
                            <td dir="ltr" class="text-start">{{ $order->created_at->format('Y-m-d H:i') }}</td>
							<td>
								@if($order->payment_gateway == 'custom')
									<div class="dropdown">
										<button class="btn btn-link btn-sm p-0" type="button" id="dropdownStatus{{ $order->id }}" data-bs-toggle="dropdown" aria-expanded="false">
											<i class="fas fa-bars
												@if($order->status == 'completed')
													text-success
												@elseif($order->status == 'failed')
													text-danger
												@else
													text-primary
												@endif
											"></i>
										</button>
										<ul class="dropdown-menu" aria-labelledby="dropdownStatus{{ $order->id }}">
											<li><a class="dropdown-item status-option" href="#" data-status="pending">
												<i class="fas fa-circle text-primary"></i> {{__('Pending')}}
											</a></li>
											<li><a class="dropdown-item status-option" href="#" data-status="failed">
												<i class="fas fa-circle text-danger"></i> {{__('Failed')}}
											</a></li>
											<li><a class="dropdown-item status-option" href="#" data-status="completed">
												<i class="fas fa-circle text-success"></i> {{__('Completed')}}
											</a></li>
										</ul>
									</div>
								@else
									---
								@endif
							</td>
                        </tr>
                        @endforeach
					@else
						<tr>
							<td colspan="7" class="text-center">{{__('No orders')}}</td>
						</tr>
					@endif
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
    </div>
			</div>
	</div>
</div>
<script>
document.querySelectorAll('.status-option').forEach(option => {
    option.addEventListener('click', function(e) {
        e.preventDefault();
        const status = this.dataset.status;
        const dropdownButton = this.closest('.dropdown').querySelector('button');
        const orderId = dropdownButton.id.replace('dropdownStatus', '');
        
        const url = '{{route("admin.orders.status")}}';
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status, order_id: orderId })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                dropdownButton.querySelector('i').className = `fas fa-bars ${
                    status === 'completed' ? 'text-success' : 
                    status === 'failed' ? 'text-danger' : 
                    'text-primary'
                }`;
                
                const statusSpan = document.getElementById('status-'+orderId);
                if (statusSpan) {
                    statusSpan.textContent = status;
                    statusSpan.className = 'badge';
                    if (status === 'completed') {
                        statusSpan.classList.add('bg-success');
                    } else if (status === 'failed') {
                        statusSpan.classList.add('bg-danger');
                    } else if (status === 'pending') {
                        statusSpan.classList.add('bg-primary');
                    }
                }
                
                toastr.success(data.msg);
            } else {
                toastr.error(data.msg);
            }
        });
    });
});
</script>
</x-layout-dashboard>