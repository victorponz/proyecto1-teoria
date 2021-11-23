<?php

abstract class Element
{
    
    /**
     * Id del Elemento
     * @var string
     */
    private $id;

    /**
     * Clase css del Elemento
     * @var string
     */
    private $cssClass;
    
    /**
     * @var string
     */
    private $style;
   
     /**
     * Tipo del input
     *
     * @var string
     */
    private $type;
    
    public function __construct(string $type, string $id = '', string $cssClass  = '', string $style = '')
    {
        $this->type = $type;
        $this->id = $id;
        $this->cssClass = $cssClass;
        $this->style = $style;
    }
    /**
     * Get the value of id
     *
     * @return  string
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  string  $id
     *
     * @return  self
     */ 
    public function setId(string $id): Element
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of cssClass
     *
     * @return  string
     */ 
    public function getCssClass()
    {
        return $this->cssClass;
    }
    /**
     * Set the value of class
     *
     * @param  string  $class
     *
     * @return  self
     */ 
    public function setCssClass(string $cssClass): Element
    {
        $this->cssClass = $cssClass;

        return $this;
    }


    /**
     * Get the value of style
     *
     * @return  string
     */ 
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set the value of style
     *
     * @param  string  $style
     *
     * @return  self
     */ 
    public function setStyle(string $style): Element
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Get tipo del input
     *
     * @return  string
     */ 
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * Genera el código HTML del elemento
     *
     * @return string
     */
    abstract public function render(): string;
 
    /**
     * Genera el HTML para los atributos comunes
     *
     * @return string
     */
    protected function renderAttributes(): string
    {
        $html = (!empty($this->id) ? " id='$this->id' " : '');
        $html .= (!empty($this->cssClass) ? " class='$this->cssClass' " : '');
        $html .= (!empty($this->style) ? " style='$this->style' " : '');
        return $html;
    }

}