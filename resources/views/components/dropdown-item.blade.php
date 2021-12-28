@props(['active' => false])
@php
    $classes = 'block text-left text-sm3  px-3 text-xs leading-5 hover:bg-blue-500 focus:bg-blue-500 hover:text-white focus:text-white';
    if ($active) $classes .= ' bg-blue-500 text-white-500';
    @endphp
<a {{ $attributes(['class' => $classes]) }}
    >{{ $slot }}</a>   