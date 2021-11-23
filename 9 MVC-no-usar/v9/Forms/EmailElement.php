<?php
require_once __DIR__ . "/InputElement.php";
require_once __DIR__ . "/Validator/EmailValidator.php";
class EmailElement extends InputElement
{
  
    public function __construct(string $name, string $id = '', string $cssClass  = '', string $style = '')
    {
        parent::__construct($name, 'email', $id, $cssClass, $style);
        $this->setValidator(new EmailValidator("Formato inválido de correo", true));
    }
}