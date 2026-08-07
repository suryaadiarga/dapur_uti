@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-sky-200 focus:border-blue-600 focus:ring-blue-600 rounded-md shadow-sm']) !!}>
