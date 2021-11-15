<?php
require 'ElementoHTMLConTexto.php';

class ElementoParrafo extends ElementoHTMLConTexto
{
    public function __construct($texto)
    {
        parent::__construct('p', $texto);
    }
}