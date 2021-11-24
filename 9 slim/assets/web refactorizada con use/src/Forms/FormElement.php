<?php
namespace ProyectoWeb\Forms;

use ProyectoWeb\Forms\CompoundElement;

class FormElement extends CompoundElement
{
    /**
     * @var string
     *      
    **/
    private $action;
    
    /**
     * @var string
     *      
    **/
    private $enctype;
    
    public function __construct(string $action = '', string $enctype = '', string $name = '', string $id = '', string $cssClass  = '', string $style = '')
	{
        $this->action = $action;
        $this->enctype = $enctype;
        parent::__construct($name, 'form', $id, $cssClass, $style);
    }

    public function render(): string
    {
        $html = 
            "<form action='{$this->action}' method='POST'" .
            (!empty($this->enctype) ? " enctype='{$this->enctype}' " : '') .  
            $this->renderAttributes() . 
            ">";
            $html .= $this->renderChildren();
            
        $html .= '</form>'; 
        return $html;
    }
}