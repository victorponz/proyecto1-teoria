<?php
include_once __DIR__ . "/DataElement.php";

class TextareaElement extends DataElement
{
    public function __construct(string $name,  string $id = '', string $cssClass  = '', string $style = '')
    {
        parent::__construct($name, "textarea", $id, $cssClass, $style);
    }
    
    public function render(): string
    {
        $html = "<textarea ";
        $html .= $this->renderAttributes();
        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            $html .= '>' . $this->sanitizeInput();
        } else {
            $html .= ">{$this->getDefaultValue()}";
        }
        $html .= '</textarea>';

       return $html;
    
    }
}