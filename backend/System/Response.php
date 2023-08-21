<?php
class Response
{
    public function redirect($url)
    {
        header(sprintf('Location: %s', $url));
    }

    public function setHeaders($name, $value)
    {
        header(sprintf('%s: %s', $name, $value));
    }
}
