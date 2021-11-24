<?php
namespace ProyectoWeb\Forms;

use ProyectoWeb\Forms\InputElement;

class PasswordElement extends InputElement
{

    public function __construct(string $name, string $id = '', string $cssClass  = '', string $style = '')
	{
       parent::__construct($name, 'password', $id, $cssClass, $style);
    }

    public function render(): string
    {
        $this->setPostValue();
        $html = "<input type='{$this->getType()}' " ; 
        $html .= $this->renderAttributes();
        $html .= '>';
        return $html;
    }
}