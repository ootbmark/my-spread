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
            <form action="{{route('dashboard.universities.store')}}" method="POST" enctype="multipart/form-data">
                @csrf

                @include('dashboard.universities._form')

                <div class="text-right pt-2">
                    <button type="submit" class="btn my-btn text-uppercase">Create</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    @include('profile._avatar_scripts')
@endsection

