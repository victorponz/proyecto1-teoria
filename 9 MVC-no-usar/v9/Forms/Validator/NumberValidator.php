<?php
require_once __DIR__ . "/Validator.php";

class NumberValidator extends Validator {

    public function doValidate(): bool{
        $ok = ($this->getData() === "0") || filter_var($this->getData(), FILTER_VALIDATE_INT);
        if (!$ok) {
            $this->appendError();
        }
        return $ok;
    } 
}