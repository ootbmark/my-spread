@extends('layouts.app')
@section('content')
    <div class="my-container pt-5 mb-5">
        <h1 class="title-h2 mb-4 text-center">LOGOUT FROM SPREAD</h1>
        <div class="my-container bg-white p-4">
            <p>Thank you for using SPREAD. It is constantly being maintained and updated.
                Could you kindly provide feedback to ensure that all users achieve the most from SPREAD?
                Any recommendations you have will be most welcome.</p>

            <p> We have attempted to keep this system simple and user-friendly. Please record your lingering questions
                for enlarging the vision. When an appropriate answer is received, it will be sent to you via email.
                Answers to questions may also be found in the <a href="{{route('faq')}}">FAQs</a> or in the <a
                    href="{{route('help')}}">Help</a> if it is of general nature.
                We hope that your required information was found and look forward to seeing you again soon.
                Please <a href="{{route('contact')}}">send us your feedbacks or questions</a> you found hard to get answers. Let SPREAD think!</p>

            <p>Alternatively, you may <a href="{{route('login')}}">login again</a> now or return to the
                <a href="{{route('home')}}">home page.</a></p>
        </div>
    </div>
@endsection
