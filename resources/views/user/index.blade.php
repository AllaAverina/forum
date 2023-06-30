@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-3">
        <form method="GET" action="{{ route('users.index') }}" class="col-md-10">
            <div class="input-group">
                <input type="search" name="search" class="col-md-4 form-control" placeholder="{{ __('Search users') }}" aria-label="Search" value="{{ old('search', request()->get('search', ''))}}">
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

                        @if (request()->sort === 'name' && request()->order === 'asc')
                        <a class="flex-sm-fill text-sm-center nav-link @if (request()->sort === 'name') active @endif" href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'order' => 'desc']) }}">{{ __('Alphabetically') }} ▼</a>
                        @else
                        <a class="flex-sm-fill text-sm-center nav-link @if (request()->sort === 'name') active @endif" href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'order' => 'asc']) }}">{{ __('Alphabetically') }} ▲</a>
                        @endif

                        @if (request()->sort === 'topics_count' && request()->order === 'desc')
                        <a class="flex-sm-fill text-sm-center nav-link @if (request()->sort === 'topics_count') active @endif" href="{{ request()->fullUrlWithQuery(['sort' => 'topics_count', 'order' => 'asc']) }}">{{ __('Number of topics') }} ▲</a>
                        @else
                        <a class="flex-sm-fill text-sm-center nav-link @if (request()->sort === 'topics_count') active @endif" href="{{ request()->fullUrlWithQuery(['sort' => 'topics_count', 'order' => 'desc']) }}">{{ __('Number of topics') }} ▼</a>
                        @endif

                        @if (request()->sort === 'posts_count' && request()->order === 'desc')
                        <a class="flex-sm-fill text-sm-center nav-link @if (request()->sort === 'posts_count') active @endif" href="{{ request()->fullUrlWithQuery(['sort' => 'posts_count', 'order' => 'asc']) }}">{{ __('Number of posts') }} ▲</a>
                        @else
                        <a class="flex-sm-fill text-sm-center nav-link @if (request()->sort === 'posts_count') active @endif" href="{{ request()->fullUrlWithQuery(['sort' => 'posts_count', 'order' => 'desc']) }}">{{ __('Number of posts') }} ▼</a>
                        @endif

                        @if (request()->sort === 'comments_count' && request()->order === 'desc')
                        <a class="flex-sm-fill text-sm-center nav-link @if (request()->sort === 'comments_count') active @endif" href="{{ request()->fullUrlWithQuery(['sort' => 'comments_count', 'order' => 'asc']) }}">{{ __('Number of comments') }} ▲</a>
                        @else
                        <a class="flex-sm-fill text-sm-center nav-link @if (request()->sort === 'comments_count') active @endif" href="{{ request()->fullUrlWithQuery(['sort' => 'comments_count', 'order' => 'desc']) }}">{{ __('Number of comments') }} ▼</a>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div id="users" class="row justify-content-center align-items-center mb-3">
        <div class="col-md-10">
            @forelse ($users as $user)
            <div class="card mb-2 card-hover">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title">
                                <a class="link-dark link-hover" href="{{ route('users.show', $user->nickname) }}">
                                    {{ $user->name }}
                                </a>

                                @if ($user->hasRole('administrator'))
                                <span class="badge bg-warning text-dark">{{ __('Administrator') }}</span>
                                @endif

                                @if ($user->hasRole('moderator'))
                                <span class="badge bg-warning text-dark">{{ __('Moderator') }}</span>
                                @endif
                            </h5>
                        </div>

                        <div class="col-md-4 text-md-center">
                            <span class="badge bg-secondary">{{ __('Topics') }}: {{ $user->topics_count }}</span>
                            <span class="badge bg-secondary">{{ __('Posts') }}: {{ $user->posts_count }}</span>
                            <span class="badge bg-secondary">{{ __('Comments') }}: {{ $user->comments_count }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center">
                @if (request()->has('search'))
                {{ __('Nothing was found for the search query') }} «{{ request()->search }}»
                @else
                {{ __('There are no users yet') }}
                @endif
            </div>
            @endforelse
        </div>
    </div>

    @if ($users->hasPages())
    <div class="pagination justify-content-center mt-3">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection