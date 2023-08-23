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
    public function register($studentNumber, $studentPassword, bool $isAdmin = false): bool
    {
        // validate if both username and password are present
        if (!$studentNumber || !$studentPassword) {
            $this->errors[] = "Student Number or Password is missing.";
            return false;
        }

        // check if username / user id is not taken
        if ($this->findWhere(['username' => $studentNumber])->getResults()) {
            $this->errors[] = 'Username is not available, try another one.';
            return false;
        }

        #region Register User
        // save the user to the database
        try {
            $this->db->prepare(
                sprintf('INSERT INTO %s (id,username,password,is_admin) VALUES (NULL,:username,:password,:is_admin)', $this->table),
                array(
                    'username' => $studentNumber,
                    'password' => password_hash($studentPassword, PASSWORD_DEFAULT),
                    'is_admin' => $isAdmin ? '1' : '0'
                )
            );
            $this->db->exec();
        } catch (PDOException $e) {

            // if an error occured, log it
            $this->errors[] = $e->getMessage();
            return false;
        }
        #endregion

        return true;
    }
}
