<?php
require_once __DIR__ .'/Entity.php';
require_once __DIR__ .'/Categoria.php';
class ImagenGaleria extends Entity
{
    const RUTA_IMAGENES_PORTFOLIO = 'images/index/portfolio/';
    const RUTA_IMAGENES_GALLERY = 'images/index/gallery/';

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
    private $descripcion;
    
    /**
     * @var int
     */
    private $numVisualizaciones;
    
    /**
     * @var int
     */
    private $numLikes;

    /**
     * @var int
     */
    private $numDownloads;
    
    /**
     * @var int
     */
    private $categoria;
    

    public function __construct(string $nombre = '', string $descripcion = '',
                                int $numVisualizaciones = 0, int $numLikes = 0,
                                int $numDownloads = 0, int $categoria = 0){
        $this->id = null;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->numVisualizaciones = $numVisualizaciones;
        $this->numLikes = $numLikes;
        $this->numDownloads = $numDownloads;
        $this->categoria = $categoria;
    }

    /**
     * @return int|null
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
     * Get the value of numVisualizaciones
     *
     * @return  int
     */ 
    public function getNumVisualizaciones()
    {
        return $this->numVisualizaciones;
    }

    /**
     * Set the value of numVisualizaciones
     *
     * @param  int  $numVisualizaciones
     *
     * @return  self
     */ 
    public function setNumVisualizaciones(int $numVisualizaciones)
    {
        $this->numVisualizaciones = $numVisualizaciones;

        return $this;
    }

    /**
     * Get the value of numLikes
     *
     * @return  int
     */ 
    public function getNumLikes()
    {
        return $this->numLikes;
    }

    /**
     * Set the value of numLikes
     *
     * @param  int  $numLikes
     *
     * @return  self
     */ 
    public function setNumLikes(int $numLikes)
    {
        $this->numLikes = $numLikes;

        return $this;
    }

    /**
     * Get the value of numDownloads
     *
     * @return  int
     */ 
    public function getNumDownloads()
    {
        return $this->numDownloads;
    }

    /**
     * Set the value of numDownloads
     *
     * @param  int  $numDownloads
     *
     * @return  self
     */ 
    public function setNumDownloads(int $numDownloads)
    {
        $this->numDownloads = $numDownloads;

        return $this;
    }
    
    /**
     * Get the value of categoria
     *
     * @return  int
     */ 
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set the value of categoria
     *
     * @param  int  $categoria
     *
     * @return  self
     */ 
    public function setCategoria(int $categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }
    /**
     * Devuelve el path a las imágenes del portfolio
     *
     * @return string
     */
    public function getUrlPortfolio() : string
    {
        return self::RUTA_IMAGENES_PORTFOLIO . $this->getNombre();
    }

    /**
     * Devuelve el path a las imágenes de la galería
     *
     * @return string
     */
    public function getUrlGallery() : string
    {
        return self::RUTA_IMAGENES_GALLERY . $this->getNombre();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'descripcion' => $this->getDescripcion(),
            'numVisualizaciones' => $this->getNumVisualizaciones(),
            'numLikes' => $this->getNumLikes(),
            'numDownloads' => $this->getNumDownloads(),
            'categoria' => $this->getCategoria()
        ];
    }

}