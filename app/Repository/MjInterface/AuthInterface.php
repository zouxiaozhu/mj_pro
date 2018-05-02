<?php
namespace App\Repository\MjInterface;

interface AuthInterface
{
    public function login($fill_able);

    public function logout();
}