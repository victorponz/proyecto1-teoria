<?php

abstract class ElementoHTMLConTexto extends ElementoHTMLSimple
{
    private $texto;

    public function __construct($nombre, $texto)
    {
        parent::__construct($nombre);
        $this->texto = $texto;
    }

    public function __toString()
    {
        self::nuevoMensaje($this->texto);

        $etiqueta = parent::__toString();
        $etiqueta .= $this->texto;
        $etiqueta .= '</' . $this->nombre . '>';

        return $etiqueta;
    }
}