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
            <form action="{{route('dashboard.universities.update', $university->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                @include('dashboard.universities._form')

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="active" @if($university->status == 'active') selected @endif>Active</option>
                        <option value="new" @if($university->status == 'new') selected @endif>New</option>
                        @if(!$university->isFallback())
                        <option value="deleted" @if($university->status == 'deleted') selected @endif>Deleted</option>
                        @endif
                    </select>
                    @error('status')
                    <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
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

