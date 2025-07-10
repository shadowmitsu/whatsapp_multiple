<x-layout-dashboard title="{{__('Ticket Details')}}">
    <div class="content-body">
		<div class="container-fluid">
            <div class="card">
            <div class="card-header">
                    <h5 class="card-title mb-0">
                        #{{ $ticket->id }} - {{ $ticket->title }}
                    </h5>
                    <span class="badge bg-{{ $ticket->status === 'open' ? 'success' : 'secondary' }}">
                        {{ __($ticket->status) }}
                    </span>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>{{ __('Priority') }}:</strong>
                    <span class="badge bg-{{ $ticket->priority === 'high' ? 'danger' : ($ticket->priority === 'medium' ? 'warning' : 'info') }}">
                        {{ __($ticket->priority) }}
                    </span>
                </div>
                <div class="mb-3">
                    <strong>{{ __('Created') }}:</strong> {{ $ticket->created_at->format('Y-m-d H:i') }}
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
                            <div class="d-inline-block {{ $message->user_id === auth()->id() ? 'bg-primary text-white' : 'bg-light' }} p-3 rounded">
                                <div class="message-header mb-2">
                                    <small>
                                        {{ $message->user->username }} - {{ \App\Traits\ConvertsDates::convertToUserTimezone($message->updated_at) }}
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
                    <form action="{{ route('user.tickets.reply', $ticket) }}" method="POST" class="mt-4">
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
            <a href="{{ route('user.tickets.index') }}" class="btn btn-secondary">
                {{ __('Back to Tickets') }}
            </a>
        </div>
    </div>
</div>
</x-layout-dashboard>