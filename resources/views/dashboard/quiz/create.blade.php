@extends('layouts.app')
@section('add-css')
    {{--    <link href="/metronic/css/bundle2.css" rel="stylesheet" type="text/css" />--}}
    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
    <link href="/css/crop.css" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="/metronic/css/plugins/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <link href="/metronic/css/style.bundle.css" rel="stylesheet" type="text/css">
    <link href="/metronic/css/custom.css" rel="stylesheet" type="text/css">
    <link href="/metronic/css/plugins/plugins.bundle.css" rel="stylesheet" type="text/css">
    <link href="{{ mix('css/profile.css') }}" rel="stylesheet">
    <style>
        .kt-footer{
            margin-top: auto;
        }

        .col-xl-10{
            flex: 0 0 100%!important;
            max-width: 100%!important;
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
            <div id="quiz">
                <link href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css" rel="stylesheet">
                <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                    <div class="kt-subheader  kt-grid__item" id="kt_subheader">
                        <div class="kt-container  kt-container--fluid align-items-center">
                            <div class="kt-subheader__main">
                                <h3 class="kt-subheader__title">Create New Form</h3>

                                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                                <a href="{{route('forms.index')}}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-back"></i></a>
                            </div>
                        </div>
                    </div>

                    <quiz-main></quiz-main>

                </div>
            </div>
        </div>
    </div>



@endsection

@section('scripts')
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('/js/quiz.js') }}"></script>
@stop
