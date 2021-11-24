<?php
namespace ProyectoWeb\Forms\Validator;

use ProyectoWeb\Forms\Validator\Validator;

class MinLowerCaseValidator extends Validator {

    private $minLowerCase;
    public function __construct(int $minLowerCase, string $message, bool $last = false)
    {
        $this->minLowerCase = $minLowerCase;
        parent::__construct($message, $last);
    }
    public function doValidate(): bool{
        $cont = 0;
        for ($i = 0; $i < strlen($this->getData()); $i++){
            if (ctype_lower($this->getData()[$i])) {
                $cont++;
            }
        }
        $ok = ($cont >= $this->minLowerCase);
        if (!$ok) {
            $this->appendError();
        }
        return $ok;
    } 
}