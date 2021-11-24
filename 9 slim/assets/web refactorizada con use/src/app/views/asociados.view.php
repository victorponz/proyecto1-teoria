<?php
  include __DIR__ . "/partials/inicio-doc.part.php";
  include __DIR__ . "/partials/nav.part.php";
  ?>
<div id="asociados">
    <div class="container">
        <div class="col-xs-12 col-sm-8 col-sm-push-2">
            <h1>ASOCIADOS</h1>
            <hr>
            <?php
                include __DIR__ . "/partials/show-messages.part.php";
            ?>
            <?php if (("POST" === $_SERVER["REQUEST_METHOD"]) && (!$form->hasError())) : ?>
                <a href='<?=$urlImagen?>' target='_blank'>Ver Imagen</a>
            <?php endif; ?>
           <?=$form->render();?>
           <hr class="divider">
            <div class="asociados">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Logo</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($asociados as $asociado): ?>
                        <tr>
                            <th scope="row"><?= $asociado->getId(); ?></th>
                            <td><?= $asociado->getNombre(); ?></td>
                            <td><?= $asociado->getDescripcion(); ?></td>
                            <td>
                                <img src="<?= $asociado->getUrlImagen(); ?>"
                                     alt="<?= $asociado->getDescripcion(); ?>"
                                     title="<?= $asociado->getDescripcion(); ?>"
                                >
                            </td>
                           
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