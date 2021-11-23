<?php
require_once __DIR__ .  "/DataElement.php";

class ButtonElement extends DataElement
{
    /**
     * Texto del botón
     *
     * @var string
     */
    private $text;
    
    public function __construct(string $text, string $name, string $id = '', string $cssClass  = '', string $style = '')
	{
        $this->text = $text;
        parent::__construct($name, 'button', $id, $cssClass, $style);
    }

    public function render(): string
    {
       return 
            "<button type='submit' " . 
            $this->renderAttributes() . 
            ">{$this->text}</button>";  
    }
}