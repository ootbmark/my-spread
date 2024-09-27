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

        #change_list_modal {
            color: black;
        }

        #change_list_modal .title, #change_list_modal .change-list-label {
            font-weight: bold;
        }
    </style>

@endsection

@section('content')
    @include('profile._sidebar')

    <div class="profile-content">
        @include('dashboard._forms_navbar')

        <div class="discussions-container ml-0 mt-4 p-0">
            <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                <!-- Modal -->
                <div class="modal fade" tabindex="-1" id="change_list_modal">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Change List</h5>
                            </div>
                            <div class="modal-body d-flex flex-row justify-content-between w-100">
                                <div class="d-flex flex-column w-100">
                                    <div class="title mb-2 d-flex flex-row justify-content-between">
                                        <div class="title w-50">Before</div>
                                        <div class="title w-50">After</div>
                                    </div>
                                    <div class="change-list-container d-flex flex-column" id="change_list"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="kt-subheader  kt-grid__item" id="kt_subheader">
                    <div class="kt-container  kt-container--fluid ">
                        <div class="kt-subheader__main">
                            <h3 class="kt-subheader__title">{{__('Archive')}}</h3>
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
                                            {{__('Archive')}}
                                        </h3>
                                    </div>
                                </div>

                                <div class="kt-portlet__body">
                                    @include('flash::message')
                                    <div class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded">
                                        <table class="kt-datatable__table dataTable">
                                            <thead>
                                            <tr>
                                                <th>{{__('Scribe')}}</th>
                                                <th>{{__('Modified Date')}}</th>
                                                <th>{{__('Company')}}</th>
                                                <th>{{__('Workshop')}}</th>
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
        </div>
    </div>



@endsection

@section('scripts')


    <script src="/metronic/js/plugins/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
    <script>
        const apiUrl = "{{ $formId === null ? route('archive.datatable') : route('archive_by_form.datatable', $formId) }}";
        const table = $('.dataTable').DataTable({
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
            ajax: apiUrl,
            fnDrawCallback: function() {

                $('.show_change_list_modal').on('click', function (e) {
                    $('#change_list_modal').modal('show');
                    const changeListContainer = $('#change_list');
                    changeListContainer.empty();
                    const id = e.currentTarget.dataset.id;
                    let url = "{{ route('quiz.get.change-list', '%report_id%') }}";
                    url = url.replace('%report_id%', id);
                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            for (const changeData of data) {
                                changeListContainer.append(`
                                <div class="mb-2 d-flex flex-row justify-content-between">
                                    <div class="d-flex flex-column mb-2 w-50">
                                        <div class="change-list-label">Field Label: ${changeData.label}</div>
                                        <div>Field Entry: ${changeData.before}</div>
                                    </div>
                                    <div class="d-flex flex-column mb-2 w-50">
                                        <div class="change-list-label">Field Label: ${changeData.label}</div>
                                        <div>Field Entry: ${changeData.after}</div>
                                    </div>
                                </div>
                                `);
                            }
                        });
                });
            },
            columns: [
                {data: 'name'},
                {
                    data: 'created_at',
                    render: function (name, type, row) {
                        if (name) {
                            return moment(name).format('DD MMM YYYY hh:mm:ss')
                        }
                        return '';
                    }
                },
                {data: 'company'},
                {data: 'quiz_title'},
                {data: 'actions', orderable: false, searchable: false}
            ],
        });
    </script>
@stop





