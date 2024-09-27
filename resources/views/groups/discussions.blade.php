@extends('layouts.app')
@section('content')

    <section class="discussions">
            <div class="discussions-container">
                <div class="breadcrumbs_header mb-5">
                    <a href="{{route('discussions.index')}}">Discussion Forum</a> &gt;
                    {{$group->name}}
                </div>
                <div class="d-flex flex-wrap align-items-center">
                    <div>
                        <h1 class="title-h1 mb-0">ALL DISCUSSIONS IN {{strtoupper($group->name)}}</h1>
                        <p>{{$group->description}}</p>
                    </div>
                    <a href="{{route('discussions.index')}}?unanswered=1" class="btn my-btn ml-auto text-uppercase">Unanswered</a>
                </div>
            </div>

            <div class="discussions-container">
                <form action="{{route('discussions.index')}}">
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
                            <th class="border-0">@sortablelink('replies_count', 'REPLIES')</th>
                        </tr>
                        @foreach($threads as $thread)
                        <tr>
                            <td><a href="{{route('discussions.show', $thread->id)}}">{{$thread->subject}}</a></td>
                            <td><a href="{{route('users.show', $thread->user_id)}}">{{$thread->user->name}}</a></td>
                            <td><a href="{{route('groups.discussions', $thread->group_id)}}">{{$thread->group->name}}</a></td>
                            <td>{{$thread->updated_at->format('d F Y')}}</td>
                            <td>{{$thread->replies_count}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                {!! $threads->appends(request()->all())->links() !!}
            </div>
    </section>


@endsection

