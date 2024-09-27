@extends('layouts.app')

@section('content')
    <div class="my-container pt-4">
        <form class="mt-4 login-form" method="POST" action="{{ route('register') }}" enctype="multipart/form-data"
            id="register_form">
            @csrf
            <h1 class="title-h2 mb-4 text-center">REGISTER WITH MY-SPREAD</h1>

            <div class="login-container bg-white">
                <h3 class="title-h3">ACCOUNT DETAILS</h3>

                <ul class="mt-3 font-16 pl-4">
                    <li>If you are an independent consultant, then please select SPREAD Associates (Guests) as your
                        organisation.</li>
                    <li>If you are a student, then please select Students as your organisation.</li>
                    <li>If your organisation is not in the below list, please choose the first option "NOT IN THE LIST" and
                        provide the details of your organisation below.</li>
                    <li>All the fields marked with an *(asterisk) are needed to be filled to complete your registration.
                    </li>
                    <li class="text-red">Please your proper name or a similar version; Use of pseudonyms or improper names
                        look like spam and will trigger additional security checks (if no company email is present).</li>
                </ul>

                <div class="form-group row">
                    <label for="organisation_id" class="col-md-3 col-form-label text-uppercase">ORGANISATION<span
                            class="text-red ml-1">*</span></label>
                    <div class="col-md-9 col-lg-7">
                        <select class="validatable" name="organisation_id" id="organisation_id">
                            <option value="">Choose your Organisation</option>
                            <option value="new" @if (old('organisation_id') == 'new') selected @endif>NOT IN THE LIST
                            </option>
                            @foreach ($organisations as $organisation)
                                <option value="{{ $organisation->id }}" data-type="{{ $organisation->type }}"
                                    @if (old('organisation_id') == $organisation->id) selected @endif>{{ $organisation->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row university_div d-none">
                    <label for="university_id" class="col-md-3 col-form-label text-uppercase">UNIVERSITY<span
                            class="text-red ml-1">*</span></label>
                    <div class="col-md-9 col-lg-7">
                        <select class="validatable" name="university_id" id="university_id">
                            <option value="">Choose your University</option>
                            <option value="new" @if (old('university_id') == 'new') selected @endif>NOT IN THE LIST
                            </option>
                            @foreach ($universities as $university)
                                <option value="{{ $university->id }}" @if (old('university_id') == $university->id) selected @endif>
                                    {{ $university->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row new_university_div d-none">
                    <label for="university" class="col-md-3 col-form-label text-uppercase">UNIVERSITY NAME<span
                            class="text-red ml-1">*</span></label>
                    <div class="col-md-9 col-lg-7">
                        <input type="text" class="form-control validatable" id="university" name="university"
                            value="{{ old('university') }}" placeholder="University name">
                    </div>
                </div>

                <div class="form-group row new_organisation_div @if (old('organisation_id') != 'new') d-none @endif">
                    <label for="organisation_name" class="col-md-3 col-form-label text-uppercase">ORGANISATION NAME<span
                            class="text-red ml-1">*</span></label>
                    <div class="col-md-9 col-lg-7">
                        <input type="text" class="form-control validatable" id="organisation_name"
                            name="organisation_name" value="{{ old('organisation_name') }}" placeholder="Organisation name">
                    </div>
                </div>

                <div class="form-group row new_organisation_div @if (old('organisation_id') != 'new') d-none @endif">
                    <label for="organisation_email" class="col-md-3 col-form-label text-uppercase">ORGANISATION
                        EMAIL</label>
                    <div class="col-md-9 col-lg-7">
                        <input type="email" class="form-control validatable" id="organisation_email"
                            name="organisation_email" value="{{ old('organisation_email') }}"
                            placeholder="Organisation email">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="username" class="col-md-3 col-form-label text-uppercase">USERNAME<span
                            class="text-red ml-1">*</span></label>
                    <div class="col-md-9 col-lg-7">
                        <input type="text" class="form-control validatable" id="username" name="username"
                            value="{{ old('username') }}" placeholder="Username">
                        <small class="form-text text-muted">(3 to 20 chars, A to Z, a to z, 0 to 9, period, and underscores
                            only)
                            <span class="text-red">Please DO NOT use your email address here</span>
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-3 col-form-label text-uppercase">PASSWORD<span
                            class="text-red ml-1">*</span></label>
                    <div class="col-md-9 col-lg-7">
                        <div class="input-error-wrapper">
                            <input type="password" class="form-control pr-5 validatable" name="password" id="password"
                                placeholder="Password">
                            <small class="form-text text-muted">(Password is case sensitive and least 8 characters are
                                required)</small>
                        </div>
                        <span toggle="#password" class="field-icon toggle-password">
                            <img src="/img/eye.svg" alt="eye" width="20" class="d-none">
                            <img src="/img/invisible.svg" alt="eye" width="20" class="d-block">
                        </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password_confirmation" class="col-md-3 col-form-label text-uppercase">CONFIRM
                        PASSWORD<span class="text-red ml-1">*</span></label>
                    <div class="col-md-9 col-lg-7">
                        <div class="input-error-wrapper">
                            <input type="password" class="form-control pr-5 validatable" name="password_confirmation"
                                id="password_confirmation" placeholder="Confirm password">
                        </div>
                        <span toggle="#password_confirmation" class="field-icon toggle-password">
                            <img src="/img/eye.svg" alt="eye" width="20" class="d-none">
                            <img src="/img/invisible.svg" alt="eye" width="20" class="d-block">
                        </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-3 col-form-label text-uppercase">WORK EMAIL<span
                            class="text-red ml-1">*</span></label>
                    <div class="col-md-9 col-lg-7">
                        <input type="email" class="form-control validatable" name="email" id="email"
                            value="{{ old('email') }}" placeholder="Work email">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email_confirmation" class="col-md-3 col-form-label text-uppercase">RETYPE EMAIL<span
                            class="text-red ml-1">*</span></label>
                    <div class="col-md-9 col-lg-7">
                        <input type="email" class="form-control validatable" name="email_confirmation"
                            id="email_confirmation" value="{{ old('email_confirmation') }}" placeholder="Retype email">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="personal_email" class="col-md-3 col-form-label text-uppercase">PERSONAL EMAIL</label>
                    <div class="col-md-9 col-lg-7">
                        <input type="email" class="form-control validatable" name="personal_email" id="personal_email"
                            value="{{ old('personal_email') }}" placeholder="Personal email">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="reg_source" class="col-md-3 col-form-label text-uppercase">WHERE DID YOU HEAR ABOUT
                        SPREAD<span class="text-red ml-1">*</span></label>
                    <div class="col-md-9 col-lg-7">
                        <select name="reg_source" id="reg_source" class="form-control validatable">
                            <option value="" {{ old('reg_source') == '' ? 'selected' : '' }}>Choose one</option>
                            <option disabled="disabled">-------------------------</option>
                            <option value="Internet search"
                                {{ old('reg_source') == 'Internet search' ? 'selected' : '' }}>Internet search</option>
                            <option value="Friends" {{ old('reg_source') == 'Friends' ? 'selected' : '' }}>Friends
                            </option>
                            <option value="Colleagues" {{ old('reg_source') == 'Colleagues' ? 'selected' : '' }}>
                                Colleagues</option>
                            <option value="Other discussion forums"
                                {{ old('reg_source') == 'Other discussion forums' ? 'selected' : '' }}>Other discussion
                                forums</option>
                            <option value="Others" {{ old('reg_source') == 'Others' ? 'selected' : '' }}>Others</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row other_reg_source_div @if (old('reg_source') != 'Others') d-none @endif">
                    <label for="other_reg_source" class="col-md-3 col-form-label text-uppercase">ANY OTHER DETAILS/INPUTS?
                        PLEASE SPECIFY HERE<span class="text-red ml-1">*</span></label>
                    <div class="col-md-9 col-lg-7">
                        <input class="form-control validatable" name="other_reg_source" id="other_reg_source"
                            type="text" value="{{ old('other_reg_source') }}" placeholder="Please specify here">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="linkedin_url" class="col-md-3 col-form-label text-uppercase">LINKEDIN PROFILE URL</label>
                    <div class="col-md-9 col-lg-7">
                        <input type="text" class="form-control validatable" id="linkedin_url" name="linkedin_url"
                            value="{{ old('linkedin_url') }}" placeholder="LINKEDIN PROFILE URL">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="why_spread" class="col-md-3 col-form-label text-uppercase">WHAT DO YOU HOPE TO GET FROM
                        SPREAD<span class="text-red ml-1">*</span></label>
                    <div class="col-md-9 col-lg-7">
                        <textarea class="form-control validatable" name="why_spread" id="why_spread" rows="5">{{ old('why_spread') }}</textarea>
                        <small class="form-text text-muted">(Personal growth Networking Knowledge sharing , Job
                            opportunities etc.)</small>
                    </div>
                </div>
            </div>

            <div class="login-container bg-white">
                <h3 class="title-h3 mb-4">PERSONAL DETAILS</h3>

                <div class="form-group row">
                    <label for="first_name" class="col-md-3 col-form-label text-uppercase">FIRST NAME<span
                            class="text-red ml-1">*</span></label>
                    <div class="col-md-9 col-lg-7">
                        <input type="text" class="form-control validatable" id="first_name" name="first_name"
                            value="{{ old('first_name') }}" placeholder="First name">
                        <small class="form-text text-muted">(This will be your preferred name in all
                            communications)</small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="last_name" class="col-md-3 col-form-label text-uppercase">LAST NAME<span
                            class="text-red ml-1">*</span></label>
                    <div class="col-md-9 col-lg-7">
                        <input type="text" class="form-control validatable" id="last_name" name="last_name"
                            value="{{ old('last_name') }}" placeholder="Last name">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="address" class="col-md-3 col-form-label text-uppercase">ADDRESS</label>
                    <div class="col-md-9 col-lg-7">
                        <textarea class="form-control validatable" name="address" id="address" rows="5">{{ old('address') }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="location" class="col-md-3 col-form-label text-uppercase">CURRENT LOCATION<span
                            class="text-red ml-1">*</span></label>
                    <div class="col-md-9 col-lg-7">
                        <input type="text" class="form-control validatable" id="location" name="location"
                            value="{{ old('location') }}" placeholder="Current location">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="job_title" class="col-md-3 col-form-label text-uppercase">JOB TITLE<span
                            class="text-red ml-1">*</span></label>
                    <div class="col-md-9 col-lg-7">
                        <input type="text" class="form-control validatable" id="job_title" name="job_title"
                            value="{{ old('job_title') }}" placeholder="Job title">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="image" class="col-md-3 col-form-label text-uppercase">PROFILE IMAGE</label>
                    <div class="col-md-9 col-lg-7">
                        <input type="file" id="image" name="image" class="demo custom-file-img validatable"
                            data-jpreview-container="#demo-1-container">
                        <small>(jpg, gif, png files only. File size should not exceed 1MB)</small>
                        <div id="demo-1-container" class="jpreview-container"></div>
                    </div>
                </div>

                <div class="form-group pl-md-2">
                    <div class="custom-control custom-checkbox col-md-9 offset-md-3">
                        <input type="checkbox" class="custom-control-input" checked id="is_subscribed" value="1"
                            name="is_subscribed">
                        <label class="custom-control-label" for="is_subscribed">Please uncheck this box if you do not wish
                            to receive marketing newsletters from My-Spread</label>
                    </div>
                </div>
                <div class="col-md-9 col-lg-7 offset-md-3 pl-lg-2 pl-0 pr-0 form-group d-flex">
                    <div>
                        {!! NoCaptcha::display() !!}
                    </div>
                    <br>

                </div>
                <div class="col-md-9 col-lg-7 offset-md-3 pl-lg-2 pl-0 pr-0 form-group">
                    <button type="submit" class="btn my-btn text-uppercase"
                        data-sitekey="6LfwpS0qAAAAABWO07Lg_gm9HT_fOaWEys0gVXTd" data-callback='onSubmit'
                        data-action='submit'>
                        Submit
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>

            </div>
        </form>
        {!! NoCaptcha::renderJs() !!}
    </div>

    <div class="modal fade" id="verifyModal" tabindex="-1" role="dialog" aria-labelledby="verifyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                @include('auth.components._verify_content')
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    {{--  <script src="https://www.google.com/recaptcha/api.js"></script> --}}
    <script>
        $('#register_form').on('submit', function(e) {
            e.preventDefault();
            ajaxSubmit();
        });

        function clearFormErrors(parent) {
            parent.find('.text-danger').remove();
        }

        function ajaxSubmit() {
            const form = $('#register_form');
            const registerBtn = form.find('button[type=submit]');
            const spinner = registerBtn.find('.spinner-border');
            registerBtn.attr('disabled', true);
            spinner.removeClass('d-none');
            clearFormErrors(form);

            const data = new FormData(form[0]);

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'ACCEPT': 'application/json'
                },
                data: data,
                processData: false,
                contentType: false,
                success: () => {
                    spinner.addClass('d-none');
                    $('#verifyModal').modal('show');
                    $('#verifyModal').on('hidden.bs.modal', function(e) {
                        window.location.href = '{{ route('home', ['registered']) }}';
                    });
                },
                error: err => {
                    console.log(err)
                    if (err) {
                        if (err?.responseJSON) {
                            if (err?.responseJSON.errors) {
                                const errors = err.responseJSON.errors;

                                for (let key in errors) {
                                    form.find(`.validatable[name=${key}]`).parent().append(`
                                <span class="text-danger" role="alert">
                                    <strong> ${errors[key][0]}</strong>
                                </span>
                            `)
                                }
                            }
                        }

                    }

                    spinner.addClass('d-none');
                    registerBtn.attr('disabled', false);
                }
            })
        }

        function onSubmit(token) {
            ajaxSubmit();
            // document.getElementById("register_form").submit();
        }

        $('#reg_source').change(function() {
            if ($(this).find(':selected').val() === 'Others') {
                $('.other_reg_source_div').removeClass('d-none');
            } else {
                $('.other_reg_source_div').addClass('d-none');
            }
        })

        $('#organisation_id').select2();
        $('#university_id').select2();

        $('#organisation_id').change(function() {
            checkOrgSelected($(this));
        })

        function checkOrgSelected(el) {
            if (el.find(':selected').val() === 'new') {
                $('.new_organisation_div').removeClass('d-none');
            } else {
                $('.new_organisation_div').addClass('d-none');
            }

            if (el.find(':selected').data('type') === 'student') {
                $('.university_div').removeClass('d-none');
            } else {
                $('.new_university_div').addClass('d-none');
                $('.university_div').addClass('d-none');
                $('#university').val('');
                $('#university_id').val('');
                $('#university_id').trigger('change');
            }
        }

        $('#university_id').change(function() {
            checkUniversitySelected($(this));
        })


        function checkUniversitySelected(el) {
            if (el.find(':selected').val() === 'new') {
                $('.new_university_div').removeClass('d-none');
            } else {
                $('.new_university_div').addClass('d-none');
            }
        }

        checkOrgSelected($('#organisation_id'));

        checkUniversitySelected($('#university_id'));
    </script>
@endsection
