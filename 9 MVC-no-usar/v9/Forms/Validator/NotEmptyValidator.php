<?php
require_once __DIR__ . "/Validator.php";

class NotEmptyValidator extends Validator {
    public function doValidate(): bool{
        $ok = !empty($this->getData());
        if (!$ok) {
            $this->appendError();
        }
        return $ok;
    } 
}