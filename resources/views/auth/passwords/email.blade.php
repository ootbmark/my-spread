@extends('layouts.app')
@section('content')

    <div class="my-container pt-5">
        <h1 class="title-h2 mb-4 text-center">RESET PASSWORD</h1>

        <div class="login-container bg-white">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form class="mt-4 login-form" action="{{route('password.email')}}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="email" class="col-md-3 col-form-label text-uppercase">EMAIL ADDRESS<span class="text-red ml-1">*</span></label>
                    <div class="col-md-9 col-lg-7">
                        <input type="text" name="email" class="form-control" id="email" value="{{old('email')}}" placeholder="Email address">
                        @error('email')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-9 col-lg-7 offset-md-3 pl-lg-2 pl-0 pr-0 form-group">
                    <button type="submit" class="btn my-btn text-uppercase">{{ __('Send Password Reset Link') }}</button>
                </div>

            </form>
        </div>
    </div>

@endsection


