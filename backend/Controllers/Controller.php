<?php
include_once __DIR__ . '/../config.php';
include_once __DIR__ . '/../System/Functions.php';
include_once __DIR__ . '/../System/Request.php';
include_once __DIR__ . '/../System/Response.php';

class Controller
{
    protected $errors = [];

    /**
     * Contains basic functions to get data from the request
     *
     * @var Request
     */
    public $request;

    /**
     * Contains basic response functions
     *
     * @var Response
     */
    public $response;

    public function __construct()
    {
        // starts session to keep track of user
        session_start();

        // initialize response and request classes
        $this->request = new Request();
        $this->response = new Response();

        // call any functions that needs to be run on startup
        $this->initialize();
    }

    /**
     * Function is called when the controller is initialized.
     * You can put your init code here instead of using the constructor
     */
    protected function initialize()
    {
    }

    /**
     * Returns true if there are any errors
     *
     * @return boolean
     */
    public function hasErrors()
    {
        return $this->errors ? true : false;
    }

    /**
     * Will return a string of the last error or null if none
     *
     * @return void
     */
    public function getLastError()
    {
        return end($this->errors);
    }

    /**
     * Willl return a list of errors
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
