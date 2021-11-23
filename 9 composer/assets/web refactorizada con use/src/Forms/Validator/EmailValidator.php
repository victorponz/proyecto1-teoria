<?php
namespace ProyectoWeb\Forms\Validator;

use ProyectoWeb\Forms\Validator\Validator;

class EmailValidator extends Validator {
    public function doValidate(): bool{
        $ok = filter_var($this->getData(), FILTER_VALIDATE_EMAIL);
        if (!$ok) {
            $this->appendError();
        }
        
        return $ok;
    } 
}