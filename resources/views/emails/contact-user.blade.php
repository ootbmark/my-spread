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
                                        <p>{{__("Dear $userFirstName,")}}</p>
                                        <p>
                                            {{__('A fellow member of My-SPREAD wishes to connect with you.')}}
                                            {{__('They have provided the following message:')}}
                                        </p>
                                        <p><b>{{$text}}</b></p>
                                        <p>{{__("If you wish to connect with " . Auth::user()->first_name .", their details are provided below.")}}
                                            {{__('However, if you do not wish to connect with this member, disregard this email and the user will not be alerted.')}}</p>
                                        Name: <strong>{{Auth::user()->name}}</strong> <br>
                                        Organisation: <strong>{{Auth::user()->organisation->name}}</strong> <br>
                                        Email: <a href="mailto:{{Auth::user()->email}}">{{Auth::user()->email}}</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div>
                    <p>{{__("Regards,")}}</p>
                    <p>{{__("The My-SPREAD Team")}}</p>
                </div>
            </td>
        </tr>
    </table>
@endsection
