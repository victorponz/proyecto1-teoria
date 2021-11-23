<?php
require_once  __DIR__ . "/Validator.php";
require_once  __DIR__ . "/NotEmptyValidator.php";
require_once  __DIR__ . "/EmailValidator.php";
require_once  __DIR__ . "/EmailDomainValidator.php";

class CustomEmailValidator
{
    /**
     *
     * @var Validator
     */
    protected $customValidator;

    /**
     * Crea la cadena de validación para comprobar que el campo $campo pertenece al dominio $domain
     *
     * @param string $campo
     * @param string $domain
     */
    public function __construct(string $campo, string $domain)
    {
        /*
            Creamos los validadores y la cadena de validación
        */
        $this->customValidator = new NotEmptyValidator("El campo <i>$campo</i> no puede estar vacío", true);
        $emailValidator = new EmailValidator("Formato inválido de correo", true);
        $emailDomainValidator = new EmailDomainValidator($domain, "El correo debe pertenecer al dominio $domain", true);

        $this->customValidator->setNextValidator($emailValidator->setNextValidator($emailDomainValidator));
    
    }
    
    public function getValidator(): Validator
    {
        return $this->customValidator;
    }
}