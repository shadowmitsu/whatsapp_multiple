<x-layout-dashboard title="{{__('Manage Tickets')}}">
    <div class="content-body">
		<div class="container-fluid">
            <div class="card">
            <div class="card-header">
                <h5 class="card-title">{{ __('All Tickets') }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('User') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Priority') }}</th>
                                <th>{{ __('Last Update') }}</th>
                                <th>{{ __('Created') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr>
                                    <td>#{{ $ticket->id }}</td>
                                    <td>{{ $ticket->user->username ?? __('Deleted') }}</td>
                                    <td>{{ $ticket->title }}</td>
                                    <td>
                                        <span class="badge bg-{{ $ticket->status === 'open' ? 'success' : 'secondary' }}">
                                            {{ __(ucfirst($ticket->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $ticket->priority === 'high' ? 'danger' : ($ticket->priority === 'medium' ? 'warning' : 'info') }}">
                                            {{ __(ucfirst($ticket->priority)) }}
                                        </span>
                                    </td>
                                    <td>{{ $ticket->updated_at->format('Y-m-d H:i') }}</td>
                                    <td>{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.tickets.show', $ticket) }}" class="btn btn-sm btn-info">
                                            {{ __('View') }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">{{ __('No tickets found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $tickets->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</x-layout-dashboard>