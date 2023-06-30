@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mb-2">
                @can('manage-moderators')
                <div class="card-header bg-transparent">
                    <div class="row justify-content-end">
                        @if ($user->hasRole('moderator'))
                        <div class="col-auto">
                            <form method="POST" action="{{ route('moderators.remove', $user->nickname) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn btn-warning btn-sm">{{ __('Remove moderator') }}</button>
                            </form>
                        </div>
                        @else
                        <div class="col-auto">
                            <form method="POST" action="{{ route('moderators.assign', $user->nickname) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn btn-warning btn-sm">{{ __('Assign a moderator') }}</button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                @endcan

                <div class="card-body">
                    <div class="card-title">
                        <h2 class="text-center">
                            {{ $user->name }}

                            @if (auth()->check() && auth()->user()->id === $user->id)
                            <a class="btn btn-outline-primary btn-sm" href="{{ route('profile.edit') }}">{{ __('Edit profile') }}</a>
                            @endif
                        </h2>

                        <h5 class="text-center text-muted">
                            {{ $user->nickname }}

                            @if ($user->hasRole('administrator'))
                            <span class="badge bg-warning text-dark">{{ __('Administrator') }}</span>
                            @endif

                            @if ($user->hasRole('moderator'))
                            <span class="badge bg-warning text-dark">{{ __('Moderator') }}</span>
                            @endif
                        </h5>
                    </div>

                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link link-dark @if ($part === 'info') active @endif" href="@if (request()->routeIs('users.show')) {{ route('users.show', $user->nickname) }} @elseif (request()->routeIs('profile.show')) {{ route('profile.show') }} @endif">
                                {{ __('Info') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-dark @if ($part === 'topics') active @endif" href="@if (request()->routeIs('users.show')) {{ route('users.show', [$user->nickname, 'topics']) }} @elseif (request()->routeIs('profile.show')) {{ route('profile.show', 'topics') }} @endif">{{ __('Topics') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-dark @if ($part === 'posts') active @endif" href="@if (request()->routeIs('users.show')) {{ route('users.show', [$user->nickname, 'posts']) }} @elseif (request()->routeIs('profile.show')) {{ route('profile.show', 'posts') }} @endif">{{ __('Posts') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-dark @if ($part === 'comments') active @endif" href="@if (request()->routeIs('users.show')) {{ route('users.show', [$user->nickname, 'comments']) }} @elseif (request()->routeIs('profile.show')) {{ route('profile.show', 'comments') }} @endif">{{ __('Comments') }}</a>
                        </li>
                    </ul>

                    @include("user.partials.$part")
                </div>
            </div>
        </div>
    </div>
</div>
@endsection