<?php
class Users extends Model
{
    protected $table = "users";
    private string $studentNumber;
    private string $studentPassword;

    public function login($studentNumber, $studentPassword): bool
    {
    }
    public function register($studentNumber, $studentPassword): bool
    {
    }
}
