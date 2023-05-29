@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="card-title">
                        <h2 class="text-center">{{ $user->name }}</h2>
                    </div>

                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link link-dark @if ($part === 'info') active @endif" href="{{ route('users.show', [$user->id]) }}">{{ __('Info') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-dark @if ($part === 'topics') active @endif" href="{{ route('users.show', [$user->id, 'topics']) }}">{{ __('Topics') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-dark @if ($part === 'posts') active @endif" href="{{ route('users.show', [$user->id, 'posts']) }}">{{ __('Posts') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-dark @if ($part === 'comments') active @endif" href="{{ route('users.show', [$user->id, 'comments']) }}">{{ __('Comments') }}</a>
                        </li>
                    </ul>

                    @include("user.partials.$part")
                </div>
            </div>
        </div>
    </div>
</div>
@endsection