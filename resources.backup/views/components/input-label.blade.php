@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-sky-800']) }}>
    {{ $value ?? $slot }}
</label>
