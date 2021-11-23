<?php
namespace ProyectoWeb\Forms\Validator;

use ProyectoWeb\Forms\Validator\Validator;
use ProyectoWeb\Forms\PasswordElement;

class PasswordMatchValidator extends Validator {
    private $passwordEl;

    public function __construct(PasswordElement $passwordEl, string $message, bool $last = false)
    {
        $this->passwordEl = $passwordEl;
        parent::__construct($message, $last);
    }
    public function doValidate(): bool{
        $ok =  ($this->getData() === $this->passwordEl->getValue());
        if (!$ok) {
            $this->appendError();
        }
        
        return $ok;
    } 
}