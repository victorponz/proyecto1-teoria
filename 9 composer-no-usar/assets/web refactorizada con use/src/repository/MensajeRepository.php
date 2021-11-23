<?php
namespace ProyectoWeb\repository;

use ProyectoWeb\database\QueryBuilder;

class MensajeRepository extends QueryBuilder
{
    public function __construct() {
        parent::__construct('mensajes', 'Mensaje');
    }

}