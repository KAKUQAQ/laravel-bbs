<?php

use Illuminate\Support\Facades\Route;

/**
 * Get the route name for the CSS class.
 *
 * @return array|string|null
 */
function route_class(): array|string|null
{
    return str_replace('.', '-', Route::currentRouteName());
}

function category_nav_active(int $category_id): string
{
    return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
}
