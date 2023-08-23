<?php
require_once 'Request.php';
/**
 * Returns a session value if provided or sets value to session key
 *
 * @param string $key
 * @param mixed $value
 * @return void|mixed
 */
function session($key, $value = '')
{
    if ($value === '') {
        return $_SESSION[$key] ?? null;
    }
    $_SESSION[$key] = $value;
}

function render_component($name,$data = [])
{
    extract($data);
    require_once __DIR__ . '/../Views/' . $name . '.php';
}


function url_active($url)
{
    if (Request::isUrl($url)) {
        return ' active';
    }
    return '';
}
