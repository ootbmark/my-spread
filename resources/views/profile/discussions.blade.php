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
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h5 class="w-100 font-medium">MY DISCUSSIONS</h5>
                        <hr>
                        @if(count($threads))
                            <div class="table-responsive mt-2 discussions-table">
                                <table class="table text-left">
                                    @foreach($threads as $thread)
                                        <tr>
                                            <td><a href="{{route('discussions.show', $thread->id)}}">{{$thread->subject}}</a></td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            {!! $threads->appends(request()->all())->links() !!}
                        @else
                            <p>You haven't added any discussions yet.</p>
                        @endif
                    </div>
                </div>
        </div>

    </div>
@endsection

@section('scripts')
 @include('profile._avatar_scripts')
@endsection

