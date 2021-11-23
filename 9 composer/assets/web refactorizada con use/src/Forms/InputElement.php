<?php
namespace ProyectoWeb\Forms;

use ProyectoWeb\Forms\DataElement;

class InputElement extends DataElement
{
    
    public function __construct(string $name, string $type, string $id = '', string $cssClass  = '', string $style = '')
    {
        parent::__construct($name, $type, $id, $cssClass, $style);
    }

    /**
     * Genera el HTML del elemento
     *
     * @return string
     */
    public function render(): string
    {
        $this->setPostValue();
        $html = "<input type='{$this->getType()}' " ; 
        $html .= $this->renderAttributes();
        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            $html .= " value='" . $this->getValue() . "'";
        } else {
            $html .= " value='{$this->getDefaultValue()}'";
        }
       
        $html .= '>';
        return $html;
    }

}