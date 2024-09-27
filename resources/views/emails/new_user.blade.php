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
                                        <h1>Hello Admin,</h1><br>

                                        <p class="lead">A new user ({{$user->name}}) has been registered into SPREAD.
                                            <br>The details are as follows:</p>
                                        <br>

                                        Username: <strong>{{$user->username}}</strong> <br>
                                        Email: <a href="mailto:{{$user->email}}">{{$user->email}}</a> <br>
                                        Organisation: <strong>{{$user->organisation->name}}</strong>
                                        <br>
                                        <br>
                                        <a href="{{route('dashboard.users.index')}}">(View all new members)</a><br>
                                        Thank you!
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
