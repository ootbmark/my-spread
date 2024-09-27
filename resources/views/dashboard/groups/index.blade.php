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
            <form action="{{route('dashboard.groups.index')}}" id="dashboard-filter-form">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <select name="status" class="form-control w-auto mb-2 mr-3" onchange="$('#dashboard-filter-form').submit()">
                        <option value="">Choose Status</option>
                        <option value="active" @if(request()->get('status') == 'active') selected @endif>Active</option>
                        <option value="deleted" @if(request()->get('status') == 'deleted') selected @endif>Deleted</option>
                    </select>
                    <div class="discussions-search position-relative flex-grow-1 mr-4 mb-2">
                        <select name="group_id" id="group_id" class="form-control"></select>
                    </div>
                    <a href="{{route('dashboard.groups.create')}}" class="btn my-btn mb-2">Add group</a>
                </div>
            </form>

            <div class="table-responsive mt-5 discussions-table">
                <table class="table">
                    <tbody><tr>
                        <th class="border-0">@sortablelink('id', 'ID')</th>
                        <th class="border-0">@sortablelink('name', 'GROUPS')</th>
                        <th class="border-0">LAST POST</th>
                        <th class="border-0">STATUS</th>
                        <th class="border-0">@sortablelink('threads_count', 'DISCUSSIONS')</th>
                        <th class="border-0">@sortablelink('replies_count', 'RESPONSES')</th>
                        <th class="border-0">ACTIONS</th>
                    </tr>
                    @foreach($groups as $group)
                        <tr>
                            <td><a href="{{route('groups.discussions', $group->id)}}">{{$group->id}}</a></td>
                            <td>
                                <a href="{{route('groups.discussions', $group->id)}}">{{$group->name}}</a>
                                <br>
                                <span class="mt-2 mb-2 d-inline-block">
                                    {{$group->description}}
                                </span>
                                @if(count($group->groups))
                                    <h5><b>Sub group(s)</b></h5>
                                @endif
                                @foreach($group->groups as $item)
                                    <a href="{{route('groups.discussions', $item->id)}}" class="mr-3 mb-2 d-inline-block"><i class="fa fa-folder-open fa-lg mr-2" aria-hidden="true"></i>{{$item->name}}</a>
                                @endforeach
                            </td>
                            <td>@if($group->last_thread)<a href="{{route('discussions.show', $group->last_thread->id)}}">{{$group->last_thread->subject}}</a>@endif</td>
                            <td>{{$group->status}}</td>
                            <td>{{$group->threads_count}}</td>
                            <td>{{$group->replies_count}}</td>
                            <td class="action-buttons">
                                <a href="{{route('groups.discussions', $group->id)}}" class="action-link action-link-blue" title="View"><i class="fa fa-eye"></i></a>
                                <a href="{{route('dashboard.groups.edit', $group->id)}}" class="action-link action-link-green" title="Edit"><i class="fa fa-pencil"></i></a>
                                <a href="#" class="action-link action-link-red" title="Remove" onclick="$(this).next().submit()"><i class="fa fa-trash"></i></a>
                                <form action="{{route('dashboard.groups.destroy', $group->id)}}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{$groups->appends(request()->all())->links()}}
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $('#group_id').select2({
            ajax: {
                url: '{{route('groups.data')}}',
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            }
        });

        $('#group_id').change(function (){
            window.location.href = '/group-discussions/' + $(this).find(':selected').val();
        });
    </script>
    @include('profile._avatar_scripts')
@endsection

