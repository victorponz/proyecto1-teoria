<?php
namespace ProyectoWeb\Forms\Validator;

use ProyectoWeb\Forms\Validator\Validator;

interface IValidator
{
    public function getValidator();

    public function setValidator(Validator $validator);
  
    public function validate();

    public function hasError(): bool;
    
    public function getErrors(): array;

    public function appendValidator(Validator $validator);
}