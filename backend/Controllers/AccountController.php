<?php
include_once 'Controller.php';
include_once __DIR__ . '/../System/Request.php';
include_once __DIR__ . '/../Models/Users.php';

class AccountController extends Controller
{
    protected function initialize()
    {
        // if the user id is found
        // user is logged in
        if (!session('UserID')) {
            $this->response->redirect('/login.php');
            return;
        }

        // if request method is post
        // and user is not logged in
        // process the credentials
        if ($this->request->isPost()) {
            $this->updateAccount();
        }
    }

    public function updateAccount(): bool
    {
        // connect to the database
        $username = $this->request->getVar('student-id');
        $password = $this->request->getVar('password');
        $model = new Users();
        $model->save([
            'username' => $username,
            'password' => $password,
            'id' => session('UserID')
        ]);
        if ($model->hasErrors()) {
            $this->errors[] = $model->getFirstError();
        }
        return $model->hasErrors();
    }
}
