<?php
require_once 'ElementoHR.php';
require_once 'ElementoDiv.php';
require_once 'ElementoParrafo.php';
require_once 'ElementoHTMLCompuesto.php';

class PaginaHTML extends ElementoHTMLCompuesto
{
    public function __construct()
    {
        parent::__construct('html');
    }

    public function __toString()
    {
        $pagina = '<!doctype html>';

        $pagina .= parent::__toString();

        return $pagina;
    }
}