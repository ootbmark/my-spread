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
            <form action="{{route('dashboard.groups.store')}}" id="submit_group_form" method="POST">
                @csrf

                @include('dashboard.groups._form')

                <div class="text-right pt-2">
                    <button type="submit" id="submit_group_button" class="btn my-btn text-uppercase">Create</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    @include('profile._avatar_scripts')
    <script>
        $('#submit_group_button').on('click', function() {
            $(this).attr('disabled', true);

            $('#submit_group_form').submit();
        });
    </script>
@endsection

