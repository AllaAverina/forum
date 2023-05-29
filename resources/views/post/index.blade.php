@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-3">
        <div class="col-auto">
            <a class="btn btn-outline-primary" href="{{ route('posts.create') }}">{{ __('Create a new post') }}</a>
        </div>
    </div>

    <div class="row justify-content-center mb-3">
        <form method="GET" action="{{ route('posts.index') }}" class="col-md-10">
            @csrf
            <div class="input-group">
                <input type="search" name="search" class="col-md-4 form-control" placeholder="{{ __('Search posts') }}" aria-label="Search" value="{{ $search }}">
                <button type="submit" class="btn btn-outline-primary">{{ __('Search') }}</button>
            </div>
        </form>
    </div>

    <div class="row justify-content-center mb-3">
        <div class="col-md-10">
            @forelse ($posts as $post)
            <div class="card mb-2 card-hover">
                <div class="card-body">
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
                            <span class="badge bg-secondary">{{ __('Comments') }}: {{ $post->comments_count }}</span>
                        </div>

                        <div class="col-md-2 text-md-center">
                            <small class="text-muted">
                                {{ __('Last update') }}: {{ $post->updated_at->format('d.m.Y') }}
                            </small>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-transparent">
                    <small>
                        {{ __('Author') }}:
                        <a class="link-dark link-hover" href="{{ route('users.show', $post->user_id) }}">
                            {{ $post->user->name }}
                        </a>
                    </small>

                    <span class="mx-1">·</span>

                    <small>
                        {{ __('Topic') }}:
                        <a class="link-dark link-hover" href="{{ route('topics.show', $post->topic_id) }}">
                            {{ $post->topic->title }}
                        </a>
                    </small>
                </div>
            </div>
            @empty
            <div class="text-center">
                @if ($search)
                {{ __('Nothing was found for the search query') }} «{{ $search }}»
                @else
                {{ __('Posts have not been created yet') }}
                @endif
            </div>
            @endforelse
        </div>
    </div>

    @if ($posts->hasPages())
    <div class="pagination justify-content-center">
        {{ $posts->links() }}
    </div>
    @endif
</div>
@endsection