@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center bg-transparent">
                    <h2 class="card-title">@if (isset($topic)) {{ __('Edit the topic') }} @else {{ __('Create a new topic') }} @endif</h2>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success text-center py-1">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (isset($topic))
                    <form method="POST" action="{{ route('topics.update', $topic->id) }}">
                        @method('PUT')
                    @else
                    <form method="POST" action="{{ route('topics.store') }}">
                    @endif
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $topic->title ?? '') }}" required autocomplete="title" autofocus>
                                                            
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="subtitle" class="col-md-4 col-form-label text-md-end">{{ __('Subtitle') }}</label>

                            <div class="col-md-6">
                                <input type="text" name="subtitle" id="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle', $topic->subtitle ?? '') }}" autocomplete="subtitle">
                                
                                @error('subtitle')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row col-md-2 mx-auto">
                            <button type="submit" class="btn btn-outline-primary">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection