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

function make_excerpt(string $value, int $length = 200): mixed
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str()->limit($excerpt, $length);
}

function model_admin_link($title, $model): string
{
    return model_link($title, $model, 'admin');
};

function model_link($title, $model, string $prefix = ''): string
{
    $model_name = model_plural_name($model);

    $prefix = $prefix ? "/$prefix/" : "/";

    $url = config('app.url') . $prefix . $model_name . '/' . $model->id;

    return '<a href="' . $url . '" target="_blank">' . $title . '</a>';
}

function model_plural_name($model): string
{
    $full_class_name = get_class($model);

    $class_name = class_basename($model);

    $snake_case_name = str()->snake($class_name);

    return str()->plural($snake_case_name);
}
