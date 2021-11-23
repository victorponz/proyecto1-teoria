<?php
require_once __DIR__ . '/../database/QueryBuilder.php';

class MensajeRepository extends QueryBuilder
{
    public function __construct() {
        parent::__construct('mensajes', 'Mensaje');
    }

}