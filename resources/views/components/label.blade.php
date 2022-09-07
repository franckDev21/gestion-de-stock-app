@props(['value'])

<label {{ $attributes->merge(['class' => 'block pb-2 font-medium text-sm text-gray-500']) }}>
    {{ $value ?? $slot }}
</label>
