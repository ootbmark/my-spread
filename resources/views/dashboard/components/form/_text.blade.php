{!! Form::label($name, __(ucfirst(str_replace('_', ' ', $name)))) !!}
{!! Form::text($name, $value ?? null, ['id' => $name, 'class' => 'form-control', 'placeholder' => __(ucfirst(str_replace('_', ' ', $name)))]) !!}
{!! $errors->first($name, '<span class="form-text text-danger">:message</span>') !!}
