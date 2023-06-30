<div class="container">
    @if (session('success'))
    <div class="row justify-content-center mt-3">
        <div class="alert alert-success text-center py-1">
            {{ session('success') }}
        </div>
    </div>
    @endif

    <div class="row justify-content-center mt-3">
        @forelse ($posts as $post)
        <div class="card my-2 card-hover">
            <div class="row align-items-center">
                @canany(['update', 'forceDelete'], $post)
                <div class="card-header bg-transparent">
                    <div class="row justify-content-end">
                        @can('update', $post)
                        @if ($post->trashed())
                        <div class="col-auto">
                            <form method="POST" action="{{ route('posts.restore', $post->slug) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn btn-primary btn-sm">{{ __('Restore') }}</button>
                            </form>
                        </div>
                        @else
                        <div class="col-auto">
                            <a class="btn btn-warning btn-sm" href="{{ route('posts.edit', $post->slug) }}">{{ __('Edit') }}</a>
                        </div>

                        <div class="col-auto">
                            <form method="POST" action="{{ route('posts.destroy', $post->slug) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">{{ __('Delete') }}</button>
                            </form>
                        </div>
                        @endif
                        @endcan

                        @can('forceDelete', $post)
                        <div class="col-auto">
                            <form method="POST" action="{{ route('posts.forceDestroy', $post->slug) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">{{ __('Delete completely') }}</button>
                            </form>
                        </div>
                        @endcan
                    </div>
                </div>
                @endcanany

                <div class="card-body @if ($post->trashed()) opacity-50 @endif">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="card-title">
                                <a class="link-dark link-hover" href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                            </h5>

                            @if ($post->subtitle)
                            <p class="card-subtitle">{{ $post->subtitle }}</p>
                            @endif
                        </div>

                        <div class="col-md-2 py-1">
                            <span>{{ __('Topic') }}:
                                @if ($post->topic)
                                <a class="link-dark link-hover" href="{{ route('topics.show', $post->topic->slug) }}">{{ $post->topic->title }}</a>
                                @else
                                <span class="text-danger">{{ __('DELETED') }}</span>
                                @endif
                            </span>
                        </div>

                        <div class="col-md-2">
                            <small class="text-muted">
                                {{ __('Last update') }}: {{ $post->updated_at->format('d.m.Y') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center text-muted">
            {{ __('This user has not posted anything yet') }}
        </div>
        @endforelse

        @if ($posts->hasPages())
        <div class="pagination justify-content-center mt-3">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</div>