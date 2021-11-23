<?php
    if (!isset($_SESSION['username'])) {
      header('location: /login?returnToUrl=/asociados');
    }
    $title = "Asociados";
    require_once __DIR__ . "/../../utils/utils.php";

    use ProyectoWeb\core\App;
    use ProyectoWeb\Forms\InputElement;
    use ProyectoWeb\Forms\LabelElement;
    use ProyectoWeb\Forms\TextareaElement;
    use ProyectoWeb\Forms\ButtonElement;
    use ProyectoWeb\Forms\FileElement;
    use ProyectoWeb\Forms\FormElement;
    use ProyectoWeb\Forms\custom\MyFormControl;
    use ProyectoWeb\Forms\Validator\NotEmptyValidator;
    use ProyectoWeb\Forms\Validator\MimetypeValidator;
    use ProyectoWeb\Forms\Validator\MaxSizeValidator;
    use ProyectoWeb\entity\Asociado;
    use ProyectoWeb\repository\AsociadoRepository;
     
    require_once __DIR__ . "/../../utils/SimpleImage.php";
    
    $info = $urlImagen = "";

    $nombre = new InputElement('nombre', 'text', 'nombre');
    $nombre
     ->setValidator(new NotEmptyValidator('El nombre es obligatorio', true));
    $nombreWrapper = new MyFormControl($nombre, 'Nombre', 'col-xs-12');

    $description = new TextareaElement('descripcion', 'descripcion');

    $descriptionWrapper = new MyFormControl($description, 'Descripción', 'col-xs-12');

    $fv = new MimetypeValidator(['image/jpeg', 'image/jpg', 'image/png'], 'Formato no soportado', true);
    $fv->setNextValidator(new MaxSizeValidator(2 * 1024 * 1024, 'El archivo no debe exceder 2M', true));

    $file = new FileElement('imagen', 'imagen');
    $file
      ->setValidator($fv);

    $labelFile = new LabelElement('Imagen', $file);

    $b = new ButtonElement('Send', '', '', 'pull-right btn btn-lg sr-button', '');

    $form = new FormElement('', 'multipart/form-data');
    $form
    ->setCssClass('form-horizontal')
    ->appendChild($labelFile)
    ->appendChild($file)
    ->appendChild($nombreWrapper)
    ->appendChild($descriptionWrapper)
    ->appendChild($b);

    $repositorio = new AsociadoRepository();

    if ("POST" === $_SERVER["REQUEST_METHOD"]) {
        $form->validate();
        if (!$form->hasError()) {
          try {
            $file->saveUploadedFile(APP::get('rootDir') . Asociado::RUTA_IMAGENES_ASOCIADO);  
              // Create a new SimpleImage object
              $simpleImage = new \claviska\SimpleImage();
              $simpleImage
              ->fromFile(Asociado::RUTA_IMAGENES_ASOCIADO . $file->getFileName())  
              ->resize(50, 50)
              ->toFile(Asociado::RUTA_IMAGENES_ASOCIADO . $file->getFileName());
              $info = 'Imagen enviada correctamente'; 
              $urlImagen = Asociado::RUTA_IMAGENES_ASOCIADO . $file->getFileName();
              $asociado = new Asociado($nombre->getValue(), $file->getFileName(), $description->getValue());
              $repositorio->save($asociado);
              $form->reset();
            
          }catch(Exception $err) {
              $form->addError($err->getMessage());
              $imagenErr = true;
          }
        }else{
          
        }
    }   
    try {
      $asociados = $repositorio->findAll();
    }catch(QueryException $qe) {
      $asociados = [];
      echo $qe->getMessage();
      //En este caso podríamos generar un mensaje de log o parar el script mediante die($qe->getMessage())
    } 
    include(__DIR__ . "/../views/asociados.view.php");