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

                                    <h1>Hello Admin,</h1><br><br>

                                    The following user has changed their work email:<br><br>

                                    <strong>First Name</strong>: {{$user->first_name}}<br>
                                    <strong>Last Name</strong>: {{$user->last_name}}<br>
                                    <strong>Username</strong>: {{$user->username}}<br>
                                    <strong>Old Email</strong>: {{$old_email}}<br>
                                    <strong>New Email</strong>: {{$user->email}}<br><br>

                                    ----<br>
                                    <a class="user_link" href="{{route('users.show', $user->id)}}"><strong>Click here to see the users Profile</strong></a>
                                    <br>----

                                </td>
                                <td class="expander"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
@endsection
