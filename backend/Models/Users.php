<?php
include_once 'Model.php';
class Users extends Model
{
    protected $table = "users";
    private string $studentNumber;
    private string $studentPassword;

    public function login($studentNumber, $studentPassword): bool
    {
        $this->findWhere(['username' => $studentNumber, $studentPassword]);
        $result = $this->getResults() ? true : false;
        $this->errors[] = !$result ? "Username or password is incorrect." : null;
        return $result;
    }
    public function register($studentNumber, $studentPassword): bool
    {
        return true;
    }
}
