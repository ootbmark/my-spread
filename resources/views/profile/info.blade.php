@extends('layouts.app')
@section('add-css')
    <link href="/css/crop.css" rel="stylesheet">
    <link href="{{ mix('css/profile.css') }}" rel="stylesheet">
@endsection
@section('content')

    @include('profile._sidebar')

    <div class="profile-content">
      @include('profile._navbar')

        <div class="tab-content" id="pills-tabContent">
            <form action="{{route('profile.update')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="first_name">First name<span class="text-red ml-1">*</span></label>
                            <input type="text" class="form-control" id="first_name" placeholder="First name" name="first_name" value="{{auth()->user()->first_name}}">
                            @error('first_name')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last name<span class="text-red ml-1">*</span></label>
                            <input type="text" class="form-control" id="last_name" placeholder="Last Name" name="last_name" value="{{auth()->user()->last_name}}">
                            @error('password')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Work email<span class="text-red ml-1">*</span></label>
                            <input type="email" class="form-control" id="email" placeholder="Work email" name="email" value="{{auth()->user()->email}}">
                            @error('email')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="personal_email">Personal email</label>
                            <input type="email" class="form-control" id="personal_email" placeholder="Personal email" name="personal_email" value="{{auth()->user()->personal_email}}">
                            @error('personal_email')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="linkedin_url">Linkedin Profile URL</label>
                            <input type="url" class="form-control" id="linkedin_url" placeholder="Linkedin Profile URL" name="linkedin_url" value="{{auth()->user()->linkedin_url}}">
                            @error('linkedin_url')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group w-100">
                            <label for="organisation_id">Organisation<span class="text-red ml-1">*</span></label>
                            <select name="organisation_id" id="organisation_id" class="form-control">
                                @foreach($organisations as $organisation)
                                    <option value="{{$organisation->id}}"  data-type="{{$organisation->type}}"  @if(auth()->user()->organisation_id == $organisation->id) selected @endif>{{$organisation->name}}</option>
                                @endforeach
                            </select>
                            @error('organisation_id')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group university_div d-none">
                            <label for="university_id">University<span class="text-red ml-1">*</span></label>
                            <select name="university_id" id="university_id" class="form-control">
                                <option value="">Select University</option>
                                @foreach($universities as $university)
                                    <option value="{{$university->id}}" @if(auth()->user()->university_id == $university->id) selected @endif>{{$university->name}}</option>
                                @endforeach
                            </select>
                            @error('university_id')
                                    <span class="text-danger" role="alert">
                                         <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="location">Location<span class="text-red ml-1">*</span></label>
                            <input type="text" class="form-control" id="location" placeholder="Location" name="location" value="{{auth()->user()->location}}">
                            @error('location')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="job_title">Job title<span class="text-red ml-1">*</span></label>
                            <input type="text" class="form-control" id="job_title" placeholder="Job title" name="job_title" value="{{auth()->user()->job_title}}">
                            @error('job_title')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" id="address" class="form-control">{{auth()->user()->address}}</textarea>
                            @error('address')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="text-right pt-2">
                    <button type="submit" class="btn my-btn text-uppercase">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
 @include('profile._avatar_scripts')
 <script>
     $('#organisation_id').select2();

     $('#organisation_id').change(function (){
         checkOrgSelected($(this));
     })

     function checkOrgSelected(el)
     {
         if(el.find(':selected').data('type') === 'student') {
             $('.university_div').removeClass('d-none');
         }else{
             $('.university_div').addClass('d-none');
             $('#university_id').val('');
         }
     }

     checkOrgSelected( $('#organisation_id'));
 </script>
@endsection

