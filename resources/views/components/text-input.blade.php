@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-blue-200 focus:border-blue-600 focus:ring-blue-600 rounded-xl shadow-sm placeholder:text-blue-300']) !!}>
