@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-3">
        <div class="col-auto">
            <a class="btn btn-outline-primary" href="{{ route('topics.create') }}">{{ __('Create a new topic') }}</a>
        </div>
    </div>

    <div class="row justify-content-center mb-3">
        <form method="GET" action="{{ route('topics.index') }}" class="col-md-10">
            {{--@csrf--}}
            <div class="input-group">
                <input type="search" name="search" class="col-md-4 form-control" placeholder="{{ __('Search topics') }}" aria-label="Search" value="{{ old('search', request()->get('search', '')) }}">
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

                        @if (request()->sort === 'posts_count' && request()->order === 'desc')
                        <a class="flex-sm-fill text-sm-center nav-link @if (request()->sort === 'posts_count') active @endif" href="{{ request()->fullUrlWithQuery(['sort' => 'posts_count', 'order' => 'asc']) }}">{{ __('Number of posts') }} ▲</a>
                        @else
                        <a class="flex-sm-fill text-sm-center nav-link @if (request()->sort === 'posts_count') active @endif" href="{{ request()->fullUrlWithQuery(['sort' => 'posts_count', 'order' => 'desc']) }}">{{ __('Number of posts') }} ▼</a>
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

    <div id="topics" class="row justify-content-center align-items-center mb-3">
        <div class="col-md-10">
            @forelse ($topics as $topic)
            <div class="card mb-2 card-hover">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="card-title">
                                <a class="link-dark link-hover" href="{{ route('topics.show', $topic->slug) }}">{{ $topic->title }}</a>
                            </h5>

                            @if ($topic->subtitle)
                            <p class="card-subtitle">{{ $topic->subtitle }}</p>
                            @endif
                        </div>

                        <div class="col-md-2 py-1">
                            <span class="badge bg-secondary">{{ __('Posts') }}: {{ $topic->posts_count }}</span>
                        </div>

                        <div class="col-md-2 text-md-center">
                            <small class="text-muted">
                                {{ __('Last update') }}: {{ $topic->updated_at->format('d.m.Y') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center">
                @if (request()->has('search'))
                {{ __('Nothing was found for the search query') }} «{{ request()->search }}»
                @else
                {{ __('Topics have not been created yet') }}
                @endif
            </div>
            @endforelse
        </div>
    </div>

    @if ($topics->hasPages())
    <div class="pagination justify-content-center">
        {{ $topics->links() }}
    </div>
    @endif
</div>
@endsection