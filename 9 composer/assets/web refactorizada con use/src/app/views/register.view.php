<?php
  include __DIR__ . "/partials/inicio-doc.part.php";
  include __DIR__ . "/partials/nav.part.php";
  ?>
<div id="register">
    <div class="container">
        <div class="col-xs-12 col-sm-8 col-sm-push-2">
            <h1>REGISTRO</h1>
            <hr>
                <?php
                    include __DIR__ . "/partials/show-messages.part.php";
                ?>
                <?=$form->render();?>
                <a href='/login<?=(!empty($hrefReturnToUrl) ? '?returnToUrl=' . $hrefReturnToUrl : '')?>'>
                    ¿Ya eres miembro? Acceso a usuarios
                </a>
        </div>
    </div>

</div>

<?php
  include __DIR__ . "/partials/fin-doc.part.php";
?>