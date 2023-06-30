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
            <div class="input-group">
                <input type="search" name="search" class="col-md-4 form-control" placeholder="{{ __('Search posts') }}" aria-label="Search" value="{{ old('search', request()->get('search', '')) }}">
                <button type="submit" class="btn btn-outline-primary">{{ __('Search') }}</button>
            </div>
        </form>
    </div>

    <div class="row justify-content-center align-items-center mb-3">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body py-1">
                    <nav class="nav nav-pills flex-column flex-sm-row">
                        <span class="fs-5 flex-sm-fill align-self-center">{{ __('Sort by') }}:</span>

                        @if (request()->sort === 'title' && request()->order === 'asc')
                        <a class="flex-sm-fill text-sm-center nav-link @if (request()->sort === 'title') active @endif" href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'order' => 'desc']) }}">{{ __('Alphabetically') }} ▼</a>
                        @else
                        <a class="flex-sm-fill text-sm-center nav-link @if (request()->sort === 'title') active @endif" href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'order' => 'asc']) }}">{{ __('Alphabetically') }} ▲</a>
                        @endif

                        @if (request()->sort === 'comments_count' && request()->order === 'desc')
                        <a class="flex-sm-fill text-sm-center nav-link @if (request()->sort === 'comments_count') active @endif" href="{{ request()->fullUrlWithQuery(['sort' => 'comments_count', 'order' => 'asc']) }}">{{ __('Number of comments') }} ▲</a>
                        @else
                        <a class="flex-sm-fill text-sm-center nav-link @if (request()->sort === 'comments_count') active @endif" href="{{ request()->fullUrlWithQuery(['sort' => 'comments_count', 'order' => 'desc']) }}">{{ __('Number of comments') }} ▼</a>
                        @endif

                        @if (request()->sort === 'updated_at' && request()->order === 'desc')
                        <a class="flex-sm-fill text-sm-center nav-link @if (request()->sort === 'updated_at') active @endif" href="{{ request()->fullUrlWithQuery(['sort' => 'updated_at', 'order' => 'asc']) }}">{{ __('Last update date') }} ▲</a>
                        @else
                        <a class="flex-sm-fill text-sm-center nav-link @if (request()->sort === 'updated_at') active @endif" href="{{ request()->fullUrlWithQuery(['sort' => 'updated_at', 'order' => 'desc']) }}">{{ __('Last update date') }} ▼</a>
                        @endif

                        @if (request()->sort === 'created_at' && request()->order === 'desc')
                        <a class="flex-sm-fill text-sm-center nav-link @if (request()->sort === 'created_at') active @endif" href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'order' => 'asc']) }}">{{ __('Created date') }} ▲</a>
                        @else
                        <a class="flex-sm-fill text-sm-center nav-link @if (request()->sort === 'created_at') active @endif" href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'order' => 'desc']) }}">{{ __('Created date') }} ▼</a>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div id="posts" class="row justify-content-center mb-3">
        <div class="col-md-10">
            @forelse ($posts as $post)
            <div class="card mb-2 card-hover">
                <div class="card-body">
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
                        <a class="link-dark link-hover" href="{{ route('users.show', $post->user->nickname) }}">
                            {{ $post->user->name }}
                        </a>
                    </small>

                    <span class="mx-1">·</span>

                    <small>
                        {{ __('Topic') }}:
                        <a class="link-dark link-hover" href="{{ route('topics.show', $post->topic->slug) }}">
                            {{ $post->topic->title }}
                        </a>
                    </small>
                </div>
            </div>
            @empty
            <div class="text-center">
                @if (request()->has('search'))
                {{ __('Nothing was found for the search query') }} «{{ request()->search }}»
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