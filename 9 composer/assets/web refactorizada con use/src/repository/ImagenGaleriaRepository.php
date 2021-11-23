<?php
namespace ProyectoWeb\repository;

use ProyectoWeb\entity\Entity;
use ProyectoWeb\database\QueryBuilder;
use ProyectoWeb\entity\ImagenGaleria;
use ProyectoWeb\entity\Categoria;
use ProyectoWeb\repository\CategoriaRepository;

class ImagenGaleriaRepository extends QueryBuilder
{
    public function __construct(){
        parent::__construct('imagenes', 'ImagenGaleria');
    }

    public function getCategoria(ImagenGaleria $imagenGaleria): Categoria
    {
        $repositorioCategoria = new CategoriaRepository();
        return $repositorioCategoria->findById($imagenGaleria->getCategoria());
    }

        /**
     * @param Entity $imagenGaleria
     * @throws QueryException
     */
    public function save(Entity $imagenGaleria)
    {
        $fnGuardaImagen = function () use ($imagenGaleria){
            $categoria = $this->getCategoria($imagenGaleria);
            $categoriaRepositorio = new CategoriaRepository();
            $categoriaRepositorio->nuevaImagen($categoria);
            parent::save($imagenGaleria);
        };
        $this->executeTransaction($fnGuardaImagen);
    }

}