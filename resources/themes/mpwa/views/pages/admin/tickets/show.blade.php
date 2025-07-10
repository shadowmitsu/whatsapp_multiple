<x-layout-dashboard title="{{__('Ticket Details')}}">
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        #{{ $ticket->id }} - {{ $ticket->title }}
                    </h5>
                    <div>
                        @if($ticket->status === 'open')
                            <form action="{{ route('admin.tickets.close', $ticket) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-warning">
                                    {{ __('Close Ticket') }}
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.tickets.reopen', $ticket) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    {{ __('Reopen Ticket') }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4">{{ __('Status') }}</dt>
                            <dd class="col-sm-8">
                                <span class="badge bg-{{ $ticket->status === 'open' ? 'success' : 'secondary' }}">
                                    {{ __(ucfirst($ticket->status)) }}
                                </span>
                            </dd>

                            <dt class="col-sm-4">{{ __('Priority') }}</dt>
                            <dd class="col-sm-8">
                                <span class="badge bg-{{ $ticket->priority === 'high' ? 'danger' : ($ticket->priority === 'medium' ? 'warning' : 'info') }}">
                                    {{ __(ucfirst($ticket->priority)) }}
                                </span>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4">{{ __('Created By') }}</dt>
                            <dd class="col-sm-8">{{ $ticket->user->username ?? __('Deleted') }}</dd>

                            <dt class="col-sm-4">{{ __('Created At') }}</dt>
                            <dd class="col-sm-8">{{ $ticket->created_at->format('Y-m-d H:i') }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">{{ __('Messages') }}</h5>
            </div>
            <div class="card-body">
                <div class="messages">
                    @foreach($ticket->messages as $message)
                        <div class="message mb-4 {{ $message->user_id === auth()->id() ? 'text-start' : 'text-end' }}">
                            <div class="d-inline-block {{ $message->user_id === auth()->id() ? 'bg-primary text-white' : 'bg-light' }} p-3 rounded" style="max-width: 80%;">
                                <div class="message-header mb-2">
                                    <small>
                                        <strong>{{ $message->user->username ?? __('Deleted') }}</strong> - {{ \App\Traits\ConvertsDates::convertToUserTimezone($message->updated_at) }}
                                    </small>
                                </div>
                                <div class="message-content">
                                    {{ $message->message }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($ticket->status === 'open')
                    <form action="{{ route('admin.tickets.reply', $ticket) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="mb-3">
                            <label for="message" class="form-label">{{ __('Reply') }}</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" name="message" rows="3" required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            {{ __('Send Reply') }}
                        </button>
                    </form>
                @else
                    <div class="alert alert-info">
                        {{ __('This ticket is closed') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="mb-3">
            <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">
                {{ __('Back to Tickets') }}
            </a>
        </div>
    </div>
</x-layout-dashboard>