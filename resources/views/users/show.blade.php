@extends('layouts.app')
@section('add-css')
    <link href="{{ mix('css/user-show.css') }}" rel="stylesheet">
@endsection
@section('content')

    @if(request()->type == 'find')
        @include('components.modals.contact-user')
    @endif
    <div class="my-container bg-white pt-3 mt-4 mb-5 pb-5">
        <div class="main-section d-flex flex-wrap pb-4 border-bottom">
            <div class="forum-change-links d-flex align-items-center w-100">
                @if(auth()->user()->role == 'admin')
                    <a href="{{route('dashboard.users.edit', $user->id)}}"><i class="fa fa-pencil"></i>Edit</a>
                @endif
            </div>
            <figure class="d-flex member-figure">
                <img src="{{$user->image}}" alt="{{$user->name}}" width="150">

                <figcaption>
                    <h4 class="font-medium">{{$user->name}}</h4>
                    <p class="mb-1">{{$user->job_title}}</p>
                    <p class="mb-1">{{$user->location}}</p>
                    <p class="mb-1">{{$user->organisation->name}}</p>
                    @if(request()->type == 'find')
                        <button class="btn btn-purple text-white" data-toggle="modal"
                                data-target="#contactModal">{{__("Contact $user->first_name")}}</button>
                    @else
                        @if($user->linkedin_url)
                            <p class="mb-1"><a href="{{$user->linkedin_url}}" target="_blank">Linkedin profile</a></p>
                        @endif
                    @endif
                </figcaption>
            </figure>
            <div class="total-block d-flex w-100">
                <div class="total-item mr-4">
                    Discussions:<span class="ml-2">{{$user->threads()->active()->count()}}</span>
                </div>
                <div class="total-item mr-4">
                    Replies:<span class="ml-2">{{$user->replies()->active()->count()}}</span>
                </div>
                @if(request()->type != 'find')
                    <div class="total-item mr-4">
                        Member since:<span class="ml-2">{{$user->created_at->format('d F Y')}}</span>
                    </div>
                @endif
            </div>
        </div>
        <div class="w-100 mt-5 row">

            <div class="col-12 col-sm-6">
                <h3 class="title-h3">{{strtoupper($user->first_name)}}'S DISCUSSION</h3>
                @foreach($threads as $thread)
                    <a href="{{route('discussions.show', $thread->id)}}" class="link-1 d-flex justify-content-between">
                        {{$thread->subject}}
                    </a>
                @endforeach
            </div>
            <div class="col-12 col-sm-6">
                <h3 class="title-h3">{{strtoupper($user->first_name)}} REPLIES IN</h3>
                @foreach($replies as $reply)
                    @if($reply->thread)
                        <a href="{{route('discussions.show', $reply->thread_id)}}"
                           class="link-1 d-flex justify-content-between">
                            {{$reply->thread->subject}}
                        </a>
                    @endif
                @endforeach
            </div>

        </div>
    </div>
@endsection
