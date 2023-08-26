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

        // call any global & controller middlewares
        $this->globalMiddlewares();
        $this->middlewares();

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
     * Define you global system middlewares here. 
     * These will be called on all controllers
     *
     * @return void
     */
    protected function globalMiddlewares()
    {
        // if user is not logged in
        // and is not on login or register page
        // send them to the login page
        if (!session('UserID')) {
            $files = ['/frontend/login.php', '/frontend/create-account.php'];
            if (!in_array(Request::getServer('PHP_SELF'),  $files)) {
                $this->response->redirect('/login.php');
                return;
            }
        }

        if (session('UserID')) {

            // if the user has logged out
            // send them to the login page
            if (Request::isFile('/logout.php')) {
                $this->response->redirect('/login.php');
                return;
            }
        }
    }

    /**
     * Define your controller middlewares.
     * These will only be called when defined 
     * on that current controller.
     *
     * @return void
     */
    protected function middlewares()
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
