<div class="kt-portlet__body border-12">
    <div class="form-group row">
        <div class="col-lg-6">
            <div class="form-group">
                @include('dashboard.components.form._text', (['name' => 'name']))
            </div>
            <div class="form-group">
                @include('dashboard.components.form._select', (['name' => 'quizes', 'display_name' => 'Forms', 'data' => $quizes, 'selected' => $selected_quizes, 'multiple' => true, 'select_2' => true]))
            </div>
            <div class="form-group">
                <label for="users">Scribes</label>
                <select name="users[]" id="users" class="form-control" multiple="multiple"></select>
                {!! $errors->first('users', '<span class="form-text text-danger">:message</span>') !!}
            </div>
        </div>
    </div>
</div>

@section('scripts')
    @parent
    <script>
        const usersSelect = $('#users');
        const preSelectedIds = {!! json_encode(old('users', $selected_users), true) !!};
        usersSelect.select2();
        $.ajax({
            type: 'GET',
            url: '{{route('users.data.by_ids')}}',
            data: {
                user_ids: preSelectedIds,
            },
        }).then(function (data) {
            for (const user of data) {
                let option = new Option(user.name, user.id, true, true);
                usersSelect.append(option).trigger('change');
            }
        }).then(function () {
            usersSelect.select2({
                ajax: {
                    url: '{{route('users.data.paginated')}}',
                    delay: 250,
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        }
                    },
                    cache: true,
                }
            });
        })
    </script>
@endsection
