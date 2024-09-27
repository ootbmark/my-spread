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

                                        <p class="lead">A new university has been proposed by {{$user->name}} ({{$user->username}}).</p>
                                        <p>University Name: {{ $university->name }}</p>
                                        <br>
                                        <a href="{{route('dashboard.universities.index')}}">(View all new universities)</a><br>
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
