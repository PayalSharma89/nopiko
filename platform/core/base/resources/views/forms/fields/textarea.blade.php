<x-core::form.field
    :showLabel="$showLabel"
    :showField="$showField"
    :options="$options"
    :name="$name"
    :prepend="$prepend ?? null"
    :append="$append ?? null"
    :showError="$showError"
    :nameKey="$nameKey"
>
    <x-slot:label>
        @if ($showLabel && $options['label'] !== false && $options['label_show'])
            {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
        @endif
    </x-slot:label>

    @php
        $id = Arr::get($options['attr'], 'id', $name);
        Arr::set($options['attr'], 'id', $id);
    @endphp

    {!! Form::textarea($name, $options['value'], $options['attr']) !!}
</x-core::form.field>
