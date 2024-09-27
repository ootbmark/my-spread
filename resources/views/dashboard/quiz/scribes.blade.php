@extends('layouts.app')
@section('add-css')
    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>

    <link href="/css/crop.css" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="/metronic/css/plugins/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <link href="/metronic/css/style.bundle.css" rel="stylesheet" type="text/css">
    <link href="/metronic/css/custom.css" rel="stylesheet" type="text/css">
    <link href="/metronic/css/plugins/plugins.bundle.css" rel="stylesheet" type="text/css">
    <link href="{{ mix('css/profile.css') }}" rel="stylesheet">
    <style>
        .odd td:nth-child(4){
            white-space: nowrap;
            overflow: hidden;
            max-width: 150px;
            text-overflow: ellipsis;
        }
        .odd td:last-child{
            white-space: nowrap;

        }
        body, html{
            font-size: 18px!important;
            line-height: 1.25!important;
            font-family: WebFont,sans-serif,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji!important;
        }
        html{
            font-size: 16px!important;
        }

        .table-for-scribe {
            margin-left: 25px;
        }

        .scribe-toggle {
            padding: 8px;
            color: black;
            cursor: pointer;
        }

        .scribe-toggle i {
            transition: all 0.2s;
        }
        .scribe-toggle:not(.collapsed) i {
            -webkit-transform: rotate(90deg);
            -moz-transform: rotate(90deg);
            transform: rotate(90deg);
        }
        .dataTables_filter:not(.dataTables_filter--main) {
            display: none;
        }
        .scribe-search_label {
            padding: 5px;
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
                            <h3 class="kt-subheader__title">{{__('Scribes')}}</h3>
                            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                            <div class="kt-subheader__breadcrumbs">

                                <a href="{{route('forms.index')}}" class="kt-subheader__breadcrumbs-home"><i
                                        class="flaticon2-back"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <a href="{{route('forms.index')}}" class="kt-subheader__breadcrumbs-link">
                                    {{__('Forms')}}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="kt-portlet kt-portlet--mobile">
                                <div class="kt-portlet__head kt-portlet__head--lg">
                                    <div class="kt-portlet__head-label w-100 justify-content-between">
                                        <h3 class="kt-portlet__head-title">
                                            {{__('Scribes')}}
                                        </h3>
                                    </div>
                                </div>

                                <div id="accordion" class="kt-portlet__body">
                                    @include('flash::message')
                                    <div class="dataTables_wrapper row justify-content-end">
                                        <div class="dataTables_filter dataTables_filter--main mr-3">
                                            <select id="company-select">
                                                <option value="">Company</option>
                                                @foreach($companies as $company)
                                                    <option value="{{$company}}">{{$company}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="dataTables_filter dataTables_filter--main">
                                            <label class="scribe-search_label">
                                                {{__('Search')}}
                                                <input id="scribe-search" type="search" aria-controls="{{__('Search')}}">
                                            </label>
                                        </div>
                                    </div>
                                    @foreach($users as $scribe)
                                    <div data-toggle="collapse" data-target="#table_for_{{$scribe->id}}" aria-expanded="false"
                                         class="accordion-toggle scribe-toggle collapsed">
                                        <i class="fas fa-angle-right"></i>
                                        <span>{{$scribe->name}}</span>
                                        @if($scribe->role === 'admin')
                                        <span>({{__('Admin')}})</span>
                                        @else
                                        <span>({{$scribe->getAllowedQuizes()->get()->implode('title', ', ')}})</span>
                                        @endif
                                    </div>
                                    <div id="table_for_{{$scribe->id}}" data-scribe_id="{{$scribe->id}}" class="collapse table-for-scribe" data-parent="#accordion">
                                        <div class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded">
                                            <table class="kt-datatable__table dataTable">
                                                <thead>
                                                <tr>
                                                    <th>{{__('Scribe')}}</th>
                                                    <th>{{__('Answered')}}</th>
                                                    <th>{{__('Item')}}</th>
                                                    <th>{{__('Workshop')}}</th>
                                                    <th>{{__('Company')}}</th>
                                                    <th>{{__('Value')}}</th>
                                                    <th>{{__('Effort')}}</th>
                                                    <th>{{__('Status')}}</th>
                                                    <th>{{__('Actions')}}</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                {{$users->appends(request()->all())->links()}}
                            </div>
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
        var tables = {};
        $('.table-for-scribe').each(function (index) {
            const table = $(this).find('.dataTable');
            const id = $(this).attr('data-scribe_id');

            tables[id] = table.DataTable({
                    language: {
                        search: '{{__('Search')}}',
                        processing: '{{__('Processing')}}',
                        lengthMenu: '{{__('Show')}}' + " _MENU_",
                        info: '{{__('Showing')}}' + " _START_ " + '{{__('to')}}' + " _END_ " + '{{__('of')}}' + " _TOTAL_ " + '{{__('entries')}}',
                        zeroRecords: '{{__('No data available in table')}}'
                    },
                    processing: true,
                    responsive: true,
                    aaSorting: [[0, "desc"]],
                    columns: [
                        {data: 'name'},
                        {data: 'questions_answers'},
                        {data: 'first_answer'},
                        {data: 'quiz_title'},
                        {data: 'company'},
                        {data: 'status'},
                        {data: 'status_effort'},
                        {
                            data: 'report_status',
                            orderable: false,
                            searchable: false,
                            render: function (data, type, row) {
                                let statuses = `
                        <select class="select_status" data-key="${row.report_status}" data-id="${row.id}">
                        <option value="">Choose status</option>
                            @foreach(config()->get('report_status') as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                                </select>
`;
                                return statuses
                            }
                        },
                        {data: 'actions', orderable: false, searchable: false}
                    ],

                });
        });
        $('.dataTable').on('draw.dt', function () {
            let selects = $('.select_status');
            selects.map((index, item) => {
                let key = $(item).data('key');
                $(item).find(`option[value="${key}"]`).prop('selected', true)
            });

            selects.on('change', function () {
                $.ajax({
                    url: `/dashboard/api/quiz-status/change/${$(this).data('id')}`,
                    method: 'patch',
                    data: {
                        key: $(this).val()
                    },
                    success: function (data) {
                        console.log(data)
                    }
                })
            })
        });
        $('.collapse').on('show.bs.collapse', function (e) {
            const userId = e.target.dataset.scribe_id;
            const url = new URL("{{ route('scribes.data')}}");
            url.search = `?user_id=${userId}`;

            tables[userId].ajax.url(url.toString()).load();
        })
        $('#scribe-search').on('input', function (e) {
            for (let key in tables) {
                tables[key].columns(2).search(e.target.value).draw();
            }
        });
        $('#company-select').on('change', function (e) {
            for (let key in tables) {
                tables[key].columns(4).search(e.target.value).draw();
            }
        });
    </script>
    @include('profile._avatar_scripts')
@endsection





