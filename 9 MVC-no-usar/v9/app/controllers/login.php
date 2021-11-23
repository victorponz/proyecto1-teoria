<?php
    session_start();
    $title = "Login";
    require_once "./utils/utils.php";
    require_once "./Forms/FormElement.php";
    require_once "./Forms/PasswordElement.php";
    require_once "./Forms/ButtonElement.php";
    require_once "./Forms/custom/MyFormControl.php";
    require_once "./entity/Usuario.php";
    require_once "./repository/UsuarioRepository.php";
    require_once "./security/BCryptPasswordGenerator.php";

    $info = "";
    
    $repositorio = new UsuarioRepository(new BCryptPasswordGenerator());

    $nombreUsuario = new InputElement('username', 'text', 'username');
    $userWrapper = new MyFormControl($nombreUsuario, 'Nombre de usuari@', 'col-xs-12');

    $pass = new PasswordElement('password', 'password');

    $passWrapper = new MyFormControl($pass, 'Contraseña', 'col-xs-12');

    //En este caso puede venir en el POST (formulario) o en el GET (enlace)
    $hrefReturnToUrl = '';
    if (isset($_GET['returnToUrl'])) {
        $hrefReturnToUrl = $_GET['returnToUrl'];
    } else  if (isset($_POST['returnToUrl'])) {
        $hrefReturnToUrl = $_POST['returnToUrl'];
    }
    $returnToUrl = new InputElement('returnToUrl', 'hidden');
    $returnToUrl->setDefaultValue($hrefReturnToUrl);

    $b = new ButtonElement('Login', '', '' , 'pull-right btn btn-lg sr-button');
    
    $form = new FormElement();
    $form
    ->appendChild($userWrapper)
    ->appendChild($passWrapper)
    ->appendChild($returnToUrl)
    ->appendChild($b);
    if (!isset($_SESSION['username'])) {
        if ("POST" === $_SERVER["REQUEST_METHOD"]) {
            $form->validate();
            if (!$form->hasError()) {
            try { 
                $usuario = $repositorio->findByUserNameAndPassword($nombreUsuario->getValue(), $pass->getValue());
                $_SESSION['username'] = $nombreUsuario->getValue();
                if (!empty($hrefReturnToUrl)) {
                    header('location: ' . $hrefReturnToUrl);
                } else {
                    header('location: /');
                }
            }catch(QueryException $qe) {
                $form->addError($qe->getMessage());
            }catch(NotFoundException $nfe){
                /************************ CUIDADO *****************/
                /*
                Hay que tratar antes NotFoundException que la excepción general
                Exception, sino siempre entrará por esta última
                */
                $form->addError("Credenciales incorrectas");
            }catch(Exception $err) {
                $form->addError($err->getMessage());
            }
            }
        }
    }
    include("app/views/login.view.php");