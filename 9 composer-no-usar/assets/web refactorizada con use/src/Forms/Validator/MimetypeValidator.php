<?php
namespace ProyectoWeb\Forms\Validator;

use ProyectoWeb\Forms\Validator\Validator;

class MimetypeValidator extends Validator {

    private $mimeTypes;
    public function __construct(array $mimeTypes, string $message, bool $last = false)
    {
        $this->mimeTypes = $mimeTypes;
        parent::__construct($message, $last);
    }
   
    public function doValidate(): bool{
        $ok = in_array($this->getData()["type"], $this->mimeTypes);
        if (!$ok) {
            $this->appendError();
        }
        
        return $ok;
    } 
}