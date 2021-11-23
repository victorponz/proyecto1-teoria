<?php

interface IPasswordGenerator
{
    public static function encrypt(string $password): string;
    public static function passwordVerify($password, $hash): bool;
}