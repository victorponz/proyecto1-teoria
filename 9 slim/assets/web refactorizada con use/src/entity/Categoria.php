<?php
namespace ProyectoWeb\entity;

use ProyectoWeb\entity\Entity;

class Categoria extends Entity
{
     /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var int
     */
    private $numImagenes;

    public function __construct(string $nombre = '', int $numImagenes = 0){
        $this->id = null;
        $this->nombre = $nombre;
        $this->numImagenes = $numImagenes;

    }

    /**
     * Get the value of id
     *
     * @return  int
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  int  $id
     *
     * @return  self
     */ 
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombre
     *
     * @return  string
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @param  string  $nombre
     *
     * @return  self
     */ 
    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of numImagenes
     *
     * @return  int
     */ 
    public function getNumImagenes()
    {
        return $this->numImagenes;
    }

    /**
     * Set the value of numImagenes
     *
     * @param  int  $numImagenes
     *
     * @return  self
     */ 
    public function setNumImagenes(int $numImagenes)
    {
        $this->numImagenes = $numImagenes;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'numImagenes' => $this->getNumImagenes()
        ];
    }
}