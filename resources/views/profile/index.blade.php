@extends('layouts.app')
@section('add-css')
    <link href="/css/crop.css" rel="stylesheet">
    <link href="{{ mix('css/profile.css') }}" rel="stylesheet">
@endsection
@section('content')

    @include('profile._sidebar')

    <div class="profile-content">
      @include('profile._navbar')

        <div class="tab-content" id="pills-tabContent">
                <h5 class="w-100 font-medium">MY FAVORITES</h5>
                <hr>
                @if(count($favorites))
                <div class="table-responsive mt-2 discussions-table">
                    <table class="table">
                        <tr>
                            <th class="border-0">SUBJECT</th>
                            <th class="border-0">POSTED BY</th>
                            <th class="border-0">GROUP</th>
                            <th class="border-0">LAST ACTIVE</th>
                            <th class="border-0">REPLIES</th>
                        </tr>
                        @foreach($favorites as $thread)
                            <tr>
                                <td><a href="{{route('discussions.show', $thread->id)}}">{{$thread->subject}}</a></td>
                                <td><a href="{{route('users.show', $thread->user_id)}}">{{$thread->user->name}}</a></td>
                                <td><a href="{{route('groups.discussions', $thread->group_id)}}">{{$thread->group->name}}</a></td>
                                <td>{{$thread->updated_at->format('d F Y')}}</td>
                                <td>{{$thread->active_replies_count}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                    {!! $favorites->appends(request()->all())->links() !!}
                @else
                    <p>You haven't added any favorites yet.</p>
                @endif

                <div class="mt-4"><a href="{{route('discussions.check')}}" class="btn my-btn ml-auto text-uppercase">START NEW DISCUSSION</a></div>

        </div>

    </div>
@endsection

@section('scripts')
 @include('profile._avatar_scripts')
@endsection

