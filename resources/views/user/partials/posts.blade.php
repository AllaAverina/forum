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
                @can ('delete', $post)
                <div class="card-header bg-transparent">
                    <div class="row justify-content-end">
                        @if ($post->trashed())
                        <div class="col-auto">
                            <a class="btn btn-primary btn-sm" href="{{ route('posts.restore', $post->id) }}">{{ __('Restore') }}</a>
                        </div>
                        @else
                        <div class="col-auto">
                            <a class="btn btn-warning btn-sm" href="{{ route('posts.edit', $post->id) }}">{{ __('Edit') }}</a>
                        </div>

                        <div class="col-auto">
                            <form method="POST" action="{{ route('posts.destroy', $post->id) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">{{ __('Delete') }}</button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                @endcan

                <div class="card-body @if ($post->trashed()) opacity-50 @endif">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="card-title">
                                <a class="link-dark link-hover" href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                            </h5>

                            @if ($post->subtitle)
                            <p class="card-subtitle">{{ $post->subtitle }}</p>
                            @endif
                        </div>

                        <div class="col-md-2 py-1">
                            <span>{{ __('Topic') }}:
                                @if ($post->topic)
                                <a class="link-dark link-hover" href="{{ route('topics.show', $post->topic_id) }}">{{ $post->topic->title }}</a>
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