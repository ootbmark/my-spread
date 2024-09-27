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
                <h6 class="nav-link active">Notifications</h6>
            </li>
        </ul>
        <div class="profile-container">
            <form action="{{route('profile.notifications.update')}}" method="POST">
                @csrf
                <div class="mt-4 mb-4">
                    <div class="d-flex flex-wrap max-w-350 mb-4">
                        <h5 class="w-100 font-medium">Subscription status</h5>
                        <div class="custom-control custom-checkbox w-50 custom-checkbox-2">
                            <input type="radio" class="custom-control-input" name="is_subscribed" value="1" @if(auth()->user()->is_subscribed) checked @endif id="is_subscribed_yes">
                            <label class="custom-control-label" for="is_subscribed_yes">Subscribed</label>
                        </div>
                        <div class="custom-control custom-checkbox w-50 custom-checkbox-2">
                            <input type="radio" class="custom-control-input" name="is_subscribed" @if(!auth()->user()->is_subscribed) checked @endif value="0" id="is_subscribed_no">
                            <label class="custom-control-label" for="is_subscribed_no">Unsubscribed</label>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="mt-4 mb-4">
                    <div class="d-flex flex-wrap max-w-350 mb-4">
                        <h5 class="w-100 font-medium">Choose alerts</h5>
                        <div class="custom-control custom-checkbox w-50 custom-checkbox-2">
                            <input type="checkbox" class="custom-control-input" value="1" @if(auth()->user()->alert == 1 || auth()->user()->alert == 2) checked @endif name="alert[]" id="alert_daily">
                            <label class="custom-control-label" for="alert_daily">Daily Alerts</label>
                        </div>
                        <div class="custom-control custom-checkbox w-50 custom-checkbox-2">
                            <input type="checkbox" class="custom-control-input" value="0" @if(!auth()->user()->alert === 0 || auth()->user()->alert == 2) checked @endif name="alert[]" id="alert_weekly">
                            <label class="custom-control-label" for="alert_weekly">Weekly Alerts</label>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap max-w-350">
                        <h5 class="w-100 font-medium">Enable students alert</h5>
                        <div class="custom-control custom-checkbox w-50 custom-checkbox-2">
                            <input type="radio" class="custom-control-input" value="1" @if(auth()->user()->students_alert) checked @endif name="students_alert" id="students_alert_yes">
                            <label class="custom-control-label" for="students_alert_yes">Enable</label>
                        </div>
                        <div class="custom-control custom-checkbox w-50 custom-checkbox-2">
                            <input type="radio" class="custom-control-input" value="0" @if(!auth()->user()->students_alert) checked @endif name="students_alert" id="students_alert_no">
                            <label class="custom-control-label" for="students_alert_no">Disable</label>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="mt-3 mb-4">
                    <div class="d-flex flex-wrap max-w-350 mb-4">
                        <h5 class="w-100 font-medium">Alert e-mail</h5>
                        <div class="custom-control custom-checkbox w-50 custom-checkbox-2">
                            <input type="checkbox" class="custom-control-input" value="0" @if(!auth()->user()->alert_to_personal || auth()->user()->alert_to_personal == 2) checked @endif name="alert_to_personal[]" id="alert_to_personal_no">
                            <label class="custom-control-label" for="alert_to_personal_no">Work e-mail</label>
                        </div>
                        <div class="custom-control custom-checkbox w-50 custom-checkbox-2">
                            <input type="checkbox" class="custom-control-input" value="1" @if(auth()->user()->alert_to_personal) checked @endif @if(!auth()->user()->personal_email) disabled @endif name="alert_to_personal[]" id="alert_to_personal_yes">
                            <label class="custom-control-label" for="alert_to_personal_yes">Personal E-mail</label>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap max-w-350">
                        <h5 class="w-100 font-medium">Contact e-mail</h5>
                        <div class="custom-control custom-checkbox w-50 custom-checkbox-2">
                            <input type="radio" class="custom-control-input" value="0" @if(!auth()->user()->contact_to_personal) checked @endif name="contact_to_personal" id="contact_to_personal_no">
                            <label class="custom-control-label" for="contact_to_personal_no">Work e-mail</label>
                        </div>
                        <div class="custom-control custom-checkbox w-50 custom-checkbox-2">
                            <input type="radio" class="custom-control-input" value="1" @if(auth()->user()->contact_to_personal) checked @endif @if(!auth()->user()->personal_email) disabled @endif  name="contact_to_personal" id="contact_to_personal_yes">
                            <label class="custom-control-label" for="contact_to_personal_yes">Personal E-mail</label>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="mt-4 mb-5">
                    <div class="d-flex flex-wrap max-w-700 mb-4">
                        <h5 class="w-100 font-medium">Choose alert groups</h5>
                        @foreach($groups as $group)
                            <div class="custom-control custom-checkbox w-50 custom-checkbox-2">
                                <input type="checkbox" class="custom-control-input" value="{{$group->id}}" @if(in_array($group->id, $selected_groups)) checked @endif name="groups[]" id="groups_{{$group->id}}">
                                <label class="custom-control-label" for="groups_{{$group->id}}">{{$group->name}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="text-right max-w-700 mb-4">
                    <button type="submit" class="btn my-btn text-uppercase">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
 @include('profile._avatar_scripts')
@endsection

