<div class="container">
    @if (session('success'))
    <div class="row justify-content-center mt-3">
        <div class="alert alert-success text-center py-1">
            {{ session('success') }}
        </div>
    </div>
    @endif

    <div class="row justify-content-center mt-3">
        @forelse ($comments as $comment)
        <div class="card my-2 card-hover">
            <div class="row align-items-center">
                @can ('delete', $comment)
                <div class="card-header bg-transparent">
                    <div class="row justify-content-end">
                        @if ($comment->trashed())
                        <div class="col-auto">
                            <form method="POST" action="{{ route('comments.restore', $comment->id) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn btn-primary btn-sm">{{ __('Restore') }}</button>
                            </form>
                        </div>
                        @else
                        <div class="col-auto">
                            <a class="btn btn-warning btn-sm" href="{{ route('comments.edit', $comment->id) }}">{{ __('Edit') }}</a>
                        </div>

                        <div class="col-auto">
                            <form method="POST" action="{{ route('comments.destroy', $comment->id) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">{{ __('Delete') }}</button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                @endcan

                <div class="card-body  @if ($comment->trashed()) opacity-50 @endif">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <p class="card-text">{{ $comment->body }}</p>
                        </div>

                        <div class="col-md-2 py-1">
                            <span>{{ __('Post') }}:
                                @if ($comment->post)
                                <a class="link-dark link-hover" href="{{ route('posts.show', $comment->post_id) }}">{{ $comment->post->title }}</a>
                                @else
                                <span class="text-danger">{{ __('DELETED') }}</span>
                                @endif
                            </span>
                        </div>

                        <div class="col-md-2">
                            <small class="text-muted">
                                {{ __('Last update') }}: {{ $comment->updated_at->format('d.m.Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center text-muted">
            {{ __('This user has not commented anything yet') }}
        </div>
        @endforelse

        @if ($comments->hasPages())
        <div class="pagination justify-content-center mt-3">
            {{ $comments->links() }}
        </div>
        @endif
    </div>
</div>