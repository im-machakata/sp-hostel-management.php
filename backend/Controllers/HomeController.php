<?php
include 'Controller.php';

class HomeController extends Controller
{
    public function isAdmin()
    {
        return session('UserType') == 'Admin';
    }
}
