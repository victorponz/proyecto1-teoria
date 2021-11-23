<?php
session_start();
$title = "Registro";
require_once "./utils/utils.php";
require_once "./Forms/FormElement.php";
require_once "./Forms/PasswordElement.php";
require_once "./Forms/ButtonElement.php";
require_once "./Forms/LabelElement.php";
require_once "./Forms/EmailElement.php";
require_once "./Forms/custom/MyFormControl.php";
require_once "./Forms/Validator/NotEmptyValidator.php";
require_once "./Forms/Validator/PasswordMatchValidator.php";
require_once "./Forms/Validator/MinLengthValidator.php";
require_once "./Forms/Validator/MinLowerCaseValidator.php";
require_once "./Forms/Validator/MinDigitValidator.php";
require_once "./entity/Usuario.php";
require_once "./repository/UsuarioRepository.php";
require_once "./security/BCryptPasswordGenerator.php";

$info = "";

$repositorio = new UsuarioRepository(new BCryptPasswordGenerator());

$nombreUsuario = new InputElement('username', 'text', 'username');
$nombreUsuario->setValidator(new NotEmptyValidator('El nombre de usuari@ no puede estar vacío', true));

$userWrapper = new MyFormControl($nombreUsuario, 'Nombre de usuari@', 'col-xs-12');

$email = new EmailElement('email', 'email');

$emailWrapper = new MyFormControl($email, 'Correo electrónico', 'col-xs-12');

$pv = new NotEmptyValidator('La contraseña no puede estar vacía', true);
$mlv = new MinLengthValidator(6, 'La contraseña debe tener al menos 6 caracteres', false);
$mlcv =  new MinLowerCaseValidator(2, 'La contraseña debe tener al menos 2 letras minúsculas', false);
$mdv =  new MinDigitValidator(2, 'La contraseña debe tener al menos 2 dígitos', false);

$mlcv->setNextValidator($mdv);
$mlv->setNextValidator($mlcv);
$pv->setNextValidator($mlv);

$pass = new PasswordElement('password', 'password');
$pass->setValidator($pv);

$passWrapper = new MyFormControl($pass, 'Contraseña', 'col-xs-12');

$repite = new PasswordElement('repite_password', 'repite_password');
$repite->setValidator(new PasswordMatchValidator($pass, 'Las contraseñas no coinciden', true));

$repiteWrapper = new MyFormControl($repite, 'Repita la contraseña', 'col-xs-12');

$b = new ButtonElement('Registro', '', '', 'pull-right btn btn-lg sr-button');

//En este caso vamos a hacer que siempre se pase por GET (enlace)
$hrefReturnToUrl = '';
if (isset($_GET['returnToUrl'])) {
  $hrefReturnToUrl = $_GET['returnToUrl'];
} 

$form = new FormElement((!empty($hrefReturnToUrl) ? '?returnToUrl=' . $hrefReturnToUrl : ''));
$form
  ->appendChild($userWrapper)
  ->appendChild($emailWrapper)
  ->appendChild($passWrapper)
  ->appendChild($repiteWrapper)
  ->appendChild($b);


  if ("POST" === $_SERVER["REQUEST_METHOD"]) {
    $form->validate();
    if (!$form->hasError()) {
      try {
          //Grabamos en la base de datos
          $usuario = new Usuario($nombreUsuario->getValue(), $email->getValue(), $pass->getValue());
          $repositorio->save($usuario);
          $_SESSION['username'] = $nombreUsuario->getValue();
          if (isset($_GET['returnToUrl'])) {
            header('location: ' . $_GET['returnToUrl']);
          } else if (isset($_POST['returnToUrl'])) {
            header('location: ' . $_POST['returnToUrl']);
          } else {
            header('location: /');
          }
      }catch(QueryException $qe) {
        $excepcion = $qe->getMessage();
        if ((strpos($excepcion, '1062') !== false)) {
          if ((strpos($excepcion, 'username') !== false)) {
            $form->addError('Ya existe un usuario registrado con dicho nombre de usuario');
          } else if ((strpos($excepcion, 'email') !== false)) {
            $form->addError('Ya existe un usuario registrado con dicho correo electrónico');
          } else {
            $form->addError($qe->getMessage());
          }
        } else {
          $form->addError($qe->getMessage());
        }
      }catch(Exception $err) {
          $form->addError($err->getMessage());
      }       
    }
  }

include("app/views/register.view.php");