<?php
namespace ProyectoWeb\Forms\Validator;

use ProyectoWeb\Forms\Validator\Validator;


class MinLengthValidator extends Validator {

    private $minLength;
    public function __construct(int $minLength, string $message, bool $last = false)
    {
        $this->minLength = $minLength;
        parent::__construct($message, $last);
    }
    public function doValidate(): bool{
        $ok  = (strlen($this->getData()) >= $this->minLength);
        if (!$ok) {
            $this->appendError();
        }
        
        return $ok;
    } 
}