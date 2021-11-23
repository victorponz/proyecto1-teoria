<?php
namespace ProyectoWeb\Forms\Validator;

use ProyectoWeb\Forms\Validator\Validator;

class EmailDomainValidator extends Validator {

    private $domain;

    public function __construct(string $domain, string $message,  bool $last = false)
    {
        $this->domain = $domain;
        parent::__construct($message, $last);
    }
    public function doValidate(): bool{
        $ok = (substr($this->getData(), strlen($this->getData()) - strlen("@" . $this->domain) ) === "@" . $this->domain);
        if (!$ok) {
            $this->appendError();
        }
        
        return $ok;
    } 
}