<?php

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
