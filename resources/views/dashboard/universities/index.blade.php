@extends('layouts.app')
@section('add-css')
    <link href="/css/crop.css" rel="stylesheet">
    <link href="{{ mix('css/profile.css') }}" rel="stylesheet">
@endsection
@section('content')

    @include('profile._sidebar')

    <div class="profile-content">
        @include('dashboard._navbar')

        <div class="discussions-container ml-0 mt-4">
            <form action="{{route('dashboard.universities.index')}}" id="dashboard-filter-form">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <select name="status" class="form-control w-auto mb-2 mr-3" onchange="$('#dashboard-filter-form').submit()">
                        <option value="">Choose Status</option>
                        <option value="active" @if(request()->get('status') == 'active') selected @endif>Active</option>
                        <option value="new" @if(request()->get('status') == 'new') selected @endif>New</option>
                        <option value="deleted" @if(request()->get('status') == 'deleted') selected @endif>Deleted</option>
                    </select>
                    <div class="discussions-search position-relative flex-grow-1 mr-4 mb-2">
                        <select name="university_id" id="university_id" class="form-control"></select>
                    </div>
                    <a href="{{route('dashboard.universities.create')}}" class="btn my-btn mb-2">Add university</a>
                </div>
            </form>

            <div class="table-responsive mt-5 discussions-table">
                <table class="table">
                    <tbody><tr>
                        <th class="border-0">@sortablelink('id', 'ID')</th>
                        <th class="border-0">@sortablelink('name', 'NAME')</th>
                        <th class="border-0">@sortablelink('status', 'STATUS')</th>
                        <th class="border-0">@sortablelink('created_at', 'CREATED AT')</th>
                        <th class="border-0">ACTIONS</th>
                    </tr>
                    @foreach($universities as $university)
                        <tr>
                            <td>{{$university->id}}</td>
                            <td>{{$university->name}}</a></td>
                            <td>{{$university->status}}</a></td>
                            <td>{{$university->created_at->format('d F Y')}}</td>
                            <td class="action-buttons">
                                <a href="{{route('dashboard.universities.edit', $university->id)}}" class="action-link action-link-green" title="Edit"><i class="fa fa-pencil"></i></a>
                                @if($university->isFallback())
                                <a class="action-link" title="Remove" onclick="return alert('Can not delete fallback university')"><i class="fa fa-trash"></i></a>
                                @else
                                <a class="action-link action-link-red" title="Remove" onclick="$(this).next().submit()"><i class="fa fa-trash"></i></a>
                                <form action="{{route('dashboard.universities.destroy', $university->id)}}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{$universities->appends(request()->all())->links()}}
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $('#university_id').select2({
            ajax: {
                url: '{{route('universities.data')}}',
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            }
        });

        $('#university_id').change(function (){
            window.location.href = '/dashboard/universities/' + $(this).find(':selected').val() + '/edit';
        });
    </script>
    @include('profile._avatar_scripts')
@endsection

