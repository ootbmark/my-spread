@extends('layouts.app')
@section('content')
    <section class="discussions">
        <div class="discussions-container">
            <div class="d-flex flex-wrap align-items-center">
                <h1 class="title-h1 mb-0">MEMBER ORGANISATIONS</h1>
            </div>
        </div>

        <div class="discussions-container">
            <form action="{{route('organisations.index')}}">
                <div class="discussions-search position-relative">
                    <input type="search" placeholder="Organisation name" name="search" value="{{request()->get('search')}}" aria-label="search" class="form-control">
                    <button type="submit" aria-label="search" class="btn"><span class="search-toggle"></span></button>
                </div>
            </form>

            <div class="table-responsive mt-5 discussions-table">
                <table class="table">
                    <tr>
                        <th class="border-0">@sortablelink('id', 'SI NO')</th>
                        <th class="border-0">@sortablelink('name', 'ORGANISATION')</th>
                        <th class="border-0">@sortablelink('created_at', 'JOINED DATE')</th>
                        <th class="border-0">WEBSITE</th>
                        <th class="border-0">NUMBER OF MEMBERS</th>
                        <th class="border-0">LOGO</th>
                    </tr>
                    @foreach($organisations as $organisation)
                        <tr>
                            <td>{{$organisation->id}}</td>
                            <td><a href="{{route('organisations.show', $organisation->id)}}">{{$organisation->name}}</a></td>
                            <td>{{$organisation->created_at->format('d/m/Y')}}</a></td>
                            <td><a href="https://{{$organisation->website}}" target="_blank">{{$organisation->website}}</a></td>
                            <td>{{$organisation->users_count}}</td>
                            <td>
                                @if($organisation->logo)
                                     <img src="{{$organisation->logo}}" width="50" alt="{{$organisation->name}}">
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            {!! $organisations->appends(request()->all())->links() !!}
        </div>
    </section>
@endsection

