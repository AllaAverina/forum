@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-3">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="mb-3">
                @include('profile.partials.update-password-form')
            </div>

            <div class="mb-3">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection