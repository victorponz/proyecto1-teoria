<?php
require_once __DIR__ . "/CompoundElement.php";
require_once __DIR__ . "/DataElement.php";

class LabelElement extends CompoundElement
{
    /**
     * Texto de la etiqueta
     *
     * @var string
     */
    private $text;
    
    /**
     * Elemento del form al que va asociado la etiqueta
     *
     * @var Element
     */
    private $for;
    
    /**
     * Si es verdadero, renderizamos el elemento asociado en $for
     * @link https://developer.mozilla.org/es/docs/Web/HTML/Elemento/label
     * 
     * @var bool
     */
    private $renderElement;

    public function __construct(string $text, DataElement $for, bool $renderElement = false, string $id = '', string $cssClass  = '', string $style = '')
    {
        $this->text = $text;
        $this->for = $for;
        $this->renderElement = $renderElement;
        parent::__construct('label', $id, $cssClass, $style);
        if ($renderElement) {
            $this->appendChild($for);
        }
    }
    /**
     * Además de renderizar el label, también renderiza el elemento asociado
     *
     * @return string
     */
    public function render(): string
    {
      return 
            "<label " . 
            (!empty($this->for) ? " for='{$this->for->getId()}' " : '') .
            $this->renderAttributes() .
            ">{$this->text} " . "</label>" . $this->renderChildren();
    
    }
}