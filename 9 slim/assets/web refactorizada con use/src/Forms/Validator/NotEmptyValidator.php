<?php
namespace ProyectoWeb\Forms\Validator;

use ProyectoWeb\Forms\Validator\Validator;

class NotEmptyValidator extends Validator {
    public function doValidate(): bool{
        $ok = !empty($this->getData());
        if (!$ok) {
            $this->appendError();
        }
        return $ok;
    } 
}