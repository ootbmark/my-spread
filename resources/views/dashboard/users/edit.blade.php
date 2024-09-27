@extends('layouts.app')
@section('add-css')
    <link href="/css/crop.css" rel="stylesheet">
    <link href="{{ mix('css/profile.css') }}" rel="stylesheet">
@endsection
@section('content')

    @include('profile._sidebar')

    <div class="profile-content">
       @include('dashboard._navbar')

        <div class="discussions-container ml-0 mt-4">
            <form action="{{route('dashboard.users.update', $user->id)}}" method="POST">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="username">Username<span class="text-red ml-1">*</span></label>
                            <input type="text" class="form-control" id="username" disabled value="{{$user->username}}">
                        </div>
                        <div class="form-group">
                            <label for="first_name">First name<span class="text-red ml-1">*</span></label>
                            <input type="text" class="form-control" id="first_name" placeholder="First name" name="first_name" value="{{$user->first_name}}">
                            @error('first_name')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last name<span class="text-red ml-1">*</span></label>
                            <input type="text" class="form-control" id="last_name" placeholder="Last Name" name="last_name" value="{{$user->last_name}}">
                            @error('last_name')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Work email<span class="text-red ml-1">*</span></label>
                            <input type="email" class="form-control" id="email" placeholder="Work email" name="email" value="{{$user->email}}">
                            @error('email')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="personal_email">Personal email</label>
                            <input type="email" class="form-control" id="personal_email" placeholder="Personal email" name="personal_email" value="{{$user->personal_email}}">
                            @error('personal_email')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="linkedin_url">Linkedin Profile URL</label>
                            <input type="url" class="form-control" id="linkedin_url" placeholder="Linkedin Profile URL" name="linkedin_url" value="{{$user->linkedin_url}}">
                            @error('linkedin_url')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="allow_workshop">Allowed Workshops</label>
                            <select class="form-control" id="allowed_workshops" name="allowed_workshops[]" multiple>
                                @foreach($quizes as $quiz)
                                    <option value="{{$quiz->id}}" @if(in_array($quiz->id, $selected_quizes)) selected @endif>{{$quiz->title}}</option>
                                @endforeach
                            </select>
                            @error('allowed_workshops')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="allowed_companies">Allocated Companies</label>
                            <select class="form-control" id="allowed_companies" name="allowed_companies[]" multiple>
                                @foreach($companies as $company)
                                    <option value="{{$company->id}}" @if(in_array($company->id, $selected_companies)) selected @endif>{{$company->name}}</option>
                                @endforeach
                            </select>
                            @error('allowed_companies')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="organisation_id">Organisation<span class="text-red ml-1">*</span></label>
                            <select name="organisation_id" id="organisation_id" class="form-control">
                                @if($user->organisation && $user->organisation->status !== \App\Models\Organisation::ACTIVE)
                                <option value="{{$user->organisation_id}}">{{$user->organisation->name}} ({{ucfirst($user->organisation->status)}})</option>
                                @endif
                                @foreach($organisations as $organisation)
                                    <option value="{{$organisation->id}}" @if($user->organisation_id == $organisation->id) selected @endif data-type="{{$organisation->type}}">{{$organisation->name}}</option>
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
                                @if($user->university && $user->university->status !== \App\Models\University::ACTIVE)
                                    <option value="{{$user->university_id}}">{{$user->university->name}} ({{ucfirst($user->university->status)}})</option>
                                @endif
                                @foreach($universities as $university)
                                    <option value="{{$university->id}}" @if($user->university_id == $university->id) selected @endif>{{$university->name}}</option>
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
                            <input type="text" class="form-control" id="location" placeholder="Location" name="location" value="{{$user->location}}">
                            @error('location')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="job_title">Job title<span class="text-red ml-1">*</span></label>
                            <input type="text" class="form-control" id="job_title" placeholder="Job title" name="job_title" value="{{$user->job_title}}">
                            @error('job_title')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" id="address" class="form-control" rows="3">{{$user->address}}</textarea>
                            @error('address')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="reg_source">Where did you hear about spread<span class="text-red ml-1">*</span></label>
                                <select name="reg_source" id="reg_source" class="form-control">
                                    <option value="Internet search" {{ old('reg_source', $user->reg_source) == 'Internet search' ? 'selected' : '' }}>Internet search</option>
                                    <option value="Friends" {{ old('reg_source', $user->reg_source) == 'Friends' ? 'selected' : '' }}>Friends</option>
                                    <option value="Colleagues" {{ old('reg_source', $user->reg_source) == 'Colleagues' ? 'selected' : '' }} >Colleagues</option>
                                    <option value="Other discussion forums" {{ old('reg_source', $user->reg_source) == 'Other discussion forums' ? 'selected' : '' }} >Other discussion forums</option>
                                    <option value="Others" {{ old('reg_source', $user->reg_source) == 'Others' ? 'selected' : '' }}>Others</option>
                                </select>
                            @error('reg_source')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group other_reg_source_div @if(old('reg_source', $user->reg_source) != 'Others') d-none @endif">
                            <label for="other_reg_source">Any other details/inputs? Please specify here<span class="text-red ml-1">*</span></label>
                                <input class="form-control" name="other_reg_source"  id="other_reg_source" type="text" value="{{old('other_reg_source', $user->other_reg_source)}}" placeholder="Please specify here">
                            @error('other_reg_source')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="why_spread">What do you hope to get from spread<span class="text-red ml-1">*</span></label>
                                <textarea class="form-control" name="why_spread" id="why_spread" rows="3">{{old('why_spread', $user->why_spread)}}</textarea>
                            @error('why_spread')
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

        <div class="discussions-container ml-0 mt-4">
            <form action="{{route('dashboard.users.status', $user->id)}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="status">User status<span class="text-red ml-1">*</span></label>
                            <select name="status" id="status" class="form-control">
                                <option value="" disabled selected>{{ucfirst($user->status)}}</option>
                                <option value="" disabled>-------------</option>
                                @if($user->status != 'active')
                                <option value="active">Active</option>
                                @endif
                                @if($user->status != 'inactive')
                                <option value="inactive">Inactive</option>
                                @endif
                                @if($user->status != 'deleted')
                                <option value="deleted">Deleted</option>
                                @endif
                            </select>
                            @error('status')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group @if(!old('status')) d-none @endif" id="message-div">
                            <label for="message">Message to user</label>
                            <textarea name="message" id="message" class="form-control"></textarea>
                            @error('message')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                    </div>
                </div>

                <div class="text-right pt-2">
                    <button type="submit" class="btn my-btn text-uppercase">Update</button>
                </div>
            </form>
        </div>

        <div class="discussions-container ml-0 mt-4">
            <form action="{{route('dashboard.users.password', $user->id)}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="password">Password<span class="text-red ml-1">*</span></label>
                            <input type="text" class="form-control" id="password" placeholder="Password" name="password">
                            @error('password')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                                <label for="password_confirmation">Password again<span class="text-red ml-1">*</span></label>
                                <input type="text" class="form-control" id="password_confirmation" placeholder="Password again" name="password_confirmation">
                                @error('password_confirmation')
                                <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                    </div>

                    </div>

                <div class="text-right pt-2">
                    <button type="submit" class="btn my-btn text-uppercase">Update</button>
                </div>
            </form>
        </div>

        @if(!$user->hasVerifiedEmail())
            <div class="discussions-container ml-0 mt-4">
                <form action="{{route('dashboard.users.verify', $user->id)}}" method="POST">
                    @csrf
                    <div class="pt-2 d-flex justify-content-between">
                        <div>User is not verified</div>
                        <button type="submit" class="btn my-btn text-uppercase">Verify</button>
                    </div>
                </form>
            </div>
        @endif
    </div>

@endsection

@section('scripts')
    @include('profile._avatar_scripts')
    <script src="/ckeditor/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create( document.querySelector( '#message' ), {
                toolbar: {
                    removeItems: ['uploadImage', 'MathType', 'ChemType']
                },
            } )
            .catch( error => {
                console.error( error );
            } );

        $('#organisation_id').select2();
        $('#allowed_workshops').select2();
        $('#allowed_companies').select2();

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

        $('#status').change(function (){
            $('#message-div').removeClass('d-none');
        });

        $('#reg_source').change(function (){
            if($(this).find(':selected').val() === 'Others') {
                $('.other_reg_source_div').removeClass('d-none');
            }else{
                $('.other_reg_source_div').addClass('d-none');
            }
        })

        checkOrgSelected( $('#organisation_id'));
    </script>
@endsection

