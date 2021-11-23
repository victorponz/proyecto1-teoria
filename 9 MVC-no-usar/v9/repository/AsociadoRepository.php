<?php
require_once __DIR__ . '/../database/QueryBuilder.php';

class AsociadoRepository extends QueryBuilder
{
    public function __construct(){
        parent::__construct('asociados', 'Asociado');
    }

}