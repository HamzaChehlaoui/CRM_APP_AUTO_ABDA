<?php

if (!function_exists('activeClass')) {
    function activeClass($pattern)
    {
        return request()->is($pattern) ? 'bg-nucleus-light text-nucleus-primary' : 'hover:bg-nucleus-light hover:text-nucleus-primary';
    }
}

if (!function_exists('iconClass')) {
    function iconClass($pattern)
    {
        return request()->is($pattern) ? 'text-nucleus-primary' : 'text-gray-500';
    }
}
