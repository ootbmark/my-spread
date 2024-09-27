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
                <h6 class="nav-link active">Invite friends</h6>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active">
                <h6 class="text-center">If you would like to invite a friend to use our site please fill out the details below.</h6>

                <form class="mt-4 login-form" id="invite_form" action="{{route('profile.invite.submit')}}" method="POST">
                    @csrf
                    <div class="emails-div">
                        <div class="form-group">
                            <input type="text" name="emails[]" class="form-control" placeholder="Friend email *" >
                        </div>
                    </div>
                    @error('emails.*')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="form-group w-100 mt-3 mb-5">
                        <button type="button" id="add_email" class="btn my-btn text-uppercase w-100 btn-white">
                            Add recipient
                        </button>
                    </div>
                    <div class="form-group w-100">
                        <textarea class="form-control" name="message" rows="3" placeholder="(Optional message)" aria-label="Optional message"></textarea>
                    </div>
                    <div class="form-group w-100 text-right mt-4">
                        <button type="submit" id="invite_submit_button" class="btn my-btn text-uppercase">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('profile._avatar_scripts')
    <script>
        $('#add_email').click(function (){
            $('.emails-div').append(
                '  <div class="form-group">\n' +
                '                            <input type="text" name="emails[]" class="form-control" placeholder="Friend email *" >\n' +
                '                        </div>'
            )
            if($( ".emails-div .form-group" ).length  === 5){
                $('#add_email').remove();
            }
        })

        $('#invite_submit_button').on('click', function() {
            $(this).attr('disabled', true);

            $('#invite_form').submit();
        });
    </script>
@endsection


