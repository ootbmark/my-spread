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
                                        @foreach ($groups as $group)
                                            <span
                                                style="font-size:16px; color:#110B42 !important; font-weight:bold">{{ count($group['threads']) }}
                                                new @if (count($group['threads']) > 1)
                                                    discussions
                                                @else
                                                    discussion
                                                @endif received in group: <a
                                                    href="{{ route('groups.discussions', $group['group']->id) }}"
                                                    style="text-decoration:underline; color:#110B42 !important;">{{ $group['group']->name }}</a></span><br><br>

                                            @foreach ($group['threads'] as $thread)
                                                <span
                                                    style="font-size:18px; color:#110B42 !important; font-weight:bold">{{ $thread->subject }}</span><br><br>

                                                <a class="user_link"
                                                    href="{{ route('users.show', $thread->user_id) }}">{{ $thread->user->name }}
                                                    ({{ $thread->user->username }} )</a> of
                                                {{ $thread->user->organisation->name }}, on
                                                {{ $thread->created_at }}<br><br>

                                                {!! $thread->body !!}

                                                <br>

                                                <a class="user_link"
                                                    href="{{ route('discussions.show', $thread->id) }}"><strong>Reply
                                                        now</strong></a><br><br>

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
                @include('emails.footer_alert')
            </td>
        </tr>
    </table>
@endsection
