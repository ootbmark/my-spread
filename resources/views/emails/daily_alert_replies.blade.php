@extends('emails.layouts.app')
@section('content')
    <table class="container">
        <tr>
            <td>
                <a href="https://rp-squared.com/" target="_blank">
                    <img align="center" border="0" src="https://my-spread.com/images/rp-squared-780-x-90-banner_1.png"
                        alt="ads-banner" title="rp-squared" style="max-width: 100%;" />
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <table class="row">
                    <tr>
                        <td class="wrapper last">

                            <table class="twelve columns">
                                <tr>
                                    <td>
                                        <h1>Hello {{ $user->first_name }} ({{ $user->username }}),</h1><br><br>

                                        @foreach ($reply_groups as $group)
                                            @foreach ($group['threads'] as $thread)
                                                <span
                                                    style="font-size:16px; color:#110B42 !important; font-weight:bold">{{ count($thread['replies']) }}
                                                    new
                                                    @if (count($thread['replies']) > 1)
                                                        responses
                                                    @else
                                                        response
                                                    @endif

                                                    received in group: <a
                                                        href="{{ route('groups.discussions', $group['group']->id) }}"
                                                        style="text-decoration:underline; color:#110B42 !important;">{{ $group['group']->name }}</a>
                                                </span><br><br>

                                                <span
                                                    style="font-size:18px; color:#110B42 !important; font-weight:bold"><strong>{{ $thread['thread']->subject }}</strong></span><br /><br />

                                                <a class="user_link"
                                                    href="{{ route('users.show', $thread['thread']->user_id) }}">{{ $thread['thread']->user->name }}
                                                    ({{ $thread['thread']->username }})</a> of
                                                {{ $thread['thread']->user->organisation->name }}, from
                                                {{ $thread['thread']->location }} on
                                                {{ $thread['thread']->created_at }}<br><br>

                                                {!! $thread['thread']->body !!} <br>

                                                <a class="user_link"
                                                    href="{{ route('discussions.show', $thread['thread']->id) }}"><strong>Reply
                                                        now</strong></a><br><br><br>

                                                <span
                                                    style="font-size:18px; color:#110B42 !important; font-weight:bold">Responses</span><br /><br />

                                                @foreach ($thread['replies'] as $reply)
                                                    <a class="user_link"
                                                        href="{{ route('users.show', $reply->user_id) }}">{{ $reply->user->name }}
                                                        ({{ $reply->user->username }})</a> of
                                                    {{ $reply->user->organisation->name }}, on
                                                    {{ $reply->created_at }}<br><br>
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
                @include('emails.footer_alert')
            </td>
        </tr>
    </table>
@endsection
