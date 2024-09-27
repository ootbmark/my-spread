{!! Form::label($name, $display_name ?? __(ucfirst(str_replace('_', ' ', str_replace('_id', '', $name))))) !!}
{!! Form::select($name . ((isset($multiple) && $multiple) ? '[]' : ''), $data, $selected ?? null, ['id' => $name, 'class' => 'form-control', 'multiple' => $multiple ?? false]) !!}
{!! $errors->first($name, '<span class="form-text text-danger">:message</span>') !!}

@if(isset($select_2) && $select_2)
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        var select_2_tags = false;
        @if(isset($tags) && $tags)
            select_2_tags = true;
        @endif
        $('#{{$name}}').select2({
            tags: select_2_tags
        });
    </script>
@endif
