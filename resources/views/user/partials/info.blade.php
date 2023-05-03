<div class="container">
    <div class="row justify-content-center mt-3">
        <div class="card">
            <div class="row">
                <div class="card-body">
                    <div class="card-text">
                        <p class="text-muted">
                            {{ __('Registration date') }}: {{ $user->created_at->format('d.m.Y') }}
                        </p>
                        
                        {{ __('Email Address') }}: {{ $user->email }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>