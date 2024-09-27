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

                                        <p class="lead">A new organisation has been proposed by {{$user->name}} ({{$user->username}}).</p>
                                        <p>Organisation Name: {{ $organisation->name }}<br />
                                            Organisation Email: {{ $organisation->email }}</p>
                                        <br>
                                        <a href="{{route('dashboard.organisations.index')}}">(View all new organisations)</a><br>
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
