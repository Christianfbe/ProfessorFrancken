@props([
    'name',
    'label',
    'value' => null,
    'placeholder' => '',
    'help' => '',
    'required' => false,
                       'rows' => 3,
])

<div class="form-group">
    @isset($label)
    <label for="{{ $name }}">{{ $label }}</label>
    @endisset
    {!!
           Form::textarea(
               $name,
               $value,
               [
                   'class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : ''),
                   'placeholder' => $placeholder,
                   'id' => $name,
                   'required' => $required,
                   'rows' => $rows,
               ]
           )
    !!}

    <x-forms.error :name="$name" />

    {!! $help !!}
</div>
