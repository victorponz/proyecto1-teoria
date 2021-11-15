<?php
$tituloPagina = "Un formulario HTML/PHP sencillo";
include("header.php");
$tituloPrograma = "Form";
$desPrograma = "Un formulario HTML/PHP sencillo";
include("header-exercise.php");
echo '<pre>';
echo htmlspecialchars(print_r($_POST, true));
echo '</pre>';


function test_input($data) {
	$data = trim($data);
	//Quitar las comillas escapadas \' y \ ""
	$data = stripslashes($data);
	//Prevenir la introducción de scripts en los campos
	$data = htmlspecialchars($data);
	return $data;
}
//Comprobar validez de datos e inicializar variables
$nombre = $correo = "";
$error = false;
$errores = array();
$emailErr = $nombreErr = false;
//Comprobar tipo de petición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//Comprobar validez de los datos

	$nombre = test_input($_POST["nombre"]);
	if ($nombre == ""){
		array_push($errores, "Introduce un nombre");
		$nombreErr = true;	
	}
	//Si se produce algún error
	$correo = test_input($_POST["correo"]);
	if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
		//Si se produce algún error
		array_push($errores, "Formato inválido de correo");
		$emailErr = true;
	}
	if (sizeOf($errores) > 0)
		$error = true;
	if (!$error){
		echo "<h4>Ha introducido los siguientes datos</h4>";
		echo "<div>Nombre: $nombre<br/>";
		echo "Correo: $correo</div>";
		echo "Enviar otro <a href='" . htmlspecialchars($_SERVER['PHP_SELF']) . "'>mensaje</a>";
	}

}

if (($_SERVER["REQUEST_METHOD"] == "GET") || $error){
	if ($error){
		//Mostrar todos los mensajes de error
		for ($i = 0; $i < sizeOf($errores); $i++)
			echo "<div class='alert alert-danger' role='alert'>$errores[$i]</div>";

	}
?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
	<div class="form-group <?php if ($nombreErr) echo 'has-error';?>">
    	<label for="nombre">Nombre</label>
    	<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre completo" value="<?php echo $nombre?>">
	</div>
	<div class="form-group <?php if ($emailErr) echo 'has-error';?>">
    	<label for="correo">Correo</label>
    	<input type="text" class="form-control" id="correo" name="correo"  placeholder="Introduce tu correo electrónico" value="<?php echo $correo?>">
	</div>
	<button type="submit" class="btn btn-default">Enviar</button>
</form>
<?php
}
include("footer-exercise.php");
include("footer.php");
?>


