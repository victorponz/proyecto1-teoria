<?php
namespace ProyectoWeb\Forms\Validator;

use ProyectoWeb\Forms\Validator\Validator;

class NumberValidator extends Validator {

    public function doValidate(): bool{
        $ok = ($this->getData() === "0") || filter_var($this->getData(), FILTER_VALIDATE_INT);
        if (!$ok) {
            $this->appendError();
        }
        return $ok;
    } 
}