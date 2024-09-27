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
                                        <h1>Hello {{$friendName}}</h1><br><br>

                                        You have received a discussion from mySpread. Please find details below<br><br>

                                        <strong>Message from: </strong> {{ $data['name'] }}<br>
                                        <strong>Email: </strong> {{ $data['email'] }}<br>
                                        <strong>User Message: </strong> {{ $data['message'] }}<br><br>


                                        <strong>Subject: </strong> {{ $thread->subject }} <br>
                                        <strong>Discussion: </strong> {!! $thread->body !!}<br><br>
                                        <strong>Link: </strong> <a href="{{ route('discussions.show', $thread->id)  }}">{{ route('discussions.show', $thread->id)  }}</a>
                                        <br>
                                        <br>
                                        @if(isset($data['send_responses']))
                                        Responses received so far: <br><br>

                                        @foreach($thread->active_replies as $reply)
                                            <div>
                                                <div>
                                                    <strong>Reply: </strong> {!! $reply->body !!}<br>
                                                </div>
                                                <div>
                                                    {{$reply->user->name}} - Posted from {{$reply->location}} - {{$reply->created_at}}
                                                </div><br><br>
                                            </div>
                                        @endforeach

                                        @endif

                                    </td>
                                    <td class="expander"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class="disclaimer" style="background-color:#F5F5F5; padding:10px; font-size:9px;">Disclaimer: This message us sent to you by the “Share discussion with a Friend” feature in My-Spread. If you are not the intended recipient, please ignore.<br>
                    {{date('Y')}} © SPREAD. All Rights Reserved.</div>
            </td>
        </tr>
    </table>
@endsection
