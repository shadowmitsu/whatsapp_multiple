@php
    $numbers = request()->user()->devices()->latest()->paginate(15);
@endphp
        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
				<ul class="metismenu" id="menu">
				@if(env("ENABLE_INDEX") == 'yes')
				    <li>
						<a href="{{ route('index') }}" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-home"></i>
							<span class="nav-text">{{__('Home')}}</span>
						</a>
					</li>
				@endif
					<li class="{{ request()->is('home') ? 'mm-active' : '' }}">
						<a href="{{ route('home') }}" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-layer"></i>
							<span class="nav-text">{{__('Dashboard')}}</span>
						</a>
					</li>
					<li class="{{ request()->is('file-manager') ? 'mm-active' : '' }}">
						<a href="{{ route('file-manager') }}" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-folder"></i>
							<span class="nav-text">{{__('File Manager')}}</span>
						</a>
					</li>
					<li class="{{ request()->is('phonebook') ? 'mm-active' : '' }}">
						<a href="{{ route('phonebook') }}" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-phone-call"></i>
							<span class="nav-text">{{__('Phone Book')}}</span>
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="ai-icon has-arrow" aria-expanded="false">
							<i class="flaticon-381-newspaper"></i>
							<span class="nav-text">{{__('Reports')}}</span>
						</a>
						<ul aria-expanded="false">
                            <li class="{{ request()->is('campaigns') ? 'mm-active' : '' }}">
								<a href="{{ route('campaigns') }}">{{__('Campaign / Blast')}}</a>
							</li>
                            <li class="{{ request()->is('messages.history') ? 'mm-active' : '' }}">
								<a href="{{ route('messages.history') }}">{{__('Messages History')}}</a>
							</li>
						</ul>
					</li>
					@if (Auth::user()->level != 'admin')
					<li class="{{ request()->is('user.tickets') ? 'mm-active' : '' }}">
						<a href="{{ route('user.tickets.index') }}" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-help-1"></i>
							<span class="nav-text">{{__('Tickets')}}</span>
						</a>
					</li>
					@endif
					
					<x-select-device :numbers="$numbers"></x-select-device>
					
				{{-- these menus only show if exists selected devices --}}
				@if (Session::has('selectedDevice'))
                    <li class="{{ request()->is('autoreply') ? 'mm-active' : '' }}">
						<a href="{{ route('autoreply') }}" class="ai-icon" aria-expanded="false">
							<i class="fa-regular fa-comment-dots"></i>
							<span class="nav-text">{{__('Auto Reply')}}</span>
						</a>
					</li>
					<li class="{{ request()->is('aibot') ? 'mm-active' : '' }}">
						<a href="{{ route('aibot') }}" class="ai-icon" aria-expanded="false">
							<i class="fa-solid fa-robot"></i>
							<span class="nav-text">{{__('AI Bot')}}</span>
						</a>
					</li>
					<li class="{{ request()->is('campaign.create') ? 'mm-active' : '' }}">
						<a href="{{ route('campaign.create') }}" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-box"></i>
							<span class="nav-text">{{__('Create Campaign')}}</span>
						</a>
					</li>
					<li class="{{ request()->is('messagetest') ? 'mm-active' : '' }}">
						<a href="{{ route('messagetest') }}" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-send-1"></i>
							<span class="nav-text">{{__('Test Message')}}</span>
						</a>
					</li>
				@endif
					<li class="{{ request()->is('rest-api') ? 'mm-active' : '' }}">
						<a href="{{ route('rest-api') }}" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-cloud-computing"></i>
							<span class="nav-text">{{__('API Docs')}}</span>
						</a>
					</li>
				@if (Auth::user()->level == 'admin')
                    <li>
						<a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-settings-2"></i>
							<span class="nav-text">{{__('Admin')}}</span>
						</a>
                        <ul aria-expanded="false">
                            <li class="{{ request()->is('admin.settings') ? 'mm-active' : '' }}">
								<a href="{{ route('admin.settings') }}">{{__('Setting Server')}}</a>
							</li>
                            <li class="{{ request()->is('admin.manage-users') ? 'mm-active' : '' }}">
								<a href="{{ route('admin.manage-users') }}">{{__('Manage User')}}</a>
							</li>
							<li class="{{ request()->is('admin.manage-themes') ? 'mm-active' : '' }}">
                               <a href="{{ route('admin.manage-themes') }}">{{__('Manage Themes')}}</a>
                            </li>
							<li class="{{ request()->is('languages.index') ? 'mm-active' : '' }}">
                               <a href="{{ route('languages.index') }}">{{__('Manage Languages')}}</a>
                           </li>
						   <li class="{{ request()->is('admin.index.edit') ? 'mm-active' : '' }}">
                               <a href="{{ route('admin.index.edit') }}">{{__('Manage Homepage')}}</a>
                           </li>
						   <li class="{{ request()->is('admin.plans.index') ? 'mm-active' : '' }}">
                               <a href="{{ route('admin.plans.index') }}">{{__('Manage Plans')}}</a>
                           </li>
						   <li class="{{ request()->is('admin.payments.index') ? 'mm-active' : '' }}">
                               <a href="{{ route('admin.payments.index') }}">{{__('Manage Payments')}}</a>
                           </li>
						   <li class="{{ request()->is('admin.tickets') ? 'mm-active' : '' }}">
                               <a href="{{ route('admin.tickets.index') }}">{{__('Manage Tickets')}}</a>
                           </li>
						   <li class="{{ request()->is('admin.notifications.index') ? 'mm-active' : '' }}">
                               <a href="{{ route('admin.notifications.index') }}">{{__('Send Notification')}}</a>
                           </li>
						   <li class="{{ request()->is('admin.orders.index') ? 'mm-active' : '' }}">
                               <a href="{{ route('admin.orders.index') }}">{{__('Orders')}}</a>
                           </li>
							<li class="{{ request()->is('cronjob') ? 'mm-active' : '' }}">
								<a href="{{ route('cronjob') }}">{{__('Cronjob')}}</a>
							</li>
							<li class="{{ request()->is('update') ? 'mm-active' : '' }}">
								<a href="{{ route('update') }}">{{__('Update')}}</a>
							</li>
                        </ul>
                    </li>
				@endif
                </ul>

				<div class="copyright">
				{!! config('config.footer_copyright') !!}
				</div>
			</div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->