<?php
namespace ProyectoWeb\Forms\Validator;

use ProyectoWeb\Forms\Validator\Validator;

class MaxSizeValidator extends Validator {

    private $maxSize;

    public function __construct(int $maxSize, string $message, bool $last = false)
    {
        $this->maxSize = $maxSize;
        parent::__construct($message, $last);
    }
    public function doValidate(): bool{
        $ok  = !(($this->maxSize > 0) && ($this->getData()['size'] > $this->maxSize));
        if (!$ok) {
            $this->appendError();
        }
        
        return $ok;
    } 
}