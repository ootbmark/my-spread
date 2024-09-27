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
                                            <h1>Hello {{ $user->first_name }} ({{$user->username}}), </h1> <br><br>

                                            Welcome to SPREAD, operated by Relentless <a class="user_link" href="http://rp-squared.com/" target="_blank">Pursuit of Perfection Ltd.</a> <br><br>

                                            SPREAD is a global knowledge sharing community where drilling,completion and sub-sea professionals can seek and discuss knowledge and experiences easily. You may login to SPREAD using the following link:<br><br>

                                            <a href="{{route('login')}}" class="user_link">Login to SPREAD!</a><br><br>

                                            For your reference, your username is "{{$user->username}}". After login, if you wish, you may <a href="{{route('profile.index')}}" class="user_link">"edit your profile"</a> to change the password and other information related to your profile.<br><br>
                                           
                                            You can also watch the following video:<br>
                                            1. <a href="https://www.youtube.com/watch?v=jiRMzKG06jU"> What is SPREAD? </a><br>
                                            2 <a href="https://www.youtube.com/watch?v=OF5mv8jXGWs"> Guide in Posting a discussion </a><br><br>
                                            
                                            The "welcome pack" contains some quick information to help you get started, you can view it online at <a href="{{route('home')}}/public/welcome.pdf" class="user_link">{{route('home')}}/public/welcome.pdf</a>. Also, we have a detailed help section on using SPREAD at <a href="{{route('help')}}" class="user_link">{{route('help')}}</a>.<br><br>

                                            Thank you for your time,<br>
                                            My-Spread Admin<br><br>
                                    </td>
                                    <td class="expander"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class="disclaimer" style="background-color:#F5F5F5; padding:10px; font-size:9px;">Disclaimer: This is an automated email from My-Spread. If you are not the intended recipient, please ignore.<br> {{date('Y')}} © SPREAD. All Rights Reserved.</div>
            </td>
        </tr>
    </table>
@endsection
