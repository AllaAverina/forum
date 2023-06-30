<div class="container">
    @if (session('success'))
    <div class="row justify-content-center mt-3">
        <div class="alert alert-success text-center py-1">
            {{ session('success') }}
        </div>
    </div>
    @endif

    <div class="row justify-content-center mt-3">
        @forelse ($topics as $topic)
        <div class="card my-2 card-hover">
            <div class="row align-items-center">
                @canany(['update', 'forceDelete'], $topic)
                <div class="card-header bg-transparent">
                    <div class="row justify-content-end">
                        @can('update', $topic)
                        @if ($topic->trashed())
                        <div class="col-auto">
                            <form method="POST" action="{{ route('topics.restore', $topic->slug) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn btn-primary btn-sm">{{ __('Restore') }}</button>
                            </form>
                        </div>
                        @else
                        <div class="col-auto">
                            <a class="btn btn-warning btn-sm" href="{{ route('topics.edit', $topic->slug) }}">{{ __('Edit') }}</a>
                        </div>

                        <div class="col-auto">
                            <form method="POST" action="{{ route('topics.destroy', $topic->slug) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">{{ __('Delete') }}</button>
                            </form>
                        </div>
                        @endif
                        @endcan

                        @can('forceDelete', $topic)
                        <div class="col-auto">
                            <form method="POST" action="{{ route('topics.forceDestroy', $topic->slug) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">{{ __('Delete completely') }}</button>
                            </form>
                        </div>
                        @endcan
                    </div>
                </div>
                @endcanany

                <div class="card-body @if ($topic->trashed()) opacity-50 @endif">
                    <div class="row align-items-center">
                        <div class="col-md-10">
                            <h5 class="card-title">
                                <a class="link-dark link-hover" href="{{ route('topics.show', $topic->slug) }}">{{ $topic->title }}</a>
                            </h5>

                            @if ($topic->subtitle)
                            <p class="card-subtitle">{{ $topic->subtitle }}</p>
                            @endif
                        </div>

                        <div class="col-md-2">
                            <small class="text-muted">
                                {{ __('Last update') }}: {{ $topic->updated_at->format('d.m.Y') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center text-muted">
            {{ __('This user has not create topics yet') }}
        </div>
        @endforelse

        @if ($topics->hasPages())
        <div class="pagination justify-content-center mt-3">
            {{ $topics->links() }}
        </div>
        @endif
    </div>
</div>