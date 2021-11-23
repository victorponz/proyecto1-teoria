<?php
include_once __DIR__ . '/../exceptions/NotFoundException.php';

class Router
{
    /**
     * Rutas definidas
     *
     * @var array
     */
    private $routes;

    public  function __construct(array $routes) {
        $this->routes = $routes;
    }
    
    public function direct($uri): string {
        if (array_key_exists($uri, $this->routes))
            return $this->routes[$uri];
       
        throw new NotFoundException('No se ha definido una ruta para esta URI');
    }

}