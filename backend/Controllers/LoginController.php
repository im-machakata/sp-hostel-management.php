<?php
include_once 'Controller.php';

class LoginController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // if the user id is found
        // user is logged in
        if (session('UserID')) {
            $this->response->redirect('/');
        }

        // if request method is post
        // and user is not logged in
        // process the credentials
        if ($this->request->isPost()) {
            $this->login();
        }
    }

    public function login() {}
}
