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
                                    <h1>Hello {{ $user->first_name }} ({{$user->username}}),</h1><br><br>
                                    The administrator has locked your discussion<br><br>
                                    <strong>Admin's decision: </strong> {{$reason}}<br>
                                    <strong>Discussion: </strong> {{$thread->subject}}<br>
                                    <strong>Link: </strong> <a href="{{route('discussions.show', $thread->id)}}">{{route('discussions.show', $thread->id)}}</a>
                                    <br>
                                </td>
                                <td class="expander"></td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>
            <div class="disclaimer" style="background-color:#F5F5F5; padding:10px; font-size:9px;">
                This email was sent to you because you’re a registered member of the SPREAD technical drilling forum. If you wish, you may change the frequency that you receive alerts, and also choose which topics you want to hear about <a class="user_link" href="{{ route('profile.index') }}">HERE</a>. Want out of the loop?
                <br>{{ date('Y') }} © SPREAD. All Rights Reserved. </div>
        </td>
    </tr>
</table>
@endsection
