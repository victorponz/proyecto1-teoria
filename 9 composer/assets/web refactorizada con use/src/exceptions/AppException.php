<?php
namespace ProyectoWeb\exceptions;

class AppException extends \Exception
{
    public function __construct(string $message){
        parent::__construct($message);
    }
}