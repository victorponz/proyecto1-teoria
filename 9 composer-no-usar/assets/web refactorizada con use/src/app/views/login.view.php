<?php
  include __DIR__ . "/partials/inicio-doc.part.php";
  include __DIR__ . "/partials/nav.part.php";
  ?>
<div id="login">
    <div class="container">
        <div class="col-xs-12 col-sm-8 col-sm-push-2">
            <h1>LOGIN</h1>
            <hr>
            <?php if (isset($_SESSION['username'])) :?>
                Ya está logeado como <?=$_SESSION['username']?>
            <?php else: ?>
                <?php
                    include __DIR__ . "/partials/show-messages.part.php";
                ?>
                <?=$form->render();?>
                <a href='/register<?=(!empty($hrefReturnToUrl) ? '?returnToUrl=' . $hrefReturnToUrl : '')?>'>
                    ¿Todavía no está registrad@?
                </a>
            <?php endif?>
        </div>
    </div>

</div>

<?php
  include __DIR__ . "/partials/fin-doc.part.php";
?>