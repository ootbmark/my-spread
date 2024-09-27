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
                                        <div class="disclaimer" style="background-color:#F5F5F5; padding:10px; font-size:9px; border:1px solid #110b42;"><strong>To Admin:</strong>a user has just posted a new contribution to my-spread.
                                        </div><br>


                                        <h1>Hello Admin,</h1><br><br>

                                        The following question has a new reply in the forum.<br><br>

                                        <a class="user_link" href="{{route('users.show', $reply->thread->user_id)}}">{{$reply->thread->user->name}} ({{$reply->thread->user->username}})</a> of {{$reply->thread->user->organisation->name}}, from {{$reply->thread->user->location}} on {{$reply->thread->created_at}}<br><br>

                                        {!!$reply->thread->body !!} <br>

                                        <a class="user_link" href="{{route('discussions.show', $reply->thread_id)}}"><strong>Reply now</strong></a><br><br>

                                        <div class="question"></div><br><br>


                                        <strong>Response(s)</strong><br><br>

                                        <a class="user_link" href="{{route('users.show', $reply->user_id)}}">{{$reply->user->name}} ({{$reply->user->username}})</a> of {{$reply->user->organisation->name}}, from {{$reply->user->location}} on {{$reply->created_at}}<br><br>

                                        {!!$reply->body!!}<br><br>

                                        <a class="user_link" href="{{route('discussions.show', $reply->thread_id)}}"><strong>Reply now</strong></a><br><br>


                                    </td>
                                    <td class="expander"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class="disclaimer" style="background-color:#F5F5F5; padding:10px; font-size:9px;"></div>
            </td>
        </tr>
    </table>
@endsection
