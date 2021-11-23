<?php 
require_once __DIR__ .'/Entity.php';

class Asociado extends Entity
{
    const RUTA_IMAGENES_ASOCIADO = 'images/index/';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $logo;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @param string $nombre
     * @param string $logo
     * @param string $descripcion
     */
    public function __construct(string $nombre = '', string $logo = '', string $descripcion = ''){
        $this->id = null;
        $this->nombre = $nombre;
        $this->logo = $logo;
        $this->descripcion = $descripcion;
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
     * Get the value of logo
     *
     * @return  string
     */ 
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set the value of logo
     *
     * @param  string  $logo
     *
     * @return  self
     */ 
    public function setLogo(string $logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get the value of descripcion
     *
     * @return  string
     */ 
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @param  string  $descripcion
     *
     * @return  self
     */ 
    public function setDescripcion(string $descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Devuelve el path a las imágenes del asociado
     *
     * @return string
     */
    public function getUrlImagen() : string
    {
        return self::RUTA_IMAGENES_ASOCIADO . $this->getLogo();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'logo' => $this->getLogo(),
            'descripcion' => $this->getDescripcion()
        ];
    }
}