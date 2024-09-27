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
                                    <h1>Hello {{ $user->first_name }} ({{$user->username}}),</h1>
                                    <p class="lead"></p>
                                    <p>Welcome to My-Spread. The Administrator has changed your status to {{ $user->status }}... Please let us know if there is anything else we can do for you.</p>
                                    <p>{!! $body !!}</p>

                                    <p>Thanks, mySpread</p>
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
