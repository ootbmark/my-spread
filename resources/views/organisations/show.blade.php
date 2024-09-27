@extends('layouts.app')
@section('content')

    <div class="my-container pt-5 mb-5">
        <div class="main-section d-flex flex-wrap pb-4">
            <div class="section-left w-100 edit-total-container">

                <h4 class="title-h3 d-flex justify-content-between align-items-center w-100">
                    {{$organisation->name}}
                    @if(auth()->user()->role == 'admin')
                        <a href="{{route('dashboard.organisations.edit', $organisation->id)}}" class="btn my-btn text-uppercase ml-2">Edit</a>
                    @endif
                </h4>

                <div class="d-flex align-items-start pt-2 flex-wrap my-powered mt-4">
                    <img src="{{$organisation->logo}}" alt="{{$organisation->name}}"  width="150">
                    <div class="my-powered-right">
                       <div class="table-responsive">
                           <table class="table total-table  mb-0">
                               <tr>
                                   <th class="font-medium">COMPANY NAME</th>
                                   <td class="font-bold">{{$organisation->name}}</td>
                               </tr>
                               <tr>
                                   <th class="font-medium">NUMBER OF MEMBERS</th>
                                   <td class="font-bold">{{$organisation->users()->active()->count()}}</td>
                               </tr>
                               <tr>
                                   <th class="font-medium">SHORT NAME</th>
                                   <td class="font-bold">{!! $organisation->short_name !!}</td>
                               </tr>
                               <tr>
                                   <th class="font-medium">EMAIL</th>
                                   <td class="font-bold">{{$organisation->email}}</td>
                               </tr>
                               <tr>
                                   <th class="font-medium">PHONE</th>
                                   <td class="font-bold">{{$organisation->phone}}</td>
                               </tr>
                               <tr>
                                   <th class="font-medium">WEBSITE</th>
                                   <td class="font-bold"><a href="https://{{$organisation->website}}" target="_blank">{{$organisation->website}}</a></td>
                               </tr>
                               <tr>
                                   <th class="font-medium">ADDRESS</th>
                                   <td class="font-bold">{{$organisation->address}}</td>
                               </tr>
                           </table>
                       </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-2">
            <div class="discussions-container">
                <div class="d-flex flex-wrap align-items-center">
                    <h1 class="title-h1 mb-0">MEMBERS</h1>
                </div>
            </div>

            <div class="discussions-container">

                <div class="table-responsive mt-5 discussions-table">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th class="border-0">USERNAME</th>
                            <th class="border-0">NAME</th>
                            <th class="border-0">JOIN DATE</th>
                            @if(Auth::user()->role == 'admin')
                                <th class="border-0">STATUS</th>
                            @endif
                            <th class="border-0">IMAGE</th>
                        </tr>
                        @foreach($organisation->users as $user)
                            <tr>
                                <td><a href="{{route('users.show', $user->id)}}">{{$user->username}}</a></td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->created_at->format('d F Y')}}</td>
                                @if(Auth::user()->role == 'admin')
                                    <td>{{ucfirst($user->status)}}</td>
                                @endif
                                <td><img src="{{$user->image}}" alt="{{$user->name}}" width="50"></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
