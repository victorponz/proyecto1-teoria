<?php
require_once __DIR__ . '/../entity/Categoria.php';
require_once __DIR__ . '/../database/QueryBuilder.php';
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