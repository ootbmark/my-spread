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
            <form action="{{ route('dashboard.daily_alert') }}" method="POST" onsubmit="return confirm('Are You Sure?')">
                @csrf
                <button type="submit" class="btn my-btn mb-2">Send Daily Alert</button>
            </form>

            <form action="{{ route('dashboard.weekly_alert') }}" method="POST" onsubmit="return confirm('Are You Sure?')">
                @csrf
                <button type="submit" class="btn my-btn mb-2">Send Weekly Alert</button>
            </form>

        </div>
    </div>
@endsection

@section('scripts')
    @include('profile._avatar_scripts')
@endsection
