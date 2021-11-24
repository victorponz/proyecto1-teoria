<?php
  include __DIR__ . "/partials/inicio-doc.part.php";
  include __DIR__ . "/partials/nav.part.php";
  ?>
<div id="galeria">
    <div class="container">
        <div class="col-xs-12 col-sm-8 col-sm-push-2">
            <h1>GALERÍA</h1>
            <hr>
            <?php
                include __DIR__ . "/partials/show-messages.part.php";
            ?>
            <?php if (("POST" === $_SERVER["REQUEST_METHOD"]) && (!$form->hasError())) : ?>
                <a href='<?=$urlImagen?>' target='_blank'>Ver Imagen</a>
            <?php endif; ?>
           <?=$form->render();?>
           <hr class="divider">
            <div class="imagenes_galeria">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Visualizaciones</th>
                        <th scope="col">Likes</th>
                        <th scope="col">Descargas</th>
                        <th scope="col">Categoría</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($imagenes as $imagen): ?>
                        <tr>
                            <th scope="row"><?= $imagen->getId(); ?></th>
                            <td>
                                <img src="<?= $imagen->getUrlGallery(); ?>"
                                    alt="<?= $imagen->getDescripcion(); ?>"
                                    title="<?= $imagen->getDescripcion(); ?>"
                                    width="100px">
                            </td>
                            <td><?= $imagen->getNumVisualizaciones(); ?></td>
                            <td><?= $imagen->getNumLikes(); ?></td>
                            <td><?= $imagen->getNumDownloads(); ?></td>
                            <td><?= $repositorio->getCategoria($imagen)->getNombre(); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php
  include __DIR__ . "/partials/fin-doc.part.php";
?>