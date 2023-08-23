<?php
include 'Controller.php';

class HomeController extends Controller
{
    protected function initialize()
    {
        // if the user id is not specified
        // send the user to a login page
        // else execution will proceed
        if (!session('UserID')) {
            $this->response->redirect('/login.php');
        }
    }

    public function isAdmin()
    {
        return session('UserType') == 'Admin';
    }
}
