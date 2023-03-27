<?php

use Jenssegers\Blade\Blade;

if (!function_exists('render_html')) {
    function render_html(string $view, array $params = [])
    {
        $bladeConfig = Helper::getConfig('blade.path');
        $blade = new Blade($bladeConfig['views'], $bladeConfig['cache']);
        return $blade->make($view, $params)->render();
    }
}

if (!function_exists('view')) {
    function view(string $view, array $params = [])
    {
        $html = render_html($view, $params);
        Response::html($html);
    }
}
