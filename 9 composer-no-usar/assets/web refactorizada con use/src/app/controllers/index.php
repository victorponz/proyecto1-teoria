<?php
    $title = "Home";
    require_once __DIR__ . "/../../utils/utils.php";
    use ProyectoWeb\entity\ImagenGaleria;
    use ProyectoWeb\entity\Asociado;

    $galeria[] = new ImagenGaleria("1.jpg", "Descripción imagen 1", 1, 5, 6);
    $galeria[] = new ImagenGaleria("2.jpg", "Descripción imagen 2", 3, 4, 5);
    $galeria[] = new ImagenGaleria("3.jpg", "Descripción imagen 3", 4, 6, 1);
    $galeria[] = new ImagenGaleria("4.jpg", "Descripción imagen 4", 3, 5, 8);
    $galeria[] = new ImagenGaleria("5.jpg", "Descripción imagen 5", 4, 8, 2);
    $galeria[] = new ImagenGaleria("6.jpg", "Descripción imagen 6", 6, 9, 8);
    $galeria[] = new ImagenGaleria("7.jpg", "Descripción imagen 7", 9, 10, 16);
    $galeria[] = new ImagenGaleria("8.jpg", "Descripción imagen 8", 10, 1, 56);
    $galeria[] = new ImagenGaleria("9.jpg", "Descripción imagen 9", 11, 3, 66);
    $galeria[] = new ImagenGaleria("10.jpg", "Descripción imagen 10", 14, 5, 3);
    $galeria[] = new ImagenGaleria("11.jpg", "Descripción imagen 11", 13, 4, 0);
    $galeria[] = new ImagenGaleria("12.jpg", "Descripción imagen 11", 15, 1, 1);

    $asociados[] = new Asociado("First Partner Name", "log1.jpg", "First Partner Name");
    $asociados[] = new Asociado("Second Partner Name", "log2.jpg", "Second Partner Name");
    $asociados[] = new Asociado("Third Partner Name", "log3.jpg", "Third Partner Name");
    $asociados[] = new Asociado("Fourth Partner Name", "log1.jpg", "Fourth Partner Name");
    $asociados = getAsociados($asociados);

    include(__DIR__ . "/../views/index.view.php");