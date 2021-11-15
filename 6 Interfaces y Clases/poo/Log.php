<?php

trait Log
{
    static protected $mensajes = [];

    static protected function nuevoMensaje(string $mensaje)
    {
        self::$mensajes[] = $mensaje;
    }

    static public function muestraLog()
    {
        echo 'textos página: <br>';
        foreach (self::$mensajes as $mensaje)
            echo $mensaje . '<br>';
    }
}