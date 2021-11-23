<?php
namespace ProyectoWeb\Forms;

use ProyectoWeb\Forms\InputElement;

class FileElement extends InputElement
{
    /**
     * Nombre del fichero una vez movido a su destino
     *
     * @var string
     */
    private $fileName;
    
    /**
     * Posibles errores al procesar el campo 
     * 
     * @var array
     */
    protected $errors;

    public function __construct(string $name, string $id = '', string $cssClass  = '', string $style = '')    {
        $this->fileName = "";
        $this->errors = [];
        parent::__construct($name, 'file', $id, $cssClass, $style);
    }

     /**
     * Protección ante hackeos del campo del POST
     *
     * @return mixed
     */
    protected function sanitizeInput()
    {
        if (isset($_FILES[$this->getName()])){
            $_FILES[$this->getName()]['name'] =  $this->sanitize($_FILES[$this->getName()]['name']);
            return $_FILES[$this->getName()];
        }
        return "";
    }
     /**
     * Valida el campo según los criterios del validador
     *
     * @return void
     */
    public function validate()
    {
        //Los posibles errores de subida de archivos se contemplan en FormElement
        //See http://www.php.net/manual/en/ini.core.php#ini.post-max-size
        if ($_FILES[$this->getName()]["error"] !== UPLOAD_ERR_OK){
            switch ($_FILES[$this->getName()]["error"]){
                case UPLOAD_ERR_NO_FILE:
                    $this->errors[] = 'Debes seleccionar un fichero';
                    break;
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $this->errors[] = 'El fichero es demasiado grande';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $this->errors[] = 'No se ha podido subir el fichero completo';
                    break;
                default:
                   $this->errors[] = 'No se ha podido subir el fichero';
            }
          
        }

        if ((!empty($_FILES[$this->getName()]["tmp_name"])) && (false === is_uploaded_file($_FILES[$this->getName()]["tmp_name"]))){
            $this->errors[] = 'El archivo no se ha subido mediante un formulario';
        }

        $this->setPostValue();
        // Si no pasa esta validación no continuamos validando
        if (!($this->hasError()) && !empty($this->getValidator())) {
            $this->getValidator()->setData($this->getValue());
            $this->getValidator()->validate();
            $this->errors = array_merge($this->errors, $this->getValidator()->getErrors());
        }
        if (!($this->hasError())) {
            //Evitar hackeo (mediante inyección de html)
            $this->fileName = $this->sanitize($_FILES[$this->getName()]["name"]);
        }
    }
    public function hasError(): bool
    {
        return (count($this->errors) > 0);
    }
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Get nombre del fichero una vez movido a su destino
     *
     * @return  string
     */ 
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getValue()
    {
        //En algunos casos el navegador no envía el campo del form si éste está vacío
        return ($_FILES[$this->getName()] ?? []);
    }
     /**
     * Guarda en $desPath el fichero $this->fileName
     * @param string $destPath
     * @throws FileException
     */
    public function saveUploadedFile(string $destPath)
    {
        $ruta =  $destPath . $this->fileName;

        if (true === is_file($ruta)){
            $idUnico = time();
            $this->fileName = $idUnico  . "_" . $this->fileName;
            $ruta =  $destPath . $this->fileName;
        }
        if (false === @move_uploaded_file($_FILES[$this->getName()]["tmp_name"], $ruta)){
            throw new FileException("No se puede mover el fichero a su destino");
        }
    }

    /**
     * Genera el HTML del elemento
     *
     * @return string
     */
    public function render(): string
    {
        $this->setPostValue();
        $html = "<input type='{$this->getType()}' " ; 
        $html .= $this->renderAttributes();
        $html .= '>';
        return $html;
    }
}