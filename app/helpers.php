<?php

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function active_class ($condition)
{
    return $condition ? 'active' : '';
}
