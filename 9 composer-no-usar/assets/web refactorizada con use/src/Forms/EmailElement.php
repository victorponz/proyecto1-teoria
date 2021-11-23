<?php
namespace ProyectoWeb\Forms;

use ProyectoWeb\Forms\InputElement;
use ProyectoWeb\Forms\Validator\EmailValidator;

class EmailElement extends InputElement
{
  
    public function __construct(string $name, string $id = '', string $cssClass  = '', string $style = '')
    {
        parent::__construct($name, 'email', $id, $cssClass, $style);
        $this->setValidator(new EmailValidator("Formato inválido de correo", true));
    }
}