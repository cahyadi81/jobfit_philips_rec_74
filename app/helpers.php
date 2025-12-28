<?php

if (!function_exists('menu_active')) {
    function menu_active(...$patterns)
    {
        foreach ($patterns as $pattern) {
            if (request()->is($pattern)) {
                return 'active';
            }
        }
        return '';
    }
}
