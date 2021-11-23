<?php
namespace ProyectoWeb\security;

use ProyectoWeb\security\IPasswordGenerator;

class PlainPasswordGenerator implements IPasswordGenerator
{
    public static function encrypt(string $password): string {
        return $password;
    }
    
    public static function passwordVerify($password, $hash): bool {
        return ($password == $hash);
    }

}