@extends('layouts.app')
@section('content')

    <div class="my-container pt-5">
            <h1 class="title-h2 mb-4 text-center">CONTACT</h1>

            <div class="login-container bg-white">
                <h3 class="title-h3">CONTACT DETAILS</h3>

                <ul class="mt-3 font-16 pl-4">
                    <li>Phone: +44 7748 678 176</li>
                    <li>Skype : living_the_limit</li>
                    <li><a href="https://www.rp-squared.com">www.rp-squared.com</a></li>
                    <li>E-mail: <a href="mailto:dave@rp-squared.com">dave@rp-squared.com</a></li>
                </ul>
            </div>
            <div class="login-container bg-white">
                @auth
                <form action="{{route('contact.submit')}}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="username" class="col-md-3 col-form-label text-uppercase">USERNAME<span class="text-red ml-1">*</span></label>
                        <div class="col-md-9 col-lg-7">
                            <input type="text" class="form-control" id="username" name="username" value="{{old('username') ?: Auth::user()->username}}" placeholder="Username">
                            @error('username')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-3 col-form-label text-uppercase">FULL NAME<span class="text-red ml-1">*</span></label>
                        <div class="col-md-9 col-lg-7">
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name')  ?: Auth::user()->name}}" placeholder="Full name">
                            @error('name')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-3 col-form-label text-uppercase">EMAIL<span class="text-red ml-1">*</span></label>
                        <div class="col-md-9 col-lg-7">
                            <input type="email" class="form-control" name="email" id="email" value="{{old('email') ?: Auth::user()->email}}" placeholder="Email">
                            @error('email')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="subject" class="col-md-3 col-form-label text-uppercase">SUBJECT<span class="text-red ml-1">*</span></label>
                        <div class="col-md-9 col-lg-7">
                            <input type="text" class="form-control" id="subject" name="subject" value="{{old('subject')}}" placeholder="Subject">
                            @error('subject')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="message" class="col-md-3 col-form-label text-uppercase">MESSAGE<span class="text-red ml-1">*</span></label>
                        <div class="col-md-9 col-lg-7">
                            <textarea class="form-control" name="message" id="message" rows="5">{{old('message')}}</textarea>
                            @error('message')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-9 col-lg-7 offset-md-3 pl-lg-2 pl-0 pr-0 form-group">
                        <button type="submit" class="btn my-btn text-uppercase">Submit</button>
                    </div>
                </form>
                @else
                    <p>You need to log in to use the contact form</p>
                    <p>Alternatively, you can send a message though one of the other contact methods shown on this page.</p>
                @endif
            </div>
    </div>

@endsection

