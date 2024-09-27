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
            padding: 5px 15px 20px;
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
        .zoomImageCloseIcon{
            right: 10px;
            top: 7px;
            z-index: 9;
        }
        .zoomImageCloseIcon button{
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
        .zoomImageCloseIcon button:hover{
            background: #f2f2f2;
            opacity: 1;
        }
        .zoomImageCloseIcon button span{
            color: #666;
            margin-bottom: 1px;
            display: block;
        }
    </style>

@endsection
@section('content')
    <section class="quiz">
        <h1 class="text-center"><b>{{ $quiz->title }}</b></h1>
        <h2 class="text-center">{{ $quiz->description }}</h2>

        <div class="quiz-container">
            @foreach($quiz->questions as $question)
                <div class="quiz-block">
                    <h4 class="quiz-title">{{ $loop->index + 1 }}. {{ $question->title }}</h4>

                    <div style="margin-bottom: 1.5em">
                        @if($question->file_type === 'image')
                            <div style="text-align: center">
                                <img style="max-width:100%" src="{{ $question->file_url }}" alt="img">
                            </div>
                        @elseif($question->file_type === 'image_url')
                            <div style="text-align: center">
                                <img style="max-width:100%;" src="{{ $question->url }}" alt="img">
                            </div>
                        @elseif($question->file_type === 'youtube')
                            <iframe style="width:100%; height: 540px;"
                                    src="https://www.youtube.com/embed/{{ $question->url }}" frameborder="0"
                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                            </iframe>
                        @elseif($question->file_type === 'video')
                            <div style="margin: auto">
                                <video style="width: 100%;max-height: 67vh;" controls>
                                    <source src="{{ $question->file_url  }}" type="video/mp4">
                                </video>
                            </div>
                        @endif
                    </div>

                    {{--ANSWERS--}}
                    @if($question->type === 'file')
                        <div class="d-flex flex-wrap align-items-start checkbox-image-container">
                            @foreach($question->answers as $key => $answer)
                                <div class="custom-control custom-checkbox checkbox-image">
                                    <input type="checkbox" class="custom-control-input" value="{{ $answer->id }}"
                                           {{ isset($answers[$question->id]) && in_array_field($answer->id, 'answer_id', $answers[$question->id]) ? 'checked' : '' }}
                                           data-id="{{ $question->id }}" id="customCheck{{ $answer->id }}">
                                    <label class="custom-control-label" for="customCheck{{ $answer->id }}">
                                        <a href="{{ $answer->file_url ?? $answer->url }}" class="imageZoom" data-target="#imageZoomModal" data-toggle="modal">
                                            <img src="{{ $answer->file_url ?? $answer->url }}" alt="Random" />
                                        </a>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @elseif($question->type === 'multiple')
                        @foreach($question->answers as $key => $answer)
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input custom-checkbox" type="checkbox" name=""
                                       {{ isset($answers[$question->id]) && in_array_field($answer->id, 'answer_id', $answers[$question->id]) ? 'checked' : '' }}
                                       id="exampleRadios{{ $answer->id }}" data-id="{{ $question->id }}"
                                       value="{{ $answer->id }}">
                                <label class="custom-control-label" for="exampleRadios{{ $answer->id }}">
                                    {{ $answer->title }}
                                </label>
                            </div>
                        @endforeach
                    @elseif($question->type === 'dropdown')
                        <div class="form-group">
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
                    @elseif($question->type === 'radio')
                        @foreach($question->answers as $answer)
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" name="radio"
                                       {{ (Arr::exists($answers, $question->id) && $answers[$question->id][0]['answer_id'] ==  $answer->id) ? 'checked' : '' }}
                                       id="exampleRadios{{ $answer->id }}" data-id="{{ $question->id }}"
                                       value="{{ $answer->id }}">
                                <label class="custom-control-label" for="exampleRadios{{ $answer->id }}">
                                    {{ __('quiz.'. $answer->title) }}
                                </label>
                            </div>
                        @endforeach
                    @elseif($question->type === 'text')
                        <div class="form-group">
                            <input type="text" class="form-control text"
                                   value="{{ Arr::exists($answers, $question->id) ? $answers[$question->id][0]['text'] : '' }}"
                                   data-id="{{ $question->id }}" aria-describedby="" aria-label="input">
                        </div>
                    @elseif($question->type === 'circling')
                        <div class="d-flex">
                            @foreach($question->answers as $key => $answer)

                                <div style="margin-right: 40px" class=" custom-control custom-checkbox">
                                    <input class="custom-control-input custom-checkbox" type="checkbox" name=""
                                           data-type="circling"
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
                                          data-type="circling">{{ Arr::exists($answers, $question->id) ? $answers[$question->id][0]['text'] : ''}}</textarea>
                        </div>

                    @elseif($question->type === 'textarea')
                        <div class="form-group">
                        <textarea class="form-control textarea" rows="3" data-id="{{ $question->id }}"
                                  aria-label="textarea">{{ Arr::exists($answers, $question->id) ? $answers[$question->id][0]['text'] : ''}}</textarea>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>
    <div class="modal fade" id="imageZoomModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
    <script>
        $('.imageZoom').click(function (e) {
            e.preventDefault();
            if($(this).attr('href')){
                $(this).attr('data-toggle', 'modal');
                $('#imageZoomModal').find('.modal-body').html(`<img src='${$(this).attr('href')}'>`)
            }else{
                $(this).attr('data-toggle', '')
            }

        })
    </script>

@endsection
