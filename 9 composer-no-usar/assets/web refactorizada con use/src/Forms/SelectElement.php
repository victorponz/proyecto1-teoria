<?php
namespace ProyectoWeb\Forms;

use ProyectoWeb\Forms\CompoundElement;

class SelectElement extends CompoundElement
{
    /**
     * Es un select múltiple?
     * @var bool
     */
    private $multiple;
    
    public function __construct(string $name, bool $multiple = false, string $id = '', string $cssClass  = '', string $style = '')
	{
       $this->multiple = $multiple;
       parent::__construct($name, 'select', $id, $cssClass, $style);
    }
    /**
     *
     * @return boolean
     */
    public function isMultiple(): bool
    {
        return ($this->multiple === true);
    }
     /**
     * Protección ante hackeos
     *
     * @return mixed
     */
    public function sanitizeInput() {
       
        if ($this->isMultiple()) {
            //En este caso es un array
            if (!empty($_POST[$this->getName()])){
                foreach ($_POST[$this->getName()] as $key => $data){
                    $_POST[$this->getName()][$key] = htmlspecialchars(stripslashes(trim($data)));
                }
                return $_POST[$this->getName()];
            }
        }else{
            return parent::sanitizeInput();
        }
        return "";
    }
    
    /**
     * Devuelve los options seleccionados
    *
    * @return array
    */
    public function getSelected(): array{
    $values = [];
    foreach ($this->getChildren() as $child) {
        if ($child->isSelected()) {
            $values[] = $child->getDefaultValue();
        }

    }  
    return $values;
    }

    /**
     * Genera el HTML para los atributos comunes
     *
     * @return string
     */
    protected function renderAttributes(): string
    {
        $html = (!empty($this->getName()) ? " name='{$this->getName()}" . ($this->isMultiple() ? "[]'" : "'") :  "");
        $html .= Element::renderAttributes();
        return $html;
    }

    public function render(): string
    {
        $this->setPostValue();
        //Si es múltiple, hemos de añadir [] para que el valor del POST sea un array
        $html = "<select " ;
            $html .= $this->renderAttributes(); 
            $html .= ($this->isMultiple() ? " multiple " : '');
            $html .= ">";
            $html .= $this->renderChildren();
        $html .= '</select>';  
        return $html;
    }

     /**
     * Valida el campo según los criterios del validador
     * Es un caso especial porque aunque tenga hijos, estos no tienen validador (hereda de CompoundElement)
     * @return void
     */
    public function validate()
    {
        $this->setPostValue();
        if (!empty($this->getValidator())) {
            $this->validator->setData($this->getValue());
            $this->validator->validate();
            $this->errors = array_merge($this->errors, $this->validator->getErrors());
        }
    }
}