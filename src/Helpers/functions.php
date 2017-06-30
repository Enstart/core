<?php
if (!function_exists('dd')) {
    function dd(...$data)
    {
        dump(...$data);
        exit;
    }
}

if (!function_exists('dump')) {
    function dump(...$data)
    {
        echo '<pre style="background-color: #f3f3f3; font-face: consolas monospace; color: #222; font-size: 12px; font-weight: 400; padding: 10px; border: solid 1px #ccc; text-align: left;">';
        var_dump(...$data);
        echo "</pre>";
    }
}
