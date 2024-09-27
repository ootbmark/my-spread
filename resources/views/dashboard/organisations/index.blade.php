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
            <form action="{{route('dashboard.organisations.index')}}" id="dashboard-filter-form">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <select name="status" class="form-control w-auto mb-2 mr-3" onchange="$('#dashboard-filter-form').submit()">
                        <option value="">Choose Status</option>
                        <option value="active" @if(request()->get('status') == 'active') selected @endif>Active</option>
                        <option value="new" @if(request()->get('status') == 'new') selected @endif>New</option>
                        <option value="deleted" @if(request()->get('status') == 'deleted') selected @endif>Deleted</option>
                    </select>
                    <div class="discussions-search position-relative flex-grow-1 mr-4 mb-2">
                        <select name="organisation_id" id="organisation_id" class="form-control"></select>
                    </div>
                    <a href="{{route('dashboard.organisations.create')}}" class="btn my-btn mb-2">Add organisation</a>
                </div>
            </form>

            <div class="table-responsive mt-5 discussions-table">
                <table class="table">
                    <tbody><tr>
                        <th class="border-0">@sortablelink('id', 'ID')</th>
                        <th class="border-0">@sortablelink('name', 'NAME')</th>
                        <th class="border-0">@sortablelink('created_at', 'JOINED DATE')</th>
                        <th class="border-0">STATUS</th>
                        <th class="border-0">WEBSITE</th>
                        <th class="border-0">@sortablelink('users_count', 'NUMBER OF ACTIVE MEMBERS')</th>
                        <th class="border-0">LOGO</th>
                        <th class="border-0">ACTIONS</th>
                    </tr>
                    @foreach($organisations as $organisation)
                        <tr>
                            <td><a href="{{route('organisations.show', $organisation->id)}}">{{$organisation->id}}</a></td>
                            <td><a href="{{route('organisations.show', $organisation->id)}}">{{$organisation->name}}</a></td>
                            <td>{{$organisation->created_at->format('d F Y')}}</td>
                            <td>{{$organisation->status}}</td>
                            <td><a href="{{$organisation->website}}" target="_blank">{{$organisation->website}}</a></td>
                            <td>{{$organisation->users_count}}</td>
                            <td><img src="{{$organisation->logo}}" alt="{{$organisation->name}}" width="32"></td>
                            <td class="action-buttons">
                                <a href="{{route('organisations.show', $organisation->id)}}" class="action-link action-link-blue" title="View"><i class="fa fa-eye"></i></a>
                                <a href="{{route('dashboard.organisations.edit', $organisation->id)}}" class="action-link action-link-green" title="Edit"><i class="fa fa-pencil"></i></a>
                                @if($organisation->isFallback())
                                <a class="action-link" title="Remove" onclick="return alert('Can not delete fallback organisation')"><i class="fa fa-trash"></i></a>
                                @else
                                <a class="action-link action-link-red" title="Remove" onclick="$(this).next().submit()"><i class="fa fa-trash"></i></a>
                                <form action="{{route('dashboard.organisations.destroy', $organisation->id)}}" method="POST" onsubmit="return confirm('Are you sure?')">
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
            {{$organisations->appends(request()->all())->links()}}
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $('#organisation_id').select2({
            ajax: {
                url: '{{route('organisations.data')}}',
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            }
        });

        $('#organisation_id').change(function (){
            window.location.href = '/organisations/' + $(this).find(':selected').val();
        });
    </script>
    @include('profile._avatar_scripts')
@endsection

