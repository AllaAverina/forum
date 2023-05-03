<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center border-danger">
                <div class="card-header border-danger bg-transparent">
                    <h2 class="card-title">
                        {{ __('Delete Account') }}
                    </h2>

                    <h5 class="card-subtitle">
                        {{ __('Before deleting your account, please download any data or information that you wish to retain, otherwise all its resources and data will be permanently deleted') }}
                    </h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('DELETE')

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-danger">
                                    {{ __('Delete') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
