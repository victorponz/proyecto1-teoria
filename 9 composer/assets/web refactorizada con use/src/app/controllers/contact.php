<?php
    $title = "Contact";
    require_once __DIR__ . "/../../utils/utils.php";
    use ProyectoWeb\Forms\InputElement;
    use ProyectoWeb\Forms\TextareaElement;
    use ProyectoWeb\Forms\EmailElement;
    use ProyectoWeb\Forms\ButtonElement;
    use ProyectoWeb\Forms\FormElement;
    use ProyectoWeb\Forms\custom\MyFormGroup;
    use ProyectoWeb\Forms\custom\MyFormControl;
    use ProyectoWeb\Forms\Validator\NotEmptyValidator;
    use ProyectoWeb\entity\Mensaje;
    use ProyectoWeb\repository\MensajeRepository;

 
    $info = "";
    $firstName = new InputElement('firstName', 'text', 'firstName');
    $firstName
      ->setValidator(new NotEmptyValidator('El campo first name no puede estar vacío', true));


    $lastName = new InputElement('lastName', 'text', 'lastName');

    $name = new MyFormGroup([new MyFormControl($firstName, "First Name"), new MyFormControl($lastName, "Last Name")]);

    $email = new EmailElement('email', 'email');
    
    $emailWrapper = new MyFormGroup([new MyFormControl($email, 'Correo', 'col-xs-12')]);


    $subject = new InputElement('subject', 'text', 'subject');
    $subject
      ->setValidator(new NotEmptyValidator('El campo asunto no puede estar vacío', true));

    $subjectWrapper = new MyFormGroup([new MyFormControl($subject, 'Asunto', 'col-xs-12')]);

    $message = new TextareaElement('message', 'message');

    $messageWrapper = new MyFormGroup([new MyFormControl($message, 'Mensaje', 'col-xs-12')]);

    $b = new ButtonElement('Send', '', '', 'pull-right btn btn-lg sr-button', '');

    $form = new FormElement();
    
    $form
     ->setCssClass('form-horizontal')
     ->appendChild($name)
     ->appendChild($emailWrapper)
     ->appendChild($subjectWrapper)
     ->appendChild($messageWrapper)
     ->appendChild($b);

     
     $repositorio = new MensajeRepository();

     if ("POST" === $_SERVER["REQUEST_METHOD"]) {
        $form->validate();
        if (!$form->hasError()) {
          $mensaje = new Mensaje($firstName->getValue(), $lastName->getValue(), $subject->getValue(), $email->getValue(), $message->getValue());
          $repositorio->save($mensaje);
          
          $info = "Mensaje insertado correctamente";
          $form->reset();
        }else{
          if ($firstName->hasError()) {
            $firstName->setCssClass($firstName->getCssClass() . ' has-error');
          }
          if ($subject->hasError()) {
            $subject->setCssClass($subject->getCssClass() . ' has-error');
          }
          if ($email->hasError()) {
            $email->setCssClass($email->getCssClass() . ' has-error');
          }
        }
    }
    include(__DIR__ . "/../views/contact.view.php");