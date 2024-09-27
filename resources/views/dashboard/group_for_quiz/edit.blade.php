@extends('layouts.app')
@section('add-css')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
            integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
            crossorigin="anonymous"></script>



    <link href="/css/crop.css" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="/metronic/css/plugins/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <link href="/metronic/css/style.bundle.css" rel="stylesheet" type="text/css">
    <link href="/metronic/css/custom.css" rel="stylesheet" type="text/css">
    <link href="/metronic/css/plugins/plugins.bundle.css" rel="stylesheet" type="text/css">
    <link href="{{ mix('css/profile.css') }}" rel="stylesheet">
    <style>
        .select2 {
            display: block;
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
                    <div class="kt-container  kt-container--fluid align-items-center">
                        <div class="kt-subheader__main">
                            <h3 class="kt-subheader__title">{{__('Groups For Form')}}</h3>
                            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                            <div class="kt-subheader__breadcrumbs">

                                <a href="{{route('groups-for-quiz.index')}}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-back"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <a href="{{route('groups-for-quiz.index')}}" class="kt-subheader__breadcrumbs-link">
                                    {{__('Groups For Form')}}</a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <a href="{{route('groups-for-quiz.edit', $group->id)}}" class="kt-subheader__breadcrumbs-link">
                                    {{__('Edit Group')}} - {{$group->id}} </a>
                            </div>
                        </div>
                        <div>
{{--                            <a href="" class="btn btn-secondary j_return_back">{{__('Cancel')}}</a>--}}
                            <button type="submit" class="btn btn-primary" id="object-form-confirm">{{__('Update')}}</button>
                        </div>
                    </div>
                </div>

                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="kt-portlet">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title">
                                            {{__('Edit Group')}} - {{$group->id}}
                                        </h3>
                                    </div>
                                </div>
                                {!! Form::model($group, [
                                 'method' => 'PATCH',
                                 'files' => true,
                                 'id' => 'object-form',
                                 'class' => 'kt-form kt-form--label-right',
                                 'url' => route('groups-for-quiz.update',$group->id),
                               ]) !!}

                                @csrf
                                @include('dashboard.group_for_quiz.form')

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
        $('#object-form-confirm').click(function () {
            $(this).attr('disabled', true);
            $('#object-form').submit();
        });

        setTimeout(function () {
            $('.alert').fadeOut('slow');
        }, 10000);
    </script>
@stop






