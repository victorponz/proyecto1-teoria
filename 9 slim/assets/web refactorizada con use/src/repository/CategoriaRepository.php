<?php
namespace ProyectoWeb\repository;

use ProyectoWeb\database\QueryBuilder;
use ProyectoWeb\entity\Categoria;

class CategoriaRepository extends QueryBuilder
{
    public function __construct(){
        parent::__construct('categorias', 'Categoria');
    }

    /**
     * @param Categoria $categoria
     * @throws QueryException
     */
    public function nuevaImagen(Categoria $categoria)
    {
        $categoria->setNumImagenes($categoria->getNumImagenes()+1);
        $this->update($categoria);
    }

}