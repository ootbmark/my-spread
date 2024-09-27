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
            <form action="{{ route('dashboard.threads.index') }}" id="dashboard-filter-form">
                <div class="d-flex justify-content-between flex-wrap">
                    <select name="status" class="form-control w-auto mr-3 mb-2"
                        onchange="$('#dashboard-filter-form').submit()">
                        <option value="">Choose Status</option>
                        <option value="active" @if (request()->get('status') == 'active') selected @endif>Active</option>
                        <option value="new" @if (request()->get('status') == 'new') selected @endif>New</option>
                        <option value="parked" @if (request()->get('status') == 'parked') selected @endif>Parked</option>
                        <option value="deleted" @if (request()->get('status') == 'deleted') selected @endif>Deleted</option>
                    </select>
                    <div class="discussions-search position-relative flex-grow-1 mb-2">
                        <select name="thread_id" id="thread_id" class="form-control"></select>
                    </div>
                </div>
            </form>

            <div class="table-responsive mt-5 discussions-table">
                <table class="table">
                    <tbody>
                        <tr>
                            <th class="border-0">@sortablelink('id', 'ID')</th>
                            <th class="border-0">@sortablelink('name', 'DISCUSSION')</th>
                            <th class="border-0">GROUP</th>
                            <th class="border-0">STATUS</th>
                            <th class="border-0">@sortablelink('created_at', 'CREATED DATE')</th>
                            <th class="border-0">ACTIONS</th>
                        </tr>
                        @foreach ($threads as $thread)
                            <tr>
                                <td><a href="{{ route('discussions.show', $thread->id) }}">{{ $thread->id }}</a></td>
                                <td><a href="{{ route('discussions.show', $thread->id) }}">{{ $thread->subject }}</a></td>
                                <td>{{ $thread->group ? $thread->group->name : 'No Group' }}</td>
                                <td>{{ $thread->status }}</td>
                                <td>{{ $thread->created_at->format('d F Y') }}</td>
                                <td class="action-buttons">
                                    <a href="{{ route('discussions.show', $thread->id) }}"
                                        class="action-link action-link-blue" title="View"><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('dashboard.threads.edit', $thread->id) }}"
                                        class="action-link action-link-green" title="Edit"><i
                                            class="fa fa-pencil"></i></a>
                                    <a href="#" class="action-link action-link-red" title="Remove"
                                        onclick="$(this).next().submit()"><i class="fa fa-trash"></i></a>
                                    <form action="{{ route('dashboard.threads.destroy', $thread->id) }}" method="POST"
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
            {{ $threads->appends(request()->all())->links() }}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#thread_id').select2({
            ajax: {
                url: '{{ route('discussions.data') }}',
                dataType: 'json',
                processResults: function(data) {
                    return {
                        results: data
                    };
                }
            }
        });

        $('#thread_id').change(function() {
            window.location.href = '/discussions/' + $(this).find(':selected').val();
        });
    </script>
    @include('profile._avatar_scripts')
@endsection
