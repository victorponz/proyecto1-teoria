<?php
namespace ProyectoWeb\Forms;

use ProyectoWeb\Forms\InputElement;

class RadioElement extends InputElement
{
    /**
     * Texto de la opción
     *
     * @var string
     */
    private $text;

    /**
     * Seleccionado por defecto?
     *
     * @var bool
     */
    private $checked;

    public function __construct(string $name, string $text, bool $checked = false, string $id = '', string $cssClass  = '', string $style = '')
	{
       $this->text = $text;
       $this->checked = $checked;
       parent::__construct($name, 'radio', $id, $cssClass, $style);
    }

    public function isChecked(){
        if ('POST' === $_SERVER['REQUEST_METHOD']) {
            return ($this->getValue() == $this->getDefaultValue());
        } else {
            return $this->checked;
        }
	}

    /**
     * Genera el HTML del elemento
     *
     * @return string
     */
    public function render(): string
    {
        $this->setPostValue();
        $html = "<input type='radio' " ;
        $html .= $this->renderAttributes(); 
        $html .= " value='{$this->getDefaultValue()}'";
        $html .= ($this->isChecked() ? ' checked' : '');
        $html .= '>' . $this->text;
        return $html;
    }


}