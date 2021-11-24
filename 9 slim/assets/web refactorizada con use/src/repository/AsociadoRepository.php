<?php
namespace ProyectoWeb\repository;

use ProyectoWeb\database\QueryBuilder;

class AsociadoRepository extends QueryBuilder
{
    public function __construct(){
        parent::__construct('asociados', 'Asociado');
    }

}