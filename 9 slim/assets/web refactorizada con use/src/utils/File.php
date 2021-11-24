<?php

require_once __DIR__ . "/../exceptions/FileException.php";
require_once __DIR__ . "/utils.php";
class File
{
    /**
     * Representa a un único campo file de un formulario
     *
     * @var [string]
     */
    private $file;
    /**
     * Nombre del fichero generado en document root
     *
     * @var [string]
     */
    private $fileName;
    
    /**
     * @param string $fileInput Nombre del Input de tipo image a procesar
     * @param array $mimeTypes Mimes types válidos
     * @param int $maxSize Tamaño máximo en bytes. Si es 0, el tamaño es ilimitado
     * @throws FileException
     */
    public function __construct(string $fileInput, array $mimeTypes = [], int $maxSize = 0)
    {
        $this->file = ($_FILES[$fileInput] ?? "");
         /*
            Ciudado. Puede ser que si habido algún problema en la subida, la variable $_FILES[$filename] y, por tanto 
            $this->file, no esté informada
        */
        if (empty($this->file)) {
            throw new FileException("Se ha producido un error al procesar el formulario.");
        }
        if ($this->file["error"] !== UPLOAD_ERR_OK){
            switch ($this->file["error"]){
                case UPLOAD_ERR_NO_FILE:
                    throw new FileException('Debes seleccionar un fichero');
                    break;
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new FileException('El fichero es demasiado grande');
                    break;
                case UPLOAD_ERR_PARTIAL:
                    throw new FileException('No se ha podido subir el fichero completo');
                    break;
                default:
                    throw new FileException('No se ha podido subir el fichero');
            }
        }
        if (false === in_array($this->file["type"], $mimeTypes)){
            throw new FileException('El tipo de fichero no está soportado');
        }
        if (($maxSize > 0) && ($this->file['size'] > $maxSize)) {
            throw new FileException("El fichero no puede superar $maxSize bytes");
        }
        //Evitar hackeo (mediante inyección de html)
        $this->fileName = sanitizeInput($this->file["name"]);

    }
    /**
     * Devuelve el nombre del fichero creado
     *
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * Guarda en $destPath el fichero $this->fileName
     * @param string $destPath
     * @throws FileException
     */
    public function saveUploadedFile(string $destPath)
    {
        /* Evitar hackeos. Siempre hay que comprobar que el archivo se ha subido mediante un formulario.
          - https://www.acunetix.com/websitesecurity/upload-forms-threat/
        */

        if (false === is_uploaded_file($this->file["tmp_name"])){
            throw new FileException("El archivo no se ha subido mediante un formulario");
        }

        $ruta = $destPath . $this->getFileName();

        if (true === is_file($ruta)){
            $idUnico = time();
            $this->fileName = $idUnico  . "_" . $this->getFileName();
            $ruta = $destPath . $this->getFileName();
        }
        if (false === move_uploaded_file($this->file["tmp_name"], $ruta)){
            throw new FileException("No se puede mover el fichero a su destino");
        }
    }
    
}