@extends('layouts.app')
@section('add-css')
    <link href="/css/crop.css" rel="stylesheet">
    <link href="{{ mix('css/profile.css') }}" rel="stylesheet">
@endsection
@section('content')

    @include('profile._sidebar')

    <div class="profile-content">
        <ul class="nav nav-pills mb-3 profile-nav-tab" role="tablist">
            <li class="nav-item">
                <h6 class="nav-link active">Update password</h6>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active">
                <form action="{{route('profile.password.update')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="current_password">Current password</label>
                        <input type="password" class="form-control" id="current_password" placeholder="Current password" name="current_password">
                        @error('current_password')
                        <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                        @error('password')
                        <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Password confirmation</label>
                        <input type="password" class="form-control" id="password_confirmation" placeholder="Password confirmation" name="password_confirmation">
                    </div>
                    <div class="text-right pt-4">
                        <button type="submit" class="btn my-btn text-uppercase">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
 @include('profile._avatar_scripts')
@endsection

