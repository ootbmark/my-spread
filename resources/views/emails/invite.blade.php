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
                                    Invitation from {{ $user->name }}<br><br>

                                    <h1>Hello,</h1> <br><br>

                                    I would like you to take a look at this amazing FREE Discussion forum -SPREAD( Sharing Practices Rigorously, Easily Accelerates Delivery)- the global community of drilling, completion & subsea professionals - Gives you access to a wealth of knowledge that you may not of otherwise had. <br><br>

                                    There are members from organisations all over the world, asking and answering technical questions.<br><br>
                                    I hope you enjoy it as much as I do.<br><br>

                                    Message from <strong>{{ $user->name }}:</strong>
                                    <br><br>
                                    {!!  $body !!}
                                    <br><br>
                                    ----<br>
                                    <a href="{{ route('home') }}">Click here to join</a>
                                    <br>----

                                </td>
                                <td class="expander"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <div class="disclaimer" style="background-color:#F5F5F5; padding:10px; font-size:9px;">Disclaimer: This message us sent to you by the “Invite a Friend” feature in My-Spread. If you are not the intended recipient, please ignore.<br> {{date('Y')}} © SPREAD. All Rights Reserved.</div>
        </td>
    </tr>
</table>
@endsection
