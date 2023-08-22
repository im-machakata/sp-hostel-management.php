<?php
include_once 'Controller.php';
include_once __DIR__ . '/../Models/Users.php';

class LoginController extends Controller
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
            if ($this->login()) {
                $this->response->redirect('/');
                return;
            }
        }
    }

    public function login(): bool
    {
        // connect to the database
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $model = new Users();

        if ($model->login($username, $password)) {
            session('UserID', $this->request->getVar('username'));
            return true;
        }
        $this->errors[] = $model->getErrors()[0];
        return false;
    }
    public function logout()
    {
        session('UserID', null);
        session('UserType', null);
        session_regenerate_id(true);
        $this->response->redirect('/');
    }
}
