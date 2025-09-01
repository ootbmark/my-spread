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
            <form action="{{ route('dashboard.users.index') }}" id="dashboard-filter-form">
                <div class="d-flex justify-content-between flex-wrap">
                    <select name="status" class="form-control w-auto mr-3 mb-2"
                        onchange="$('#dashboard-filter-form').submit()">
                        <option value="">Choose Status</option>
                        <option value="active" @if (request()->get('status') == 'active') selected @endif>Active</option>
                        <option value="new" @if (request()->get('status') == 'new') selected @endif>New</option>
                        <option value="deleted" @if (request()->get('status') == 'deleted') selected @endif>Deleted</option>
                    </select>

                    <div class="flex-grow-1 d-flex" style="max-width: 900px">
                        <select name="user_id" id="user_id" class="form-control"></select>
                        <div class="discussions-search position-relative flex-grow-1 mb-2 ml-4">
                            <input type="text" name="organisation" id="organisation" class="form-control"
                                placeholder="Organisation" value="{{ request()->get('organisation') }}">
                            <button type="submit" aria-label="search" class="btn"><span
                                    class="search-toggle"></span></button>
                        </div>
                        <div class="discussions-search position-relative flex-grow-1 mb-2 ml-4">
                            <input type="text" name="location" id="location" class="form-control" placeholder="Location"
                                value="{{ request()->get('location') }}">
                            <button type="submit" aria-label="search" class="btn"><span
                                    class="search-toggle"></span></button>
                        </div>
                        <div class="flex-grow-1 mb-2 ml-4">
                            <button class="btn btn-outline-danger  btn-clear w-100">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </form>

            <div class="table-responsive mt-5 discussions-table">
                <table class="table">
                    <tbody>
                        <tr>
                            <th class="border-0">@sortablelink('id', 'ID')</th>
                            <th class="border-0">@sortablelink('first_name', 'NAME')</th>
                            <th class="border-0">@sortablelink('created_at', 'JOINED DATE')</th>
                            <th class="border-0">LOCATION</th>
                            <th class="border-0">ORGANISATION</th>
                            <th class="border-0">STATUS</th>
                            <th class="border-0">ACTIONS</th>
                        </tr>
                        @foreach ($users as $user)
                            <tr>
                                <td><a href="{{ route('users.show', $user->id) }}">{{ $user->number }}</a></td>
                                <td><a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></td>
                                <td>{{ $user->created_at->format('d F Y') }}</td>
                                <td>{{ $user->location }}</td>
                                <td>{{ $user->organisation ? $user->organisation->name : 'No Organisation' }}</td>
                                <td>{{ $user->status }}</td>
                                <td class="action-buttons">
                                    <a href="{{ route('users.show', $user->id) }}" class="action-link action-link-blue"
                                        title="View"><i class="fa fa-eye"></i></a>
                                    <a href="#" class="action-link action-link-blue send-message"
                                        data-id="{{ $user->id }}" data-email="{{ $user->email }}" title="Message"><i
                                            class="fa fa-envelope"></i></a>
                                    <a href="{{ route('dashboard.users.edit', $user->id) }}"
                                        class="action-link action-link-green" title="Edit"><i
                                            class="fa fa-pencil"></i></a>
                                    <a href="#" class="action-link action-link-red" title="Remove"
                                        onclick="$(this).next().submit()"><i class="fa fa-trash"></i></a>
                                    <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $users->appends(request()->all())->links() }}
        </div>
    </div>


    <div class="modal" tabindex="-1" id="messageModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form class="modal-body text-center p-4" action="{{ route('dashboard.users.message') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="hidden_user_id">
                    <p>This message will be sent to: <b id="messageEmail"></b></p>
                    <div class="form-group">
                        <input type="text" class="form-control" id="subject"
                            placeholder="Enter the subject of the email here..." required name="subject">
                    </div>
                    <div class="form-group editor-div">
                        <textarea name="message" id="message" placeholder="Enter your message here"></textarea>
                    </div>
                    <button type="button" data-dismiss="modal"
                        class="btn my-btn btn-white text-uppercase">Close</button>
                    <button type="submit" class="btn my-btn text-uppercase">Send</button>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('profile._avatar_scripts')
    <script src="/ckeditor/ckeditor.js"></script>
    <script>
        $('#organisation_id').select2({
            ajax: {
                url: '{{ route('organisations.data') }}',
                dataType: 'json',
                processResults: function(data) {
                    return {
                        results: data
                    };
                }
            }
        });
        $('.send-message').click(function() {
            let id = $(this).data('id')
            let email = $(this).data('email')
            $('#messageEmail').html(email);
            $('#hidden_user_id').val(id);
            $('#messageModal').modal('show');
            $('#subject').val('');
            $('.editor-div').html('');
            $('.editor-div').html(
                '<textarea name="message" id="message" placeholder="Enter your message here"></textarea>');
            ClassicEditor
                .create(document.querySelector('#message'), {
                    toolbar: {
                        removeItems: ['uploadImage', 'MathType', 'ChemType']
                    },
                })
                .catch(error => {
                    console.error(error);
                });
        })

        $('#user_id').select2({
            ajax: {
                url: '{{ route('users.data') }}',
                dataType: 'json',
                processResults: function(data) {
                    return {
                        results: data
                    };
                }
            }
        });
        $('.btn-clear').click(function(e) {
            e.preventDefault();
            $('#organisation').val('');
            $('#location').val('');
            $('#status').val('');
            $('#user_id').val('');
        });
        $('#user_id').change(function() {
            window.location.href = '/users/' + $(this).find(':selected').val();
        });
    </script>
@endsection
