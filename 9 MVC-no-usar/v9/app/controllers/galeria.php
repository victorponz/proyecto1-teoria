<?php
    session_start();
    if (!isset($_SESSION['username'])) {
      header('location: /login?returnToUrl=/galeria');
    }
    $title = "Galería";
    require_once "./utils/utils.php";
    require_once "./Forms/TextareaElement.php";
    require_once "./Forms/ButtonElement.php";
    require_once "./Forms/FileElement.php";
    require_once "./Forms/FormElement.php";
    require_once "./Forms/SelectElement.php";
    require_once "./Forms/OptionElement.php";
    require_once "./Forms/custom/MyFormGroup.php";
    require_once "./Forms/custom/MyFormControl.php";
    require_once "./Forms/Validator/NotEmptyValidator.php";
    require_once "./Forms/Validator/MimetypeValidator.php";
    require_once "./Forms/Validator/MaxSizeValidator.php";    
    require_once "./exceptions/FileException.php";
    require_once "./utils/SimpleImage.php";
    require_once "./entity/ImagenGaleria.php";
    require_once "./repository/ImagenGaleriaRepository.php";
    require_once "./repository/CategoriaRepository.php";
    require_once "./core/App.php";
    
    $info = $urlImagen = "";

    $description = new TextareaElement('descripcion', 'descripcion');
    $description
     ->setValidator(new NotEmptyValidator('La descripción es obligatoria', true));
    $descriptionWrapper = new MyFormControl($description, 'Descripción', 'col-xs-12');

    $fv = new MimetypeValidator(['image/jpeg', 'image/jpg', 'image/png'], 'Formato no soportado', true);
    
    $fv->setNextValidator(new MaxSizeValidator(2 * 1024 * 1024, 'El archivo no debe exceder 2M', true));
    $file = new FileElement('imagen', 'imagen');
    $file
      ->setValidator($fv);

    $labelFile = new LabelElement('Imagen', $file);

    $repositorio = new ImagenGaleriaRepository();
    $repositorioCategoria = new CategoriaRepository();

    $categoriasEl = new SelectElement('categoria', false);

    $categorias = $repositorioCategoria->findAll();
    foreach ($categorias as $categoria) {
      $option = new OptionElement($categoriasEl, $categoria->getNombre());

      $option->setDefaultValue( $categoria->getId());
      
      $categoriasEl->appendChild($option);
    }
   
    $categoriaWrapper = new MyFormControl($categoriasEl, 'Categoría', 'col-xs-12');
    $b = new ButtonElement('Send', '', '', 'pull-right btn btn-lg sr-button', '');

    $form = new FormElement('', 'multipart/form-data');
    $form
    ->setCssClass('form-horizontal')
    ->appendChild($labelFile)
    ->appendChild($file)
    ->appendChild($descriptionWrapper)
    ->appendChild($categoriaWrapper)
    ->appendChild($b);

    
    if ("POST" === $_SERVER["REQUEST_METHOD"]) {
        $form->validate();
        if (!$form->hasError()) {
          try {
            $file->saveUploadedFile(ImagenGaleria::RUTA_IMAGENES_GALLERY);  
              // Create a new SimpleImage object
              $simpleImage = new \claviska\SimpleImage();
              $simpleImage
              ->fromFile(ImagenGaleria::RUTA_IMAGENES_GALLERY . $file->getFileName())  
              ->resize(975, 525)
              ->toFile(ImagenGaleria::RUTA_IMAGENES_PORTFOLIO . $file->getFileName())
              ->resize(650, 350)
              ->toFile(ImagenGaleria::RUTA_IMAGENES_GALLERY . $file->getFileName()); 
              $imagenGaleria = new ImagenGaleria($file->getFileName(), $description->getValue(), 0, 0, 0, intval($categoriasEl->getValue()));
              $repositorio->save($imagenGaleria);
              $info = 'Imagen enviada correctamente'; 
              $urlImagen = ImagenGaleria::RUTA_IMAGENES_GALLERY . $file->getFileName();
              $form->reset();
            
          }catch(Exception $err) {
              $form->addError($err->getMessage());
              $imagenErr = true;
          }          
        }
    }

    
    try {
      $imagenes = $repositorio->findAll();
    }catch(QueryException $qe) {
      $imagenes = [];
      echo $qe->getMessage();
      //En este caso podríamos generar un mensaje de log o parar el script mediante die($qe->getMessage())
    }
    include("app/views/galeria.view.php");