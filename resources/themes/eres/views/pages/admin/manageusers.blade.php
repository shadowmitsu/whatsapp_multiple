<x-layout-dashboard title="{{__('Manage User')}}">
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
                    <h5 class="card-title">{{__('Users')}}</h5>
                    <button type="button" class="btn btn-primary" onclick="addUser();">
                        {{__('Add User')}}
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md" style="font-size: 0.755rem;">
                            <thead>
                                <tr>
                                    <th>{{__('Username')}}</th>
                                    <th>{{__('Email')}}</th>
                                    <th>{{__('Total Device')}}</th>
                                    <th>{{__('Limit Device')}}</th>
                                    <th>{{__('Status')}}</th>
									<th>{{__('Plan')}}</th>
                                    <th>{{__('Expired subscription')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->total_device }}</td>
                                        <td>{{ $user->limit_device }}</td>
                                        <td>
                                            @php
                                                if ($user->is_expired_subscription) {
                                                    $badge = 'danger';
                                                } else {
                                                    $badge = 'success';
                                                }
                                            @endphp
                                            <span class="badge bg-{{ $badge }}">{{ $user->active_subscription }}</span>
                                        </td>
										<td><span class="badge bg-primary">@if ($user->plan_name) {{$user->plan_name}} @else -- @endif</span></td>
                                        <td>
                                            @php
                                                if ($user->is_expired_subscription) {
                                                    echo '<span class="badge bg-danger">-</span>';
                                                } else {
                                                    if ($user->active_subscription == 'active') {
                                                        echo $user->subscription_expired;
                                                    } else {
                                                        echo '<span class="badge bg-danger">-</span>';
                                                    }
                                                }
                                            @endphp
                                        </td>
										<td>
												<div class="dropdown position-static">
													<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
														{{ __('Action') }}
													</button>
													<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
														<li>
															<a href="{{ route('admin.loginAsUser', $user->id) }}" class="dropdown-item" 
															data-bs-toggle="tooltip" data-bs-placement="bottom" 
															onclick="return confirm('{{ __('Are you sure you want to login as this user?') }}')"
															title="{{ __('Login as User') }}">
																<i class="fa fa-user me-2"></i> {{ __('Login as User') }}
															</a>
														</li>
														<li>
															<a onclick="editUser({{ $user->id }})" href="javascript:;" class="dropdown-item" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{__('Edit user')}}">
																<i class="fa fa-pencil me-2"></i> {{__('Edit user')}}
															</a>
														</li>
														<li>
															<hr class="dropdown-divider">
														</li>
														<li>
															<form action="{{ route('deleteDevice') }}" method="POST">
																@method('delete')
																@csrf
																<input name="id" type="hidden" value="{{ $user->id }}">
																<button type="submit" name="delete" class="dropdown-item text-danger">
																	<i class="fa fa-trash me-2"></i> {{ __('Delete') }}
																</button>
															</form>
														</li>
													</ul>
												</div>
											</td>
                                    </tr>
                                @endforeach

                            <tfoot></tfoot>
                        </table>
                    </div>
                      <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item {{ $users->currentPage() == 1 ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $users->previousPageUrl() }}">{{__('Previous')}}</a>
                            </li>

                            @for ($i = 1; $i <= $users->lastPage(); $i++)
                                <li class="page-item {{ $users->currentPage() == $i ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            <li
                                class="page-item {{ $users->currentPage() == $users->lastPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $users->nextPageUrl() }}">{{__('Next')}}</a>
                            </li>
                        </ul>
                    </nav>
                </div>


        <!-- Modal -->
        <div class="modal fade" id="modalUser" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" enctype="multipart/form-data" id="formUser">
                            @csrf
                            <input type="hidden" id="iduser" name="id">
                            <label for="username" class="form-label">{{__('Username')}}</label>
                            <input type="text" name="username" id="username" class="form-control" value="" required>
                            <label for="email" class="form-label mt-2">{{__('Email')}}</label>
                            <input type="email" name="email" id="email" class="form-control" value="" required>
                            <label for="password" class="form-label mt-2" id="labelpassword">{{__('Password')}}</label>
                            <input type="password" name="password" id="password" class="form-control" value="">
                            <label for="messages_limit" class="form-label mt-2">{{__('Message Limit')}}</label>
                            <input type="number" name="messages_limit" id="messages_limit" class="form-control" value="" required>
							<label for="limit_device" class="form-label mt-2">{{__('Limit Device')}}</label>
                            <input type="number" name="limit_device" id="limit_device" class="form-control" value="" required>
                            <label for="active_subscription" class="form-label mt-2">{{__('Active Subscription')}}</label><br>
                            <select name="active_subscription" id="active_subscription" class="form-control">
                                <option value="active" selected>{{__('Active')}}</option>
                                <option value="inactive">{{__('Inactive')}}</option>
                                <option value="lifetime">{{__('Lifetime')}}</option>
                            </select>
                            <label for="subscription_expired" class="form-label mt-2">{{__('Subscription Expired')}}</label>
                            <input type="datetime-local" name="subscription_expired" id="subscription_expired" class="form-control" value="" required>

                            <label class="form-label mt-2">{{ __('Plan Features') }}</label>
                            <div class="form-check">
                                @php
                                    $features = [
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
                                        'send_sticker' => __('Send Sticker'),
                                        'send_vcard' => __('Send VCard'),
                                        'webhook' => __('Webhook'),
                                        'api' => __('API')
                                    ];
                                    $planData = $user->plan_data ?? [];
                                @endphp
								<div class="row">
                                @foreach ($features as $key => $label)
                                    <div class="col-4 form-check">
                                        <input type="checkbox" name="plan_data[{{ $key }}]" class="form-check-input" id="{{ $key }}" value="1" {{ isset($planData[$key]) && $planData[$key] ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $key }}">{{ $label }}</label>
                                    </div>
                                @endforeach
								</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
	</div>
</div>
        <script>
    function addUser() {
        $('#modalLabel').html('{{__("Add User")}}');
        $('#modalButton').html('{{__("Add")}}');
        $('#formUser').attr('action', '{{ route('user.store') }}');
        $('#modalUser').modal('show');
        $('#formUser').trigger('reset');
        $('input[type=checkbox]').prop('checked', false);
    }

    function editUser(id) {
        $('#modalLabel').html('{{__("Edit User")}}');
        $('#modalButton').html('{{__("Edit")}}');
        $('#formUser').attr('action', '{{ route('user.update') }}');
        $('#modalUser').modal('show');
        $.ajax({
            url: "{{ route('user.edit') }}",
            type: "GET",
            data: {
                id: id
            },
            dataType: "JSON",
            success: function(data) {
				// Handle plan features
                const features = data.plan_data ? data.plan_data : {};
				
                $('#labelpassword').html('{{__("Password *(leave blank if not change)")}}');
                $('#username').val(data.username);
                $('#email').val(data.email);
                $('#password').val(''); // Clear password field for security
				$('#messages_limit').val(features.messages_limit);
                $('#limit_device').val(features.device_limit);
                $('#active_subscription').val(data.active_subscription);
				$('#subscription_expired').val(data.subscription_expired.substring(0, 16));
                $('#iduser').val(data.id);

                $('input[type=checkbox]').each(function() {
                    const feature = $(this).attr('name').replace('plan_data[', '').replace(']', '');
                    $(this).prop('checked', features[feature] === true);
                });
            }
        });
    }
</script>
</x-layout-dashboard>
