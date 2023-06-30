@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center bg-transparent">
                    <h2 class="card-title">@if (isset($post)) {{ __('Edit the post') }} @else {{ __('Create a new post') }} @endif</h2>
                </div>

                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success text-center py-1">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if (isset($post))
                    <form method="POST" action="{{ route('posts.update', $post->slug) }}">
                        @method('PUT')
                    @else
                    <form method="POST" action="{{ route('posts.store') }}">
                    @endif
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="topic" class="col-md-4 col-form-label text-md-end">{{ __('Topic') }}</label>

                            <div class="col-md-6">
                                <select class="form-select @error('topic_id') is-invalid @enderror" name="topic_id" id="topic" required autofocus>
                                    <option value="" hidden>{{ __('Choose a topic') }}</option>
                                    @foreach ($topics as $topic)
                                        <option value="{{ $topic->id }}" @selected(old('topic_id', $post->topic_id ?? '') == $topic->id)>{{ $topic->title }}</option>
                                    @endforeach
                                </select>

                                @error('topic_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title ?? '') }}" required autocomplete="title" autofocus>
                                                            
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
                                <input type="text" name="subtitle" id="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle', $post->subtitle ?? '') }}" autocomplete="subtitle">
                                
                                @error('subtitle')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="body" class="col-md-2 col-form-label text-md-end">{{ __('Text') }}</label>

                            <div class="col-md-9">
                                <textarea name="body" id="body" rows="15" class="form-control @error('body') is-invalid @enderror" style="resize: none;" required>{{ old('body', $post->body ?? '') }}</textarea>
                            
                                @error('body')
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