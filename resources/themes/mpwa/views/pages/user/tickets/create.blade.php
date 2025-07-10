<x-layout-dashboard title="{{__('Create Ticket')}}">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">{{ __('Create New Ticket') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('user.tickets.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">{{ __('Title') }}</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="priority" class="form-label">{{ __('Priority') }}</label>
                        <select class="form-select @error('priority') is-invalid @enderror" 
                                id="priority" name="priority" required>
                            <option value="">{{ __('Select Priority') }}</option>
                            <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>{{ __('Low') }}</option>
                            <option value="medium" {{ old('priority') === 'medium' ? 'selected' : '' }}>{{ __('Medium') }}</option>
                            <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>{{ __('High') }}</option>
                        </select>
                        @error('priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">{{ __('Message') }}</label>
                        <textarea class="form-control @error('message') is-invalid @enderror" 
                                  id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('user.tickets.index') }}" class="btn btn-secondary">
                            {{ __('Back') }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            {{ __('Create Ticket') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout-dashboard>