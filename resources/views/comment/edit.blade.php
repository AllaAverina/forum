@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center bg-transparent">
                    <h2 class="card-title">{{ __('Edit the comment') }}</h2>
                </div>

                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success text-center py-1">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('comments.update', $comment->id) }}">
                        @method('PUT')
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="body" class="col-md-2 col-form-label text-md-end">{{ __('Text') }}</label>

                            <div class="col-md-9">
                                <textarea name="body" id="body" rows="15" class="form-control @error('body') is-invalid @enderror" style="resize: none;" required autofocus>{{ old('body', $comment->body ?? '') }}</textarea>

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