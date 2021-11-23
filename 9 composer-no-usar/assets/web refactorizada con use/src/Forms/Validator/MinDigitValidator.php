<?php
namespace ProyectoWeb\Forms\Validator;

use ProyectoWeb\Forms\Validator\Validator;

class MinDigitValidator extends Validator {

    private $minDigit;
    public function __construct(int $minDigit, string $message, bool $last = false)
    {
        $this->minDigit = $minDigit;
        parent::__construct($message, $last);
    }
    public function doValidate(): bool{
        $cont = 0;
        for ($i = 0; $i < strlen($this->getData()); $i++){
            if (ctype_digit($this->getData()[$i])) {
                $cont++;
            }
        }
        $ok = ($cont >= $this->minDigit);
        if (!$ok) {
            $this->appendError();
        }
        return $ok;
    } 
}