<?php
include __DIR__.'/../System/Functions.php';
include __DIR__.'/../System/Request.php';
include __DIR__.'/../System/Response.php';

class Controller
{
    private $errors = [];
    protected $request;
    protected $response;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
    }
}
