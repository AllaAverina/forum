@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-3">
        <form method="GET" action="{{ route('users.index') }}" class="col-md-8">
            @csrf
            <div class="input-group">
                <input type="search" name="search" class="col-md-4 form-control" placeholder="{{ __('Search users') }}" aria-label="Search" value="{{ $search }}">
                <button type="submit" class="btn btn-outline-primary">{{ __('Search') }}</button>
            </div>
        </form>
    </div>

    <div class="row justify-content-center align-items-center mb-3">
        <div class="col-md-8">
            @forelse ($users as $user)
            <div class="card mb-2 card-hover">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title">
                                <a class="link-dark link-hover" href="{{ route('users.show', $user->id) }}">
                                    {{ $user->name }}
                                </a>
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
                @if ($search)
                {{ __('Nothing was found for the search query') }} «{{ $search }}»  
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