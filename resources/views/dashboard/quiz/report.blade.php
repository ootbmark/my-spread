@extends('layouts.app')
@section('add-css')
    {{--    <link href="/metronic/css/bundle2.css" rel="stylesheet" type="text/css" />--}}
    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <link href="/css/crop.css" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="/metronic/css/plugins/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <link href="/metronic/css/style.bundle.css" rel="stylesheet" type="text/css">
    <link href="/metronic/css/custom.css" rel="stylesheet" type="text/css">
    <link href="/metronic/css/plugins/plugins.bundle.css" rel="stylesheet" type="text/css">
    <link href="{{ mix('css/profile.css') }}" rel="stylesheet">
    <style>
        table td {
            padding: 15px 0px;
        }

        .kt_portlet__bottom {
            border-top: 1px solid #ebedf2;
            padding: 25px;
        }

        .statuss {
            width: 50%;
        }

        @media (max-width: 700px) {
            .statuss {
                width: 100%;
            }

        }

        body, html{
            font-size: 18px!important;
            line-height: 1.25!important;
            font-family: WebFont,sans-serif,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji!important;
        }
        html{
            font-size: 16px!important;
        }
    </style>

@endsection

@section('content')
    @include('profile._sidebar')

    <div class="profile-content">
        @include('dashboard._forms_navbar')

        <div class="discussions-container ml-0 mt-4 p-0">
            <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                <div class="kt-subheader  kt-grid__item" id="kt_subheader">
                    <div class="kt-container  kt-container--fluid ">
                        <div class="kt-subheader__main">
                            <h3 class="kt-subheader__title">{{__('Report')}}</h3>
                            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                            <div class="kt-subheader__breadcrumbs">

                                <a href="{{route('quiz-reports', $quiz_id)}}" class="kt-subheader__breadcrumbs-home"><i
                                        class="flaticon2-back"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <a href="{{route('quiz-reports', $quiz_id)}}" class="kt-subheader__breadcrumbs-link">
                                    {{__('Reports')}}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="kt-portlet kt-portlet--mobile">
                                <div class="kt-portlet__head kt-portlet__head--lg align-items-center">
                                    <div class="kt-portlet__head-label w-100">
                                        <h3 class="kt-portlet__head-title">
                                            {{__('Report')}}
                                        </h3>
                                        <div class="statuss d-flex" style="justify-content: space-evenly; ">
                                            @if($quiz_reports->status)
                                                <h3 class="kt-portlet__head-title text-center" style="font-size: 13px">
                                                    <div class="mb-2" style="font-size: 16px">Value</div>
                                                    {{ $quiz_reports->status ?? '' }}
                                                </h3>
                                            @endif
                                            @if($quiz_reports->status_effort)
                                                <h3 class="kt-portlet__head-title text-center" style="font-size: 13px">
                                                    <div class="mb-2" style="font-size: 16px">Effort</div>
                                                    {{ $quiz_reports->status_effort ?? '' }}
                                                </h3>
                                            @endif
                                            @if($quiz_reports->report_status || $quiz_reports->report_status === 0)
                                                <h3 class="kt-portlet__head-title text-center" style="font-size: 13px">
                                                    <div class="mb-2" style="font-size: 16px">Status</div>
                                                    {{ config()->get('report_status')[$quiz_reports->report_status] ?? '' }}
                                                </h3>
                                            @endif
                                        </div>

                                    </div>
                                    <div>
                                        <a href="{{route('quiz-answer.edit', $quiz_reports->id)}}" class="btn btn-sm btn-clean btn-icon btn-icon-md" target="_blank" title="{{__('Edit')}}">
                                            <i class="flaticon-edit"></i>
                                        </a>
                                    </div>

                                </div>

                                <div class="kt-portlet__body">
                                    @include('flash::message')
                                    <table class="kt-datatable__table">
                                        <thead>
                                        <tr>
                                            <th style="min-width: 200px;">{{ __('quiz.Question') }}</th>
                                            <th>{{ __('quiz.Answer') }}</th>
                                            {{--                                    <th>{{ __('quiz.Is right') }}</th>--}}
                                        </tr>
                                        </thead>

                                        @foreach($quiz_answers as $quiz_answer)
                                            @php
                                                if ($quiz_answer->question){
                                                    $question_data = $quiz_answer->question;
                                                    $answer_data = $quiz_answer->answer;

                                                    $question = '';
                                                    $answer = '';
                                                    $is_right = 'false';

                                                    if(!$question_data->file_type)
                                                    {
                                                        $question = $question_data->title;
                                                    }

                                                    if($question_data->file_type === 'image')
                                                    {
                                                        $question = '<img height="80" src="/storage/' . $question_data->file .'" alt="image">';
                                                    }

                                                    if($question_data->file_type === 'image_url')
                                                    {
                                                        $question = '<img height="100" src="'. $question_data->url .'" alt="image">';
                                                    }

                                                    if($question_data->file_type === 'youtube')
                                                    {
                                                        $question = '<iframe height="100" src="https://www.youtube.com/embed/' .  $question_data->url . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                                                    }

                                                    if($question_data->file_type === 'video')
                                                    {
                                                        $question = '<video width="320" height="240" controls><source src="' . $question_data->url . '" type="video/mp4"></video>';
                                                    }

                                                    if(!is_null($answer_data))
                                                    {
                                                        if(!$answer_data->file_type)
                                                        {
                                                            $answer = $answer_data->title;
                                                        }

                                                        if($answer_data->file_type === 'image')
                                                        {
                                                            $answer = '<img height="80" src="/storage/'. $answer_data->file .'" alt="image">';
                                                        }

                                                        if($answer_data->is_right)
                                                        {
                                                            $is_right = 'true';
                                                        }
                                                    }else{
                                                        $answer = $quiz_answer->text;
                                                    }
                                                    if ($question_data->type === 'circling'){
                                                        $answer = '';
                                                        foreach ($quiz_answer->answers as $key => $item){
                                                            if (count($quiz_answer->answers) === 1){
                                                                $answer .= "<b> {$item->title}:  </b>";
                                                            }else{
                                                                if (!$key) {
                                                                $answer .= "<b> {$item->title} </b>";
                                                                }else if ($key == count($quiz_answer->answers)-1) {
                                                                     $answer .= " / <b> {$item->title}:  </b>";
                                                                }else{
                                                                    $answer .= " / <b> {$item->title} </b>";
                                                                }
                                                            }

                                                        }

                                                         $answer .= $quiz_answer->text;
                                                    }
                                                }
                                            @endphp
                                            <tr>
                                                <td style="padding-right: 73px;
    max-width: 60px;
    word-break: break-all;">{!! $question ?? '' !!}</td>
                                                <td>{!! $answer ?? '' !!}</td>
                                                {{--                                        <td>{{ __('quiz.'.$is_right) }}</td>--}}
                                            </tr>
                                        @endforeach
                                    </table>

                                </div>
                                <div class="bg-blue kt_portlet__bottom d-flex justify-content-between">
                                    <div>
                                        <h5>
                                            Oil Co Focal Point:
                                        </h5>
                                        {{ $quiz_reports->focal_point }}
                                    </div>
                                    <div>
                                        <h5>
                                            Actual Actionee:
                                        </h5>
                                        {{ $quiz_reports->action_party }}
                                    </div>
                                    <div>
                                        <h5>
                                            And by when:
                                        </h5>
                                        {{ $quiz_reports->target_date }}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection




