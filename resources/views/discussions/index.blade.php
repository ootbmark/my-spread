@extends('layouts.app')
@section('content')

    <section class="discussions">
            <div class="discussions-container">
                @if(request()->get('unanswered'))
                 <p>These discussions still need answers. If you know, kindly respond. It may become useful again to someone in need!</p>
                    <div class="d-flex flex-wrap align-items-center">
                        <h1 class="title-h1 mb-0">DISCUSSIONS</h1>
                        <a href="{{route('discussions.index')}}" class="btn my-btn ml-auto text-uppercase">All Discussions</a>
                    </div>
                @else
                <div class="d-flex flex-wrap align-items-center">
                    <h1 class="title-h1 mb-0">DISCUSSIONS</h1>
                    <a href="{{route('discussions.index')}}?unanswered=1" class="btn my-btn ml-auto text-uppercase">Unanswered</a>
                </div>
                @endif
            </div>

            <div class="discussions-container">
                <form action="{{route('discussions.index')}}" class="d-flex">
                    @if(request()->get('unanswered'))
                        <input type="hidden" name="unanswered" value="1">
                    @endif
                    <div class="discussions-search position-relative">
                        <input type="search" placeholder="Discussion Subject" name="search" value="{{request()->get('search')}}" aria-label="search" class="form-control">
                        <button type="submit" aria-label="search" class="btn"><span class="search-toggle"></span></button>
                    </div>
                </form>

                <div class="table-responsive mt-5 discussions-table">
                    <table class="table">
                        <tr>
                            <th class="border-0">@sortablelink('subject', 'SUBJECT')</th>
                            <th class="border-0">@sortablelink('user', 'POSTED BY')</th>
                            <th class="border-0">@sortablelink('group', 'GROUP')</th>
                            <th class="border-0">@sortablelink('updated_at', 'LAST ACTIVE')</th>
                            <th class="border-0">@sortablelink('active_replies_count', 'REPLIES')</th>
                        </tr>
                        @foreach($threads as $thread)
                        <tr>
                            <td><a href="{{route('discussions.show', $thread->id)}}">{{$thread->subject}}</a></td>
                            <td><a href="{{route('users.show', $thread->user_id)}}">{{$thread->user->name ?? $thread->user_id}}</a></td>
                            <td><a href="{{route('groups.discussions', $thread->group_id)}}">{{$thread->group->name}}</a></td>
                            <td>{{$thread->updated_at->format('d F Y')}}</td>
                            <td>{{$thread->active_replies_count}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                {!! $threads->appends(request()->all())->links() !!}
            </div>
    </section>


@endsection

