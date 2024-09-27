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
            <form action="{{route('dashboard.groups.update', $group->id)}}" method="POST">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="name">Group name<span class="text-red ml-1">*</span></label>
                            <input type="text" class="form-control" id="name" placeholder="Group name" name="name" value="{{$group->name}}">
                            @error('name')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea  class="form-control" id="description" placeholder="Description" name="description">{{$group->description}}</textarea>
                            @error('description')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="parent_id">Parent group</label>
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">Select parent</option>
                                @foreach($groups as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            @error('parent_id')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                    </div>
                </div>

                <div class="text-right pt-2">
                    <button type="submit" class="btn my-btn text-uppercase">Update</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    @include('profile._avatar_scripts')
@endsection

