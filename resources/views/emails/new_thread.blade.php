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
                                        <h1>Hello Admin, </h1> <br><br>

                                        There is a new discussion in the My-Spread Forum.<br>

                                        <strong>Subject: </strong> {{$thread->subject}}<br><br>
                                        <strong>Message Content: </strong>{!!$thread->body!!}<br><br>
                                        <strong>Posted By: </strong> <a class="user_link" href="{{route('users.show', $thread->user_id)}}">{{$thread->user->name}} ({{$thread->user->username}})</a><br><br>

                                        <a href="{{route('discussions.show', $thread->id)}}"><strong>View the discussion</strong></a><br>
                                        <a href="{{route('dashboard.threads.index')}}"><strong>Go to discussion admin panel</strong></a>
                                    </td>
                                    <td class="expander"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class="disclaimer"></div>
            </td>
        </tr>
    </table>
@endsection
