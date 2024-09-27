@extends('layouts.app')
@section('add-css')
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
        .select2 {
            display: block;
        }
        .modal .modal-content .modal-header .close:before{
            display: none;
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
                            <h3 class="kt-subheader__title">{{__('Companies')}}</h3>
                            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                            <div class="kt-subheader__breadcrumbs">

                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <a href="{{route('companies.index')}}" class="kt-subheader__breadcrumbs-link">
                                    {{__('Companies')}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="kt-portlet kt-portlet--mobile">
                                <div class="kt-portlet__head kt-portlet__head--lg">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title">
                                            {{__('Companies')}}
                                        </h3>
                                    </div>
                                    <div class="kt-portlet__head-toolbar">
                                        <div class="kt-portlet__head-wrapper">
                                            <div class="kt-portlet__head-actions">
                                                <a href="{{route('companies.create')}}"
                                                   class="btn btn-brand btn-elevate btn-icon-sm">
                                                    <i class="flaticon2-plus"></i>
                                                    {{__('Create New Company')}}
                                                </a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="kt-portlet__body">
                                    @include('flash::message')
                                    <div class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded">
                                        <table class="kt-datatable__table dataTable">
                                            <thead>
                                            <tr>
                                                <th>{{__('Name')}}</th>
                                                <th>{{__('Created At')}}</th>
                                                <th>{{__('Actions')}}</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="restriction-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                 aria-modal="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="kt-portlet__body">
                                <h4>{{__('You reached limit for creating instructors')}}</h4>
                                <p>{{__('Please upgrade your subscription plan for more ability')}}</p>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="/metronic/js/plugins/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
    <script>
        $('.dataTable').DataTable({
            language: {
                search: '{{__('Search')}}',
                processing: '{{__('Processing')}}',
                lengthMenu: '{{__('Show')}}' + " _MENU_",
                info: '{{__('Showing')}}' + " _START_ " + '{{__('to')}}' + " _END_ " + '{{__('of')}}' + " _TOTAL_ " + '{{__('entries')}}',
                zeroRecords: '{{__('No data available in table')}}'
            },
            serverSide: true,
            processing: true,
            responsive: true,
            aaSorting: [[0, "desc"]],
            ajax: "{{ route('companies.dataTable')}}",
            columns: [
                {name: 'name'},
                {
                    name: 'created_at',
                    render: function (name, type, row) {
                        if (name) {
                            return moment(name).format('DD MMM YYYY')
                        }
                        return '';
                    }
                },
                {name: 'actions', orderable: false, searchable: false},
            ],
        });

        setTimeout(function () {
            $('.alert').fadeOut('slow');
        }, 10000);
    </script>
    @include('profile._avatar_scripts')
@endsection


