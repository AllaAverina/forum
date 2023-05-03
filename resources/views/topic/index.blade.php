@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-3">
        <div class="col-auto">
            <a class="btn btn-outline-primary" href="{{ route('topics.create') }}">{{ __('Create a new topic') }}</a>
        </div>
    </div>

    <div class="row justify-content-center mb-3">
        <form method="GET" action="{{ route('topics.index') }}" class="col-md-8">
            @csrf
            <div class="input-group">
                <input type="search" name="search" class="col-md-4 form-control" placeholder="{{ __('Search topics') }}" aria-label="Search" value="{{ $search }}">
                <button type="submit" class="btn btn-outline-primary">{{ __('Search') }}</button>
            </div>
        </form>
    </div>

    <div class="row justify-content-center align-items-center mb-3">
        <div class="col-md-8">
            @forelse ($topics as $topic)
            <div class="card mb-2 card-hover">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="card-title">
                                <a class="link-dark link-hover" href="{{ route('topics.show', $topic->id) }}">{{ $topic->title }}</a>
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
                @if ($search)
                {{ __('Nothing was found for the search query') }} «{{ $search }}»
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