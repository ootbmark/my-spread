@extends('emails.layouts.app')
@section('content')
    <table class="container">
        <tr>
            <td>
                <table class="row">
                    <tr>
                        <td class="wrapper last">

                            <table class="twelve columns">
                                <tr>
                                    <td>
                                        <p>
                                            You are receiving this weekly alert according to your personal settings preference. Would you like to get alerts daily? Or change the categories of alerts?
                                        </p>
                                        <p>
                                            If so, go your profile settings: <a href="{{route('profile.index')}}">{{route('profile.index')}}</a>
                                        </p>
                                        <br>
                                        <h1>Hello {{$user->first_name}} ({{$user->username}}),</h1><br><br>

                                        @foreach($reply_groups as $group)
                                            @foreach($group['threads'] as $thread)

                                                <span style="font-size:16px; color:#110B42 !important; font-weight:bold">{{ count( $thread['replies'] ) }} new
																	@if ( count( $thread['replies'] ) > 1 )
                                                        responses
                                                    @else
                                                        response
                                                    @endif

																	received in group: <a href="{{route('groups.discussions', $group['group']->id)}}" style="text-decoration:underline; color:#110B42 !important;">{{$group['group']->name}}</a></span><br><br>

                                                <span style="font-size:18px; color:#110B42 !important; font-weight:bold"><strong>{{$thread['thread']->subject}}</strong></span><br /><br />

                                                <a class="user_link" href="{{route('users.show', $thread['thread']->user_id)}}">{{$thread['thread']->user->name}} ({{$thread['thread']->username}})</a> of {{$thread['thread']->user->organisation->name}}, from {{$thread['thread']->location}} on {{$thread['thread']->created_at}}<br><br>

                                                {!! $thread['thread']->body !!} <br>

                                                <a class="user_link" href="{{route('discussions.show', $thread['thread']->id)}}"><strong>Reply now</strong></a><br><br><br>

                                                <span style="font-size:18px; color:#110B42 !important; font-weight:bold">Responses</span><br /><br />

                                                @foreach($thread['replies'] as $reply)

                                                    <a class="user_link" href="{{route('users.show', $reply->user_id)}}">{{ $reply->user->name }} ({{ $reply->user->username }})</a> of {{ $reply->user->organisation->name}}, on {{ $reply->created_at }}<br><br>
                                                    {!! $reply->body !!} <br><br>

                                                    <div class="question"></div><br><br>

                                                @endforeach

                                            @endforeach

                                        @endforeach

                                    </td>

                                    <td class="expander"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class="disclaimer" style="background-color:#F5F5F5; padding:10px; font-size:9px;">
                    <p>my-spread.com is owned and operated by:</p>

                    <p>Relentless Pursuit of Perfection Ltd.</p>
                    <p>12/F, Henley Building,</p>
                    <p>Suite No. 8640,</p>
                    <p>5 Queen’s Road Central,</p>
                    <p>Hong Kong</p>

                    <p>HK Company Registration number: 1703157</p>
                    This email was sent to you because you’re a registered member of the SPREAD technical drilling forum. If you wish, you may change the frequency that you receive alerts, and also choose which topics you want to hear about <a class="user_link" href="{{ route('profile.index') }}">HERE</a>. Want out of the loop? Click <a href="{{ route('profile.notifications') }}" class="user_link">UNSUBSCRIBE</a>.
                    <br>{{ date('Y') }} © SPREAD. All Rights Reserved. </div>
            </td>
        </tr>
    </table>
@endsection
