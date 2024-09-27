@extends('layouts.app')
@section('add-css')
    <link href="{{ mix('css/profile.css') }}" rel="stylesheet">
@endsection
@section('content')

    @include('profile._sidebar')

    <div class="profile-content">
        <ul class="nav nav-pills mb-3 profile-nav-tab" role="tablist">
            <li class="nav-item">
                <h6 class="nav-link active">Find friends</h6>
            </li>
        </ul>
        <form action="{{url()->full()}}" id="dashboard-filter-form">
            <div class="flex-grow-1 d-flex">
                <select name="search" id="user-and-organisation" class="form-control w-50">
                    <option value="" selected hidden>{{__('Search name/company:')}}</option>
                    <optgroup label="Users">
                        @foreach($users as $user)
                            <option value="{{$user->name}}" data-id="{{$user->id}}"
                                    data-type="user">{{$user->name}}</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Organisations">
                        @foreach($organisations as $organisation)
                            <option value="{{$organisation->name}}" data-id="{{$organisation->id}}"
                                    data-type="organisation"
                                    @if(request()->type == "organisation" && request()->id == $organisation->id) selected @endif>{{$organisation->name}}</option>
                        @endforeach
                    </optgroup>
                    @if(request()->search)
                        <option value="{{request()->search}}" data-select2-tag="true"
                                selected>{{request()->search}}</option>
                    @endif
                </select>

                <div class="discussions-search position-relative flex-grow-1 mb-2 ml-4 w-25">
                    <input type="text" name="location" id="location" class="form-control" placeholder="Location"
                           value="{{request()->get('location')}}">
                    <button type="submit" aria-label="search" class="btn"><span class="search-toggle"></span></button>
                </div>
            </div>
            <button class="btn btn-secondary float-right btn-sm clear-btn" type="button">{{__('Clear')}}</button>

        </form>
        <div class="table-responsive mt-5 discussions-table">
            <table class="table">
                @if($searchedUsers)
                    @if(count($searchedUsers) == 0)
                        <h5 class="text-center">{{__('There are no students in this organisation')}}</h5>
                    @else
                        <tbody>
                        <tr class="text-uppercase">
                            <th class="border-0">Name</th>
                            <th class="border-0">Location</th>
                            <th class="border-0">Organisation</th>
                            <th class="border-0">Discussions</th>
                            <th class="border-0">Replies</th>
                            <th class="border-0">Actions</th>
                        </tr>
                        @foreach($searchedUsers as $user)
                            <tr>
                                <td>
                                    <a href="{{route('users.show', [$user->id, 'type' => 'find'])}}"><u>{{$user->name}}</u></a>
                                </td>
                                <td>{{$user->location}}</td>
                                <td>{{$user->organisation->name}}</td>
                                <td>{{$user->threads()->active()->count()}}</td>
                                <td>{{$user->replies()->active()->count()}}</td>
                                <td class="action-buttons">
                                    <a href="{{route('users.show', [$user->id, 'type' => 'find'])}}"
                                       class="action-link action-link-blue"
                                       title="View"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    @endif
                @else
                    <h5 class="text-center">{{__('Enter your search term above')}}</h5>
                @endif
            </table>
            @if($searchedUsers)
                {{$searchedUsers->appends(request()->all())->links()}}
            @endif
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        const base_url = window.location.origin + window.location.pathname;
        const select = $('#user-and-organisation');
        const form = $('#dashboard-filter-form')

        function redirect(select) {
            let id = select.find(':selected').data('id');
            let type = select.find(':selected').data('type');
            let location = $('#location').val();
            if (select.find('option:selected').data("select2-tag")) {
                form.submit();
            } else {
                if (type === 'organisation') {
                    window.location.href = base_url + '?type=' + type + '&id=' + id + '&location=' + location;
                } else {
                    window.location.href = '/users/' + id + '?type=find';
                }
                select.find("option[value='" + select.find(':selected').val() + "']").prop('selected', true)

            }
        }

        select.select2({
            tags: true,
        });

        select.on('select2:open', function () {
            $('.select2-search__field').val(select.val());
        })

        $(document).on('click', '.clear-btn', function () {
            form.find('#location').val('')
            form.find('select option:first').prop('selected', true)
            select.trigger('change')
        });

        select.change(function (e) {
            if ($(this).val())
                redirect(select)
        });
    </script>
@endsection
