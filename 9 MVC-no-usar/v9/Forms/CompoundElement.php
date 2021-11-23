<?php
require_once __DIR__ . "/DataElement.php";

class CompoundElement extends DataElement
{
    /**
     * Hijos del elemento
     *
     * @var array
     */
    private $children;

    /**
     * Errores de validación del elemento
     *
     * @var array
     */
    private $errors;

    public function __construct(string $name, string $type, string $id = '', string $cssClass  = '', string $style = '')
	{
        $this->children = [];
        $this->errors = [];
        parent::__construct($name, $type, $id, $cssClass, $style);
    }

    /**
     * @param Element $child
     * @return void
     */
    public function appendChild(Element $child){
        $this->children[] = $child;
        return $this;
    }
    /**
     *
     * @return array
     */
    public function getChildren(): array{
        return $this->children;
    }

    /**
     * Recorre todos los hijos, generando su HTML
     *
     * @return El HTMl de todos los hijos
     */
    protected function renderChildren(): string{
        $html = '';
        foreach ($this->getChildren() as $child) {
            $html .= $child->render();
        }
        return $html;
    }

    /**
     * Valida todos los elementos hijos
     *
     * @return void
     */
    public function validate()
    {
        foreach ($this->getChildren() as $child) {
            if (is_subclass_of($child, "DataElement")) {
                $child->validate();
                if ($child->hasError()){
                    $this->errors = array_merge($this->errors, $child->getErrors());
                }	
            }
        } 
    }

    public function hasError(): bool
    {
        return (count($this->errors) > 0);
    }
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Permite añadir un error programáticamente
     *
     * @param string $error
     * @return void
     */
    public function addError(string $error){
        $this->errors[] = $error;
    }

    /**
     * Devuelve a su valor por defecto a todos los campos hijos
     *
     * @return void
     */
    public function reset()
    {
        foreach ($this->getChildren() as $child) {
            if (is_subclass_of($child, "DataElement")) {
                $child->reset();
            }
        } 
    }

    /**
     * Renderizamos por defecto el elemento y todos sus hijos
     *
     * @return string
     */
    public function render(): string
    {
        $html = 
            "<{$this->getType()} " . 
            $this->renderAttributes() .
            ">";
                $html .= $this->renderChildren();
             
        $html .= "</{$this->getType()}>"; 
        return $html;
    }   

}