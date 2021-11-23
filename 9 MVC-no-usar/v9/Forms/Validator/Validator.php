<?php
abstract class Validator{

    /**
     * Texto del mensaje de error de validación
     *
     * @var string
     */
    private $message;

    /**
     * Siguiente elemento en la cadena de responsabilidad
     *
     * @var Validator
     */
    private $nextValidator;
    

    /**
     * Si es true, se para la cadena de responsabilidad
     *
     * @var bool
     */
    private $last;

    /**
     * Datos a los que aplicar la validación
     *
     * @var string
     */
    private $data;

    /**
     * Errores de validación
     *
     * @var array
     */
    private $errors;
    
    /**
     * @param string $message Mensaje que muestra si no pasa la validación
     * @param boolean $last Si es true, no llama al siguiente validador
     */
    public function __construct(string $message, bool $last = false) {
        $this->message = $message;
        $this->last = $last;
        $this->errors = [];
    }

    /**
     * Get datos a los que aplicar la validación
     *
     * @return  string
     */ 
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the value of data
     *
     * @return  self
     */ 
    public function setData($data) {
        $this->data = $data;

        return $this;
    }
    
    /**
     * Fija el siguiente validador en la cadena de validación
     * @param AbstractValidator
     */
    public function setNextValidator(Validator $nextValidator) {
        $nextValidator->setData($this->data);
        $this->nextValidator = $nextValidator;
        return $this;
    }

    /**
     * Implementa la cadena de validación y fija los errores de validación
     *
     * @return void
     */
    public function validate() {
        $this->doValidate();
        //Debemos continuar la cadena?
        if ((!($this->last && $this->hasError())) 
            && $this->nextValidator != null){
            $this->nextValidator->setData($this->data);
            $this->nextValidator->validate();
            if ($this->nextValidator->hasError()) {
                $this->errors = array_merge($this->errors, $this->nextValidator->getErrors());
            }
            
        }
 
    }

    /**
     * Tiene errores?
     *
     * @return boolean
     */
    public function hasError(): bool {
        return (count($this->errors) > 0);
    }

    /**
     * Devuelve los errores de validación
     *
     * @return array
     */
    public function getErrors(): array{
        return $this->errors;
    }
    
    /**
     * Añade el mensaje de error al array
     *
     * @return void
     */
    public function appendError() {
        $this->errors[] = $this->message;
    }
    /**
     * Devuelve true si pasa la validación. False en caso contrario
     * Este método es el único que deben implementar todos los validadores.
     *
     * @return boolean
     */
    abstract public function doValidate(): bool;
    
}