@extends('layouts.app')

@section('content')

    @if(!request()->get('search'))
    <section class="discussions">
        <h1 class="text-center title-h2 mb-4">START NEW DISCUSSION</h1>

        <div class="discussions-container mb-1">
            <div class="d-flex flex-wrap align-items-start">
                <h2 class="title-h1 mb-0">CHECK WHETHER YOUR SUBJECT IS ALREADY DISCUSSED IN SPREAD</h2>
            </div>
        </div>

        <div class="discussions-container">
            <form action="{{route('discussions.check')}}">
                <small class="form-text text-muted mb-1">Enter the discussion title/subject
                    <span class="text-red ml-1">*</span>
                </small>
                <input type="text" name="search" class="form-control mb-3" aria-label="check">
                <button type="submit" class="btn my-btn text-uppercase mw-200">Submit</button>
            </form>
        </div>
    </section>

  @else
    <section class="discussions">
        <h1 class="text-center title-h2 mb-4">START A NEW DISCUSSION</h1>
        <div class="discussions-container">
            <p class="mb-0"><b>Do any of these match?</b>(view the details of the discussions listed below by hovering over the titles)</p>
        </div>
        <div class="discussions-container mb-1">
            <div class="d-flex flex-wrap align-items-start">
                <h2 class="title-h1 mb-0">SEARCH RESULTS</h2>
                <div class="ml-auto d-flex flex-column align-items-stretch">
                    <a href="{{route('discussions.create')}}" class="btn my-btn mb-2 text-uppercase">I would like to start a new discussion</a>
                    <a href="{{route('discussions.check')}}" class="btn my-btn text-uppercase">Refine the subject and search again</a>
                </div>
            </div>
        </div>

        <div class="discussions-container">
            <div class="table-responsive mt-5 discussions-table">
                <table class="table">
                    <tbody>
                    <tr>
                        <th class="border-0">@sortablelink('subject', 'SUBJECT')</th>
                        <th class="border-0">@sortablelink('user', 'POSTED BY')</th>
                        <th class="border-0">@sortablelink('group', 'GROUP')</th>
                        <th class="border-0">@sortablelink('updated_at', 'LAST ACTIVE')</th>
                        <th class="border-0">@sortablelink('replies_count', 'REPLIES')</th>
                    </tr>
                    <tr>
                    @foreach($threads as $thread)
                        <tr>
                            <td><a href="{{route('discussions.show', $thread->id)}}"  data-toggle="tooltip" data-placement="right" title="{{$thread->subject}}">{{$thread->subject}}</a></td>
                            <td><a href="{{route('users.show', $thread->user_id)}}">{{$thread->user->name}}</a></td>
                            <td><a href="{{route('groups.discussions', $thread->group_id)}}">{{$thread->group->name}}</a></td>
                            <td>{{$thread->updated_at->format('d F Y')}}</td>
                            <td>{{$thread->replies_count}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    @endif
@endsection

