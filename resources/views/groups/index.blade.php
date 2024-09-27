@extends('layouts.app')
@section('content')
    <section class="discussions">
        <div class="discussions-container">
            <p>Unsure of selecting a group for placing your discussion? Post it under the <a href="{{route('groups.discussions', $general_group_id)}}">General discussions</a> and we will do the needful.</p>

            <div class="d-flex flex-wrap align-items-center">
                <h1 class="title-h1 mb-0">GROUPS</h1>
            </div>
        </div>

        <div class="discussions-container">
            <form action="{{route('groups.index')}}">
                <div class="discussions-search position-relative">
                    <input type="search" placeholder="Group name" name="search" value="{{request()->get('search')}}" aria-label="search" class="form-control">
                    <button type="submit" aria-label="search" class="btn"><span class="search-toggle"></span></button>
                </div>
            </form>

            <div class="table-responsive mt-5 discussions-table">
                <table class="table">
                    <tr>
                        <th class="border-0">@sortablelink('name', 'GROUPS')</th>
                        <th class="border-0">LAST POST</th>
                        <th class="border-0">@sortablelink('threads_count', 'DISCUSSIONS')</th>
                        <th class="border-0">@sortablelink('replies_count', 'RESPONSES')</th>
                    </tr>
                    @foreach($groups as $group)
                        <tr>
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
                            <td>
                                @if($group->last_thread)
                                    <a href="{{route('discussions.show', $group->last_thread->id)}}">{{$group->last_thread->subject}}</a>
                                @endif
                            </td>
                            <td>{{$group->threads_count}}</a></td>
                            <td>{{$group->replies_count}}</a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
            {!! $groups->appends(request()->all())->links() !!}
        </div>
    </section>
@endsection

