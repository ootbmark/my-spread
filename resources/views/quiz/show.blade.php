@extends('layouts.app')
@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="{{asset('/css/quiz.css')}}" rel="stylesheet">
{{--    <link href="{{asset('/css/app-quiz.css')}}" rel="stylesheet">--}}
{{--    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">--}}

    <style>
        div.time-progress {
            position: sticky;
            top: 0;
            z-index: 2;
            background-color: #F0F1F6;
            margin: 0 auto;
            padding: 20px 15px 20px;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.13);
            border-top: #bdbdc1 solid 1px;
        }

        div#timer {
            font-size: 24px;
            padding: 4px;
            color: #222324;
        }

        .w3-container, .w3-panel {
            padding: 3px 15px;
            border-radius: 16px 0 0 16px;
            min-width: 50px;
        }

        .time-progress-container {
            max-width: 1238px;
            margin: 0 auto;
        }

        .parent-progress {
            width: 100%;
            background-color: #fff !important;
            border-radius: 16px;
            overflow: hidden;
        }

        @media (max-width: 991px) {
            div.time-progress {
                top: 49px;
            }
        }

        .zoomImageCloseIcon {
            right: 10px;
            top: 7px;
            z-index: 9;
        }

        .zoomImageCloseIcon button {
            outline: none;
            opacity: 1;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            transition: background-color .2s;
            justify-content: center;
            border-radius: 50%;
        }

        .zoomImageCloseIcon button:hover {
            background: #f2f2f2;
            opacity: 1;
        }

        .zoomImageCloseIcon button span {
            color: #666;
            margin-bottom: 1px;
            display: block;
        }


        .question_popup {
            position: absolute;
            right: 0;
            min-height: 150px;
            min-width: 300px;
            width: 1024px;
            border: 1px solid #F0F1F6;
            bottom: 0;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 0 10px #F0F1F6;
            color: #666;
            user-select: none;
            display: none;
            /*cursor: pointer;*/
        }

        @media (max-width: 1020px) {
            .question_popup {

            }
        }

    </style>

@endsection
@section('content')

    <section class="quiz">
        @if(!empty($is_participate) && !$participate)
            <div style="text-align: center; padding-top: 65px;">

                {{--                <p class="">--}}
                {{--                    {{ __('quiz.double_click_text') }}--}}
                {{--                </p>--}}

                @if(!$is_answered)
                    <h1>{{__('Thank you')}}</h1>
                @else

                    @if(!$answer_text)
                        <h1>{{__('Thank you')}}</h1>
                    @else
                        <h1>{{ __('Thank you') }}</h1>
                    @endif
                @endif

                <a style="font-size: 15px;" class="btn my-btn text-uppercase"
                   href="{{route('quiz', $is_participate['slug'])}}?new=true&participate=true">
                    {{ __('quiz.Try Again') }}
                </a>
            </div>

        @else
            <div class="time-progress w-100">
                <div class="time-progress-container">
                    <div style="overflow: hidden" class="text-right">
                        @if($time_limit !== '')
                            <div id="timer"></div>
                        @endif
                    </div>

                    <div class="w3-light-grey w3-round-xlarge parent-progress">
                        <div class="w3-container w3-blue w3-round-xlarge progress-bar"
                             style="width:{{ $percent }}%; background-color: #524a90 !important;">{{ $percent }}%
                        </div>
                    </div>
                </div>

            </div>

            <h1 class="text-center"><b>{{ $quiz->title }}</b></h1>
            <h2 class="text-center">{{ $quiz->description }}</h2>

            <div class="d-md-flex  @if(!count($groups)) justify-content-center @else justify-content-between @endif align-items-center mt-5  mb-2 quiz-container ">
                @if(count($groups))
                    <div class="">
                        {{--                    {!! Form::label('user_group', 'Groups') !!}--}}
                        <select id="user_group" class="form-control mb-2" style="color: #555">
                            <option value="" disabled selected>Choose group</option>
                            @foreach($groups as $key => $group)

                                <option value="{{ $key }}">{{ $group }}</option>
                            @endforeach
                        </select>
                        {!! $errors->first('user_group', '<span class="form-text text-danger">:message</span>') !!}
                    </div>
                @endif
                <div class="d-md-flex">
                    <div class="text-center mr-md-5 d-flex flex-column align-items-center">
                        <div class="text-center quiz-checkbox-name">
                            {{ __('Value') }}
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="custom-radio">
                                <input id="hard" type="radio" name="numbers" class="status_radio radio-high" value="high">
                                <label class="hard-color" for="hard">High</label>
                                <input id="medium" type="radio" name="numbers" class="status_radio radio-medium" value="medium">
                                <label class="medium-color" for="medium">Medium</label>
                                <input id="low" type="radio" name="numbers" class="status_radio radio-low" value="low">
                                <label class="low-color" for="low">Low</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mr-md-5 d-flex flex-column align-items-center">
                        <div class="text-center quiz-checkbox-name">
                            {{ __('Effort') }}
                        </div>
                        <div class="d-flex align-items-center d-flex flex-column align-items-center">
                            <div class="custom-radio">
                                <input id="hard2" type="radio" name="effort" value="high" class="status_radio_effort radio-high">
                                <label class="hard-color" for="hard2">High</label>
                                <input id="medium2" type="radio" name="effort" value="medium"
                                       class="status_radio_effort radio-medium">
                                <label class="medium-color" for="medium2">Medium</label>
                                <input id="low2" type="radio" name="effort" value="low" class="status_radio_effort radio-low">
                                <label class="low-color" for="low2">Low</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mr-0">
                        <div class="text-center quiz-checkbox-name">
                            {{ __('Priority') }}
                        </div>
                        <div class="d-flex align-items-center d-flex flex-column align-items-center">
                            <div class="custom-radio">
                                <input id="hard3" type="radio" name="priority" value="high" class="radio_priority radio-high">
                                <label class="hard-color" for="hard3">High</label>
                                <input id="medium3" type="radio" name="priority" value="medium"
                                       class="radio_priority radio-medium">
                                <label class="medium-color" for="medium3">Medium</label>
                                <input id="low3" type="radio" name="priority" value="low" class="radio_priority radio-low">
                                <label class="low-color" for="low3">Low</label>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="quiz-container">
                {{--                <div class="quiz-ipt-no">--}}
                {{--                    <input class="quiz-ipt-each" type="text" placeholder="Group No.">--}}
                {{--                </div>--}}
                @foreach($quiz->questions as $question)
                    <div class="quiz-block">
                        <div class="d-flex justify-content-between align-items-start">
                            <h4 class="quiz-title mt-0">{{ $loop->index + 1 }}. {{ $question->title }}</h4>
                            @if($question->question_info)
                                <div class="position-relative question_info">
                                    <svg width="25" version="1.1" class="" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                         viewBox="0 0 496.158 496.158"
                                         style="enable-background:new 0 0 496.158 496.158; cursor: pointer"
                                         xml:space="preserve">
<path style="fill:#25B7D3;" d="M496.158,248.085c0-137.022-111.069-248.082-248.075-248.082C111.07,0.003,0,111.063,0,248.085
	c0,137.001,111.07,248.07,248.083,248.07C385.089,496.155,496.158,385.086,496.158,248.085z"/>
                                        <path style="fill:#FFFFFF;" d="M138.216,173.592c0-13.915,4.467-28.015,13.403-42.297c8.933-14.282,21.973-26.11,39.111-35.486
	c17.139-9.373,37.134-14.062,59.985-14.062c21.238,0,39.99,3.921,56.25,11.755c16.26,7.838,28.818,18.495,37.683,31.97
	c8.861,13.479,13.293,28.125,13.293,43.945c0,12.452-2.527,23.367-7.581,32.739c-5.054,9.376-11.062,17.469-18.018,24.279
	c-6.959,6.812-19.446,18.275-37.463,34.388c-4.981,4.542-8.975,8.535-11.975,11.976c-3.004,3.443-5.239,6.592-6.702,9.447
	c-1.466,2.857-2.603,5.713-3.406,8.57c-0.807,2.855-2.015,7.875-3.625,15.051c-2.784,15.236-11.501,22.852-26.147,22.852
	c-7.618,0-14.028-2.489-19.226-7.471c-5.201-4.979-7.8-12.377-7.8-22.192c0-12.305,1.902-22.962,5.713-31.97
	c3.808-9.01,8.861-16.92,15.161-23.73c6.296-6.812,14.794-14.904,25.488-24.28c9.373-8.202,16.15-14.392,20.325-18.567
	c4.175-4.175,7.69-8.823,10.547-13.953c2.856-5.126,4.285-10.691,4.285-16.699c0-11.718-4.36-21.605-13.074-29.663
	c-8.717-8.054-19.961-12.085-33.728-12.085c-16.116,0-27.981,4.065-35.596,12.195c-7.618,8.13-14.062,20.105-19.336,35.925
	c-4.981,16.555-14.43,24.829-28.345,24.829c-8.206,0-15.127-2.891-20.764-8.679C141.035,186.593,138.216,180.331,138.216,173.592z
	 M245.442,414.412c-8.937,0-16.737-2.895-23.401-8.68c-6.667-5.784-9.998-13.877-9.998-24.279c0-9.229,3.22-16.991,9.668-23.291
	c6.444-6.297,14.354-9.448,23.73-9.448c9.229,0,16.991,3.151,23.291,9.448c6.296,6.3,9.448,14.062,9.448,23.291
	c0,10.255-3.296,18.312-9.888,24.17C261.7,411.481,254.084,414.412,245.442,414.412z"/>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
</svg>
                                    <div class="question_popup p-4">
                                        {!! $question->question_info !!}
                                    </div>
                                </div>
                            @endif
                        </div>


                        <div style="margin-bottom: 1.5em">
                            @if($question->file_type === 'image')
                                <div
                                    style="text-align: left" {{ $question->question_required ? 'data-required=1' : '' }}>
                                    <img style="max-width:100%; max-height: 300px;" src="{{ $question->file_url }}"
                                         alt="img">
                                </div>
                            @elseif($question->file_type === 'image_url')
                                <div
                                    style="text-align: left" {{ $question->question_required ? 'data-required=1' : '' }}>
                                    <img style="max-width:100%; max-height: 300px;" src="{{ $question->url }}"
                                         alt="img">
                                </div>
                            @elseif($question->file_type === 'youtube')
                                <iframe style="width:100%; height: 540px;"
                                        src="https://www.youtube.com/embed/{{ $question->url }}" frameborder="0"
                                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen
                                    {{ $question->question_required ? 'data-required="1"' : '' }}
                                >
                                </iframe>
                            @elseif($question->file_type === 'video')
                                <div style="margin: auto" {{ $question->question_required ? 'data-required=1' : '' }}>
                                    <video style="width: 100%;max-height: 67vh;" controls>
                                        <source src="{{ $question->file_url  }}" type="video/mp4">
                                    </video>
                                </div>
                            @endif
                        </div>

                        {{--ANSWERS--}}
                        @if($question->type === 'file')
                            <div
                                class="d-flex flex-wrap align-items-start checkbox-image-container" {{ $question->question_required ? 'data-required=1' : '' }}>
                                @foreach($question->answers as $key => $answer)
                                    <div class=" custom-control custom-checkbox checkbox-image">
                                        <input type="checkbox" class="custom-control-input" value="{{ $answer->id }}"
                                               {{ isset($answers[$question->id]) && in_array_field($answer->id, 'answer_id', $answers[$question->id]) ? 'checked' : '' }}
                                               data-id="{{ $question->id }}" id="customCheck{{ $answer->id }}">
                                        <label class="custom-control-label" for="customCheck{{ $answer->id }}">
                                            <a href="{{ $answer->file_url ?? $answer->url }}" class="imageZoom"
                                               data-target="#imageZoomModal" data-toggle="modal">
                                                <img src="{{ $answer->file_url ?? $answer->url }}" alt="Random"/>
                                            </a>
                                        </label>
                                    </div>
                                @endforeach
                                <small class="text-danger error" style="display: none;">The field is required</small>
                            </div>
                        @elseif($question->type === 'multiple')
                            <div {{ $question->question_required ? 'data-required=1' : '' }}>
                                @foreach($question->answers as $key => $answer)
                                    <div class=" custom-control custom-checkbox">
                                        <input class="custom-control-input custom-checkbox" type="checkbox" name=""
                                               {{ isset($answers[$question->id]) && in_array_field($answer->id, 'answer_id', $answers[$question->id]) ? 'checked' : '' }}
                                               id="exampleRadios{{ $answer->id }}" data-id="{{ $question->id }}"
                                               value="{{ $answer->id }}">
                                        <label class="custom-control-label" for="exampleRadios{{ $answer->id }}">
                                            {{ $answer->title }}
                                        </label>

                                    </div>
                                @endforeach
                                    <small class="text-danger error" style="display: none">The fields is
                                        required</small>
                            </div>
                        @elseif($question->type === 'dropdown')
                            <div {{ $question->question_required ? 'data-required=1' : '' }}>
                                <div class="form-group" >
                                    <select class="custom-select" data-id="{{ $question->id }}" aria-label="select">
                                        <option value="">{{__('Option')}}...</option>
                                        @foreach($question->answers as $answer)
                                            <option
                                                value="{{ $answer->id }}" {{ (Arr::exists($answers, $question->id) && $answers[$question->id][0]['answer_id'] ==  $answer->id) ? 'selected' : '' }}>
                                                {{ $answer->title }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                <small class="text-danger error" style="display: none">The fields is required</small>
                            </div>


                        @elseif($question->type === 'radio')
                            <div {{ $question->question_required ? 'data-required=1' : '' }}>
                                @foreach($question->answers as $answer)
                                    <div class=" custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" name="radio"
                                               {{ (Arr::exists($answers, $question->id) && $answers[$question->id][0]['answer_id'] ==  $answer->id) ? 'checked' : '' }}
                                               id="exampleRadios{{ $answer->id }}" data-id="{{ $question->id }}"
                                               value="{{ $answer->id }}">
                                        <label class="custom-control-label" for="exampleRadios{{ $answer->id }}">
                                            {{ __('quiz.'. $answer->title) }}
                                        </label>
                                    </div>
                                @endforeach
                                <small class="text-danger error" style="display: none">The field is required</small>
                            </div>

                        @elseif($question->type === 'text')

                            <div class="form-group" {{ $question->question_required ? 'data-required=1' : '' }}>
                                <input type="text" class="form-control text"
                                       value="{{ Arr::exists($answers, $question->id) ? $answers[$question->id][0]['text'] : '' }}"
                                       data-id="{{ $question->id }}" aria-describedby="" aria-label="input">
                                <small class="text-danger error" style="display: none">The field is required</small>
                            </div>
                        @elseif($question->type === 'textarea')
                            <div class="form-group" {{ $question->question_required ? 'data-required=1' : '' }}>
                        <textarea class="form-control textarea" rows="3" data-id="{{ $question->id }}"
                                  aria-label="textarea"
                        >{{ Arr::exists($answers, $question->id) ? $answers[$question->id][0]['text'] : ''}}</textarea>
                                <small class="text-danger error" style="display: none">The field is required</small>
                            </div>
                        @elseif($question->type === 'circling')
                            <div class="circling" {{ $question->question_required ? 'data-required=1' : '' }}>
                                <div class="d-flex">
                                    @foreach($question->answers as $key => $answer)
                                        @php
                                            $checked = false;
                                        @endphp
                                        @foreach($answer->quiz_answer()->where('user_quiz_id', $user_quiz_id)->get() as $item)
                                            @php
                                                if ($item){
                                                    $checked = true;
                                                }
                                            @endphp
                                        @endforeach
                                        <div style="margin-right: 40px" class=" custom-control custom-checkbox">
                                            <input class="custom-control-input custom-checkbox" type="checkbox"
                                                   name="dd{{$question->id}}"
                                                   data-type="circling"

                                                   {{ $checked ? "checked" : '' }}
                                                   id="exampleRadios{{ $answer->id }}" data-id="{{ $question->id }}"
                                                   value="{{ $answer->id }}"
                                                   data-is-not-empty="{{ isset($answers[$question->id]) && in_array_field($answer->id, 'answer_id', $answers[$question->id]) ? '1' : '' }}">
                                            <label class="custom-control-label" for="exampleRadios{{ $answer->id }}">
                                                {{ $answer->title }}
                                            </label>
                                        </div>

                                    @endforeach

                                </div>
                                <div class="form-group textarea">
                                <textarea class="form-control textarea" rows="3" data-id="{{ $question->id }}"
                                          data-type="circling_text">{{ Arr::exists($answers, $question->id) ? $answers[$question->id][0]['text'] : ''}}</textarea>
                                    <small class="text-danger error" style="display: none">The fields is
                                        required</small>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach

                <form class="quiz" action="{{ route('quiz-complete', $quiz->id) }}" method="post" id="dane_form">
                    @csrf
                    @method('PATCH')
                    <div class="d-flex quiz-ipt">
                        <div class="quiz-ipt-left">
                            <input class="quiz-ipt-each form-control" type="text" name="focal_point"
                                   placeholder="Oil Co Focal Point (e.g. Drilling Engr.)">
                            <input class="quiz-ipt-each form-control" type="text" name="action_party"
                                   placeholder="Actual Actionee (e.g. Service Co rep.)">
                            <div class="self-verification d-flex flex-column">
                                <div class="py-2">Self Verification</div>
                                <div class="d-flex flex-row">
                                    <div class="d-flex flex-column w-50">
                                        <div class="self-verification-option">
                                            <input class="custom-checkbox" type="checkbox" name="is_verification_1"
                                                   id="is_verification_1">
                                            <label class="" for="is_verification_1">
                                                {{ $quiz->verification_text_1 }}
                                            </label>
                                        </div>
                                        <div class="self-verification-option">
                                            <input class="custom-checkbox" type="checkbox" name="is_verification_2"
                                                   id="is_verification_2">
                                            <label class="" for="is_verification_2">
                                                {{ $quiz->verification_text_2 }}
                                            </label>
                                        </div>
                                        <div class="self-verification-option">
                                            <input class="custom-checkbox" type="checkbox" name="is_verification_3"
                                                   id="is_verification_3">
                                            <label class="" for="is_verification_3">
                                                {{ $quiz->verification_text_3 }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column w-50">
                                        <div class="self-verification-option">
                                            <input class="custom-checkbox" type="checkbox" name="is_verification_4"
                                                   id="is_verification_4">
                                            <label class="" for="is_verification_4">
                                                {{ $quiz->verification_text_4 }}
                                            </label>
                                        </div>
                                        <div class="self-verification-option">
                                            <input class="custom-checkbox" type="checkbox" name="is_verification_5"
                                                   id="is_verification_5">
                                            <label class="" for="is_verification_5">
                                                {{ $quiz->verification_text_5 }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="quiz-ipt-right">
                            <input class="datepicker quiz-ipt-each form-control" name="target_date" type="text"
                                   autocomplete="off"
                                   placeholder="And by when:">
                            <input class="quiz-ipt-each form-control" type="text" name="business_partner"
                                   placeholder="Lead Business Partner">
                        </div>
                    </div>
                    <div class="d-none" id="hidden_inp"></div>
                    <div class="d-none" id="hidden_inp_effort"></div>
                    <div class="d-none" id="hidden_inp_priority"></div>
                    <div class="d-none" id="group"></div>
                    <div class="text-center mt-3 form-error" style="display: none">
                        <small class="text-danger " style="font-size: 20px">Please answer all questions</small>
                    </div>

                    <div class="text-center mt-4">
                        @if($course_id)
                            <input type="hidden" name="course_id" value="{{ $course_id }}">
                        @endif


                        <button type="submit" id="form_submit_button" class="btn my-btn text-uppercase done">{{ __('Done') }}</button>
                    </div>
                </form>
            </div>
        @endif

    </section>
    <div class="modal fade" id="imageZoomModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="position-absolute zoomImageCloseIcon">
                    <button type="button" class="close p-2" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0 text-center">

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script>
        $('.datepicker').datepicker({
            format: 'dd MM yyyy',
        });
        $('.status_radio').change(function () {
            $('#dane_form #hidden_inp').html(`<input type="hidden" value="${$(this).val()}" name="is_priority">`);
        });

        $('.status_radio_effort').change(function () {
            $('#dane_form #hidden_inp_effort').html(`<input type="hidden" value="${$(this).val()}" name="is_priority_effort">`);
        });
        $('.radio_priority').change(function () {
            $('#dane_form #hidden_inp_priority').html(`<input type="hidden" value="${$(this).val()}" name="is_priority_priority">`);
        });
        $('#user_group').change(function () {
            $('#dane_form #group').html(`<input type="hidden" value="${$(this).val()}" name="group_id">`);
        });

        $('.question_info').hover(function () {
            $(this).find('.question_popup').fadeIn(100)
        }, function () {
            $(this).find('.question_popup').fadeOut(100)
        });


        $('.imageZoom').click(function (e) {
            e.preventDefault();
            if ($(this).attr('href')) {
                $(this).attr('data-toggle', 'modal');
                $('#imageZoomModal').find('.modal-body').html(`<img src='${$(this).attr('href')}'>`)
            } else {
                $(this).attr('data-toggle', '')
            }

        })
    </script>

    <script>

        $('#form_submit_button').on('click', function (e) {
            e.preventDefault();

            $(this).attr('disabled', true);

            $('#dane_form').submit();
        });

        var percent = 0;

        @if($quiz->is_required_fields)
        $('#dane_form').submit(function () {

            if (percent != 100) {
                $('.form-error').show();
                setTimeout(function () {
                    $('.form-error').fadeOut('slow');
                }, 5000);
                $('#form_submit_button').attr('disabled', false);
                return false;
            } else {
                this.is_check = true;
                $('.form-error').hide()
            }
        });
        @endif

        $('#dane_form').submit(function (e) {
            var checkAllI = true;
            var requiredFields = $('div[data-required=1]');
            var firstError = null;
            let i = 0;

            while (i < requiredFields.length) {
                let fieldBlock = $(requiredFields[i]);

                var inputs = fieldBlock.find('input, textarea, select');

                inputs.map(function (index, itemIn) {
                    if (!$(itemIn).val() && !firstError) {
                        firstError = $(itemIn);
                        checkAllI = false;
                        fieldBlock.find('small.error').show();
                        setTimeout( () => {
                            fieldBlock.find('small.error').fadeOut('slow');
                        }, 10000);
                        $('body, html').animate({
                            scrollTop: fieldBlock.offset().top - 130
                        }, 700);
                    }
                });

                if (fieldBlock.find('input[type=checkbox], input[type=radio]').length && !firstError) {
                    if (fieldBlock.find('input[type=checkbox]:checked, input[type=radio]:checked').length) {
                        checkAllI = true;
                    } else {
                        fieldBlock.find('small.error').show();
                        setTimeout(function () {
                            fieldBlock.find('small.error').fadeOut('slow');
                        }, 10000);
                        $('body, html').animate({
                            scrollTop: fieldBlock.offset().top - 130
                        }, 700);
                        checkAllI = false;
                        break;
                    }
                }

                i++;
            }

            if (!checkAllI) {
                $('#form_submit_button').attr('disabled', false);
            }

            return checkAllI;

        });

        if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
            window.location.reload();
        }

        $(document).ready(function () {
            // TIMER
            if ('{{ $time_limit }}' !== '') {
                $("#timer")
                    .countdown("{{ $time_limit }}", function (event) {
                        $(this).text(
                            event.strftime('%H:%M:%S')
                        );
                    }).on('finish.countdown', function () {
                    $('form.quiz').submit();
                });
            }
            const answer = (route, method, question_id, answer, type = null, text = null) => {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: route,
                    method: method,
                    data: {
                        question_id: question_id,
                        answer: answer,
                        type: type,
                        text: text,
                    },
                    success: function (result) {
                        percent = result.percent;
                        $('.progress-bar').css('width', result.percent + '%');
                        $('.progress-bar').text(result.percent + '%');
                    }
                });
            };

            $(".js-example-responsive").select2({
                width: 'resolve'
            }).on('select2:select', function (e) {

                answer('{{ route('quiz-answer', $user_quiz_id) }}', 'POST', $(this).attr('data-id'), e.params.data.id)

            }).on('select2:unselect', function (e) {

                answer('{{ route('delete-quiz-answer', $user_quiz_id) }}', 'DELETE', $(this).attr('data-id'), e.params.data.id)

            });

            $('.custom-control-input').click(function () {

                if ($(this).prop("checked") == true) {

                    answer('{{ route('quiz-answer', $user_quiz_id) }}', 'POST', $(this).attr('data-id'), $(this).val(), $(this).data('type'), $(this).parents('div.circling').find('textarea').val())

                } else if ($(this).prop("checked") == false) {

                    answer('{{ route('delete-quiz-answer', $user_quiz_id) }}', 'DELETE', $(this).attr('data-id'), $(this).val(), $(this).data('type'), $(this).parents('div.circling').find('textarea').val())

                }

            });

            $('.custom-select').on('change', function () {

                if ($(this).val() === "") {

                    answer('{{ route('delete-quiz-answer', $user_quiz_id) }}', 'DELETE', $(this).attr('data-id'))

                } else {

                    answer('{{ route('quiz-answer', $user_quiz_id) }}', 'POST', $(this).attr('data-id'), $(this).val(), 'dropdown');

                }
            });


            $('.form-check-input').on('change', function () {

                answer('{{ route('quiz-answer', $user_quiz_id) }}', 'POST', $(this).attr('data-id'), $(this).val(), 'radio');

            });

            $('.text').on('blur', function () {

                if ($(this).val() === '') {
                    answer('{{ route('delete-quiz-answer', $user_quiz_id) }}', 'DELETE', $(this).attr('data-id'))
                } else {
                    answer('{{ route('quiz-answer', $user_quiz_id) }}', 'POST', $(this).attr('data-id'), $(this).val(), 'text');
                }
            });

            $('.textarea').on('blur', function () {
                if ($(this).val() === '') {
                    answer('{{ route('delete-quiz-answer', $user_quiz_id) }}', 'DELETE', $(this).attr('data-id'), $(this).val(), $(this).data('type'))
                } else {
                    answer('{{ route('quiz-answer', $user_quiz_id) }}', 'POST', $(this).attr('data-id'), $(this).val(), $(this).data('type'));
                }
            });

        });


    </script>

@endsection
