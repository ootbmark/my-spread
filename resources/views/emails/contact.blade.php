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

                                        <div> Someone just contacted us:</div>
                                        <p><b>Username:</b> {{ $data['username'] }}</p>
                                        <p><b>Name:</b> {{ $data['name'] }}</p>
                                        <p><b>Email:</b> {{ $data['email'] }}</p>
                                        <p><b>Subject:</b> {{ $data['subject'] }}</p>
                                        <p><b>Message:</b> {{ $data['message'] }}</p>
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
