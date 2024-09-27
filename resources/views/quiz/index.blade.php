@extends('layouts.app')

@section('head')
    <link href="{{asset('/css/quiz.css')}}" rel="stylesheet">
@endsection

@section('content')

    <section class="quiz-index">
        @if($quizes->isNotEmpty())
        <h1 class="text-center">Please select the E-form that you want to complete</h1>

        <div class="quiz-index-container d-flex flex-wrap align-items-start justify-content-between">

            @foreach($quizes as $quiz)
                <div class="quiz-index-item">
                    <h6>{{ $quiz->title }}</h6>
                    <p>{{ $quiz->questions->count() }}
                        {{ __('quiz.questions') }} {{ $quiz->time_limit ? ("/ ". __('quiz.Limit Time in') . ' ' . date("d-m-Y", strtotime($quiz->time_limit)) . ' ' .  __('quiz.minutes')) : "" }}</p>
                    <div class="d-flex align-items-center w-100">
                        <img src="/img/notepad.svg" alt="" class="mr-2">
                        @guest
                            <a href="/form/{{ $quiz->slug }}" data-target="#loginmodal" data-toggle="modal"
                               class="btn my-btn ml-auto text-uppercase">Enter Data</a>
                        @else
                            <a href="/form/{{ $quiz->slug }}?new=true"
                               class="btn my-btn ml-auto text-uppercase">Enter Data</a>
                        @endguest
                    </div>
                </div>
            @endforeach

            <div style="display: flex; width: 100%; justify-content: center">
                {{ $quizes->links() }}
            </div>

        </div>

        <div class="modal fade quiz-modal" id="exampleModalCenter" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="padding: 10px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span style="float:right" aria-hidden="true" class="close-icon"></span>
                    </button>
                    <div class="modal-body text-center">
                        @if(!$is_answered)
                            <p style="font-weight: bold; font-size: 18px;">{{__('Your action has been submitted. You can repeat this process to add more action points to the same log.')}}</p>
                        @else
                            <img src="/img/achievement.svg" alt="" class="mb-4">
                                <p>{{ __('Your action has been submitted. You can repeat this process to add more action points to the same log.') }}</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
        @else
            <h1 class="text-center">You need to be registered to a workshop to access this area</h1>
            <h4 class="text-center">If you think that you should be able to access this area, please contact support</h4>
            <div class="text-center"><a class="btn my-btn mt-3" href="{{route('contact')}}">Contact</a></div>
        @endif
    </section>

@endsection

@section('scripts')
    <script>
        @if($completed)
        $('.quiz-modal').modal('show');
        @endif
    </script>
@endsection

