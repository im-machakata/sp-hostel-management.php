<?php
include_once 'Controller.php';
include_once __DIR__ . '/../System/Request.php';
include_once __DIR__ . '/../Models/Users.php';

class LoginController extends Controller
{
    protected function initialize()
    {
        if (Request::isFile('/logout.php')) {
            $this->logout();
            $this->response->redirect('/login.php');
            return;
        }

        // if request method is post
        // and user is not logged in
        // process the credentials
        if ($this->request->isPost() && $this->login()) {
            $this->response->redirect('/');
        }
    }

    public function login(): bool
    {
        // connect to the database
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $model = new Users();

        if ($model->login($username, $password)) {
            $user = $model->findWhere(['username' => $username])->getRow();
            session('UserID', $user['id']);
            session('UserType', $user['is_admin'] ? 'Admin' : 'Student');
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
    }
}
