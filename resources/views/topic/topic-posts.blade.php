@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-transparent text-center">
                    <h2 class="card-title">{{ $topic->title }}</h2>

                    @if ($topic->subtitle)
                    <h4 class="card-subtitle">{{ $topic->subtitle }}</h4>
                    @endif

                    <small class="border border-secondary rounded-5 px-2">
                        {{ __('Author') }}:
                        <a class="link-dark link-hover" href="{{ route('users.show', $topic->user_id) }}">
                            {{ $topic->user->name }}
                        </a>
                    </small>
                </div>

                <ul class="list-group list-group-flush">
                    @forelse ($posts as $post)
                    <li class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-md-10">
                                <a class="card-title link-dark link-hover fs-4" href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>

                                @if ($post->subtitle)
                                <p class="card-subtitle">{{ $post->subtitle }}</p>
                                @endif
                            </div>

                            <div class="col-md-2 text-md-center">
                                <span class="badge bg-secondary">{{ __('Comments') }}: {{ $post->comments_count }}</span>
                            </div>
                        </div>
                    </li>
                    @empty
                    <div class="text-center text-muted my-3">
                        {{ __('No one has posted on this topic yet') }}
                    </div>
                    @endforelse
                </ul>

                @if ($posts->hasPages())
                <div class="pagination justify-content-center mt-3">
                    {{ $posts->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection