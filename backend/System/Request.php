<?php
class Request
{
    public function isGet()
    {
        return $this->getServer('REQUEST_METHOD') == "GET";
    }

    public function isPost()
    {
        return $this->getServer('REQUEST_METHOD') == "POST";
    }

    public function get($key)
    {
        return $_GET[$key] ?? null;
    }

    public function post($key)
    {
        return $_POST[$key] ?? null;
    }

    public function getVar($key)
    {
        return $_REQUEST[$key] ?? null;
    }

    public function getServer($name)
    {
        return $_SERVER[strtoupper($name)] ?? null;
    }

    public function getHeaders($name)
    {
        return get_headers($this->getServer('host'), true)[$name] ?? null;
    }
    public function isUrl($url)
    {
        return $this->getServer('REQUEST_URI') == $url;
    }
    public function isFile($url)
    {
        return $this->getServer('PHP_SELF') == $url;
    }
}
