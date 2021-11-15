<?php
require_once 'Log.php';

abstract class ElementoHTMLCompuesto extends ElementoHTMLSimple
{
    private $hijos;

    public function __construct(string $nombre)
    {
        parent::__construct($nombre);
        $this->hijos = [];
    }

    public function nuevoHijo(IElementoHTML $hijo)
    {
        $this->hijos[] = $hijo;
    }

    public function __toString()
    {
        $etiqueta = parent::__toString();
        foreach ($this->hijos as $hijo)
            $etiqueta .= $hijo;
        $etiqueta .= '</' . $this->nombre . '>';

        return $etiqueta;
    }
}