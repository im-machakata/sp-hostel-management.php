<?php
include_once 'Controller.php';
include_once __DIR__ . '/../Models/Users.php';

class RegisterController extends Controller
{
    protected function initialize()
    {
        // if the user id is found
        // user is logged in
        if (session('UserID')) {
            $this->response->redirect('/');
        }

        // if request method is post
        // and user is not logged in
        // process the credentials
        if ($this->request->isPost()) {
            if ($this->register()) {
                $this->response->redirect('/');
                return;
            }
        }
    }

    public function register(): bool
    {
        // connect to the database
        $username = $this->request->getVar('student-id');
        $password = $this->request->getVar('password');
        $model = new Users();

        if ($model->register($username, $password)) {
            $this->response->redirect('/login.php');
            return true;
        }

        $this->errors[] = $model->getFirstError();
        return false;
    }
}
