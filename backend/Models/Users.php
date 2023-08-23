<?php
include_once 'Model.php';
class Users extends Model
{
    protected $table = "users";

    public function login($username, $password): bool
    {
        // find user by student number
        $this->findWhere(['username' => $username]);
        if (!$user = $this->getResults()) {
            $this->errors[] = "No user found with that username.";
            return false;
        }

        $user = $user[0];
        // confirm if password is correct
        if (!password_verify($password, $user['password'])) {
            $this->errors[] = "You have entered an invalid password.";
            return false;
        }
        return true;
    }
    public function register($studentNumber, $studentPassword): bool
    {
        return true;
    }
}
