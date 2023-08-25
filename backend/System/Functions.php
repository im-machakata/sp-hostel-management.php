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

/**
 * Use component files in your ui.
 *
 * @param string $__name__ component name
 * @param array $__data__ component data
 * @return void
 */
function render_component($__name__, $__data__ = [])
{
    extract($__data__);
    $__FILE__ =    __DIR__ . '/../Views/' . $__name__ . '.php';
    if (file_exists($__FILE__)) {
        require $__FILE__;
    }
}


function url_active($url)
{
    if (Request::isUrl($url)) {
        return ' active';
    }
    return '';
}
