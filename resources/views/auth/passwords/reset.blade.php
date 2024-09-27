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

            <form class="mt-4 login-form" action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{request()->get('email')}}">
                <input type="hidden" name="token" value="{{$token}}">
                <div class="form-group row">
                    <label for="password" class="col-md-3 col-form-label text-uppercase">PASSWORD<span class="text-red ml-1">*</span></label>
                    <div class="col-md-9 col-lg-7">
                        <input type="password" name="password" class="form-control" id="password"  placeholder="Password">
                        @error('password')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password_confirmation" class="col-md-3 col-form-label text-uppercase">PASSWORD CONFIRMATION<span class="text-red ml-1">*</span></label>
                    <div class="col-md-9 col-lg-7">
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"  placeholder="Password confirmation">
                        @error('email')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-9 col-lg-7 offset-md-3 pl-lg-2 pl-0 pr-0 form-group">
                    <button type="submit" class="btn my-btn text-uppercase">Reset password</button>
                </div>

            </form>
        </div>
    </div>

@endsection

