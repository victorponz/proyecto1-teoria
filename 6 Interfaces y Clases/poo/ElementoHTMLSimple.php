<?php
require 'ElementoHTML.php';

abstract class ElementoHTMLSimple extends ElementoHTML
{
    public function __toString()
    {
        $etiqueta = '<' . $this->nombre;

        foreach ($this->atributos as $key=>$value)
            $etiqueta .= ' ' . $key . '="' . $value . '"';

        $etiqueta .= '>';

        return $etiqueta;
    }
}