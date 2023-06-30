@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-transparent text-center">
                    <h2 class="card-title">{{ $topic->title }}</h2>

                    @if ($topic->subtitle)
                    <h4 class="card-subtitle mb-3">{{ $topic->subtitle }}</h4>
                    @endif

                    <div class="card-subtitle text-center">
                        <small class="border border-secondary-subtle rounded-2 px-2">{{ __('Author') }}: <a class="link-dark link-hover" href="{{ route('users.show', $topic->user->nickname) }}">{{ $topic->user->name }}</a></small>
                        <small class="border border-secondary-subtle rounded-2 px-2">{{ __('Created at') }}: {{ $topic->created_at->format('d.m.Y') }}</small>
                        
                        @if ($topic->created_at->format('d.m.Y H:i') !== $topic->updated_at->format('d.m.Y H:i'))
                        <small class="border border-secondary-subtle rounded-2 px-2">{{ __('Updated at') }}: {{ $topic->updated_at->format('d.m.Y') }}</small>
                        @endif
                    </div>
                </div>

                <ul class="list-group list-group-flush">
                    @forelse ($posts as $post)
                    <li class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <a class="card-title link-dark link-hover fs-4" href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>

                                @if ($post->subtitle)
                                <p class="card-subtitle">{{ $post->subtitle }}</p>
                                @endif
                            </div>

                            <div class="col-md-2 text-md-center">
                                <span class="badge bg-secondary">{{ __('Comments') }}: {{ $post->comments_count }}</span>
                            </div>

                            <div class="col-md-2 text-md-center">
                                <small class="text-muted">
                                    {{ __('Last update') }}: {{ $post->updated_at->format('d.m.Y') }}
                                </small>
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