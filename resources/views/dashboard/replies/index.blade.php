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
            <form action="{{route('dashboard.replies.index')}}" id="dashboard-filter-form">
                <div class="d-flex justify-content-between flex-wrap">
                    <select name="status" class="form-control w-auto mr-3 mb-2" onchange="$('#dashboard-filter-form').submit()">
                        <option value="">Choose Status</option>
                        <option value="active" @if(request()->get('status') == 'active') selected @endif>Active</option>
                        <option value="new" @if(request()->get('status') == 'new') selected @endif>New</option>
                        <option value="parked" @if(request()->get('status') == 'parked') selected @endif>Parked</option>
                        <option value="deleted" @if(request()->get('status') == 'deleted') selected @endif>Deleted</option>
                    </select>
                    <div class="discussions-search position-relative flex-grow-1 mb-2">
                        <input type="search" placeholder="Search here" name="search" value="{{request()->get('search')}}" aria-label="search" class="form-control">
                        <button type="submit" aria-label="search" class="btn"><span class="search-toggle"></span></button>
                    </div>
                </div>
            </form>

            <div class="table-responsive mt-5 discussions-table">
                <table class="table">
                    <tbody><tr>
                        <th class="border-0">@sortablelink('id', 'ID')</th>
                        <th class="border-0">ANSWER</th>
                        <th class="border-0">DISCUSSION</th>
                        <th class="border-0">STATUS</th>
                        <th class="border-0">@sortablelink('created_at', 'CREATED DATE')</th>
                        <th class="border-0">ACTIONS</th>
                    </tr>
                    @foreach($replies as $reply)
                        <tr>
                            <td>{{$reply->id}}</td>
                            <td>{!! substr(strip_tags($reply->body), 0, 60) !!}</td>
                            <td><a href="{{route('discussions.show', $reply->thread->id)}}">{{$reply->thread->subject}}</a></td>
                            <td>{{$reply->status}}</td>
                            <td>{{$reply->created_at->format('d F Y')}}</td>
                            <td class="action-buttons">
                                <a href="{{route('discussions.show', $reply->thread->id)}}" class="action-link action-link-blue" title="View"><i class="fa fa-eye"></i></a>
                                <a href="{{route('dashboard.replies.edit', $reply->id)}}" class="action-link action-link-green" title="Edit"><i class="fa fa-pencil"></i></a>
                                <a href="#" class="action-link action-link-red" title="Remove" onclick="$(this).next().submit()"><i class="fa fa-trash"></i></a>
                                <form action="{{route('dashboard.replies.destroy', $reply->id)}}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{$replies->appends(request()->all())->links()}}
        </div>
    </div>

@endsection

@section('scripts')
    @include('profile._avatar_scripts')
@endsection

