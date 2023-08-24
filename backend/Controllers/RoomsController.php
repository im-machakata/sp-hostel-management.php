<?php
include 'Controller.php';

class RoomsController extends Controller
{
    protected function initialize()
    {
        // if the user id is not specified
        // send the user to a login page
        // else execution will proceed
        if (!session('UserID')) {
            $this->response->redirect('/login.php');
        }

        // If user is on the book room page
        // but without a valid id, redirect home
        if (Request::isFile('/book-room.php') && !$this->request->get('id')) {
            $this->response->redirect('/');
        }
    }

    public function isAdmin()
    {
        return session('UserType') == 'Admin';
    }
}
