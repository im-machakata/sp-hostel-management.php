<?php
// By initialising the LoginController,
// it checks it will execute the logout function
// when it figures that the url is for logging out
// Nothing more needs to be done as it will redirect the user
// to the login page even if they were not loged in already
require "../backend/Controllers/LoginController.php";
$controller = new LoginController();
