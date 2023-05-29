@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="card-title text-center">
                        <h2 class="text-center">{{ $user->name }}
                            <a class="btn btn-outline-primary btn-sm" href="{{ route('profile.edit') }}">{{ __('Edit profile') }}</a>
                        </h2>
                    </div>

                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link link-dark @if ($part === 'info') active @endif" href="{{ route('profile.show') }}">{{ __('Info') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-dark @if ($part === 'topics') active @endif" href="{{ route('profile.show', 'topics') }}">{{ __('Topics') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-dark @if ($part === 'posts') active @endif" href="{{ route('profile.show', 'posts') }}">{{ __('Posts') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-dark @if ($part === 'comments') active @endif" href="{{ route('profile.show', 'comments') }}">{{ __('Comments') }}</a>
                        </li>
                    </ul>

                    @include("user.partials.$part")
                </div>
            </div>
        </div>
    </div>
</div>
@endsection