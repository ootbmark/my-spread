@extends('emails.layouts.app')
@section('content')
    <table class="container">
        <tr>
            <td>
                <table class="row">
                    <tr>
                        <td class="wrapper last">
                            <h1>Hello {{ $user->first_name }} ({{ $user->username }}),</h1><br><br>

                            <table class="twelve columns">
                                <tr>
                                    <td>
                                        @foreach( $groups as $group )

                                            <span style="font-size:16px; color:#110B42 !important; font-weight:bold">{{ count($group['threads']) }} new @if ( count($group['threads']) > 1 ) discussions @else discussion @endif received in group: <a href="{{route('groups.discussions', $group['group']->id)}}" style="text-decoration:underline; color:#110B42 !important;">{{$group['group']->name }}</a></span><br><br>

                                            @foreach( $group['threads'] as $thread )

                                                <span style="font-size:18px; color:#110B42 !important; font-weight:bold">{{ $thread->subject }}</span><br><br>

                                                <a class="user_link" href="{{route('users.show', $thread->user_id)}}">{{ $thread->user->name }} ({{ $thread->user->username }} )</a> of {{ $thread->user->organisation->name }}, on {{ $thread->created_at }}<br><br>

                                                {!! $thread->body !!}

                                                <br>

                                                <a class="user_link" href="{{route('discussions.show', $thread->id)}}"><strong>Reply now</strong></a><br><br>

                                                <div class="question"></div><br><br>
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
                    <p>Unit C, 17/F, United Centre</p>
                    <p>95 Queensway</p>
                    <p>Admiralty</p>
                    <p>Hong Kong</p>

                    <p>Company Registered 59385350 in Hong Kong</p>
                    This email was sent to you because you’re a registered member of the SPREAD technical drilling forum. If you wish, you may change the frequency that you receive alerts, and also choose which topics you want to hear about <a class="user_link" href="{{route('profile.index')}}">HERE</a>. Want out of the loop? Click <a href="{{route('profile.notifications')}}" class="user_link">UNSUBSCRIBE</a>.
                    <br>{{ date('Y') }} © SPREAD. All Rights Reserved. </div>
            </td>
        </tr>
    </table>
@endsection
