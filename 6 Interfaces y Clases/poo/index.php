<?php
    require 'PaginaHTML.php';

    $hr = new ElementoHR();
    $div = new ElementoDiv();
    $div->style = 'border: 1px solid black; padding : 10px';
    $parrafo = new ElementoParrafo($div->style);
    $div->nuevoHijo($parrafo);

    $paginaHtml = new PaginaHTML();
    $paginaHtml->nuevoHijo($div);
    $paginaHtml->nuevoHijo($hr);
    $paginaHtml->nuevoHijo($div);

    echo $paginaHtml;

    PaginaHTML::muestraLog();
?>