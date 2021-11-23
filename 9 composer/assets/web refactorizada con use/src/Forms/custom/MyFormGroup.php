<?php
namespace ProyectoWeb\Forms\custom;

use ProyectoWeb\Forms\CompoundElement;

class MyFormGroup extends CompoundElement
{
    private $container;
    public function __construct(array $formElements ){
        $this->container = new CompoundElement('', 'div');
        $this->container->setCssClass("form-group");
        foreach($formElements as $formElement) {
            $this->container->appendChild($formElement);
        }        
        $this->appendChild($this->container);
    }
    public function render(): string{
        return $this->container->render();
    }
    public function validate(){
        $this->container->validate();
    }
    public function hasError(): bool{
        return $this->container->hasError();
    }
    public function getErrors(): array
    {
        return $this->container->getErrors();
    }
}