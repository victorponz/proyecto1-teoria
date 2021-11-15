<?php

require 'IElementoHTML.php';
require 'Log.php';

abstract class ElementoHTML implements IElementoHTML
{
    use Log;

    protected $nombre;
    protected $atributos;

    public function __construct(string $nombre)
    {
        $this->nombre = $nombre;
        $this->atributos = [];
    }

    public function __set(string $name, $value)
    {
        $this->atributos[$name] = $value;
    }

    public function __get(string $name)
    {
        return $this->atributos[$name];
    }

    abstract public function __toString();
}