@props(['active'])

@php
$classes = ($active ?? false)
            ? 'nav-link active d-block'
            : 'nav-link d-block';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
