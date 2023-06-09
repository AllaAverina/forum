@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mb-2">
                <div class="card-header text-center bg-transparent">
                    <h2 class="card-title">{{ $post->title }}</h2>

                    @if ($post->subtitle)
                    <h4 class="card-subtitle mb-3">{{ $post->subtitle }}</h4>
                    @endif

                    <div class="card-subtitle text-center">
                        <small class="border border-secondary-subtle rounded-2 px-2">{{ __('Topic') }}: <a class="link-dark link-hover" href="{{ route('topics.show', $post->topic->slug) }}">{{ $post->topic->title }}</a></small>
                        <small class="border border-secondary-subtle rounded-2 px-2">{{ __('Author') }}: <a class="link-dark link-hover" href="{{ route('users.show', $post->user->nickname) }}">{{ $post->user->name }}</a></small>
                        <small class="border border-secondary-subtle rounded-2 px-2">{{ __('Created at') }}: {{ $post->created_at->format('d.m.Y') }}</small>

                        @if ($post->created_at->format('d.m.Y H:i') !== $post->updated_at->format('d.m.Y H:i'))
                        <small class="border border-secondary-subtle rounded-2 px-2">{{ __('Updated at') }}: {{ $post->updated_at->format('d.m.Y') }}</small>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <div class="card-text">
                        {{ $post->body }}
                    </div>
                </div>
            </div>

            <div class="card mb-2">
                <div class="card-body">
                    <h4 class="card-title">{{ __('Add a comment') }}</h4>

                    <div class="card-text">
                        <form action="{{ route('posts.comments.store', $post->slug) }}" method="POST">
                            @csrf
                            <div class="form-group mb-2">
                                @error('body')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <textarea name="body" id="body" rows="2" class="form-control @error('body') is-invalid @enderror">{{ old('body') }}</textarea>
                            </div>

                            <div class="row col-md-2 mx-auto">
                                <button type="submit" class="btn btn-outline-primary">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card mb-2">
                <div id="comments" class="card-header bg-transparent">
                    <span>{{ __('Comments') }}: {{ count($comments) }}</span>
                </div>

                <ul class="list-group list-group-flush">
                    @forelse ($comments as $comment)
                    <li class="list-group-item">
                        <small>
                            <a class="link-dark link-hover" href="{{ route('users.show', $comment->user->nickname) }}">{{ $comment->user->name }}</a>

                            @if ($comment->user->hasRole('moderator'))
                            <span class="badge bg-warning text-dark">{{ __('Moderator') }}</span>
                            @endif

                            @if ($comment->user->hasRole('administrator'))
                            <span class="badge bg-warning text-dark">{{ __('Administrator') }}</span>
                            @endif

                            <span class="mx-1">·</span>
                            <span>{{ $comment->created_at->format('d.m.Y H:i') }}</span>

                            @if ($comment->created_at->format('d.m.Y H:i') !== $comment->updated_at->format('d.m.Y H:i'))
                            <span class="mx-1">·</span>
                            <span>{{ __('Updated at') }} {{ $comment->updated_at->format('d.m.Y H:i') }}</span>
                            @endif
                        </small>

                        <p class="mt-2">{{ $comment->body }}</p>
                    </li>
                    @empty
                    <div class="text-center text-muted my-3">
                        {{ __('No one has commented on this post yet') }}
                    </div>
                    @endforelse
                </ul>

                @if ($comments->hasPages())
                <div class="pagination justify-content-center mt-3">
                    {{ $comments->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection