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

                                        {!! $body !!}
                                    </td>
                                    <td class="expander"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class="disclaimer" style="background-color:#F5F5F5; padding:10px; font-size:9px;">You are receiving this email because you are an active user of <a href="{{route('home')}}" title="My-Spread">My-Spread</a>, if you are not the intended recipient or you no longer wish to receive these emails please <a href="{{route('contact')}}" title="Contact Us">contact us</a>.</div>
            </td>
        </tr>
    </table>
@endsection
