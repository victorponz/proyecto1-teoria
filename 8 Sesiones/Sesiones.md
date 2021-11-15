---
typora-copy-images-to: assets
---

# Implementación de Sesiones

Vamos a ver la implementación de todo el proceso de registro de usuarios.

## Creación de la entidad Usuario

A partir de la definición de la base de datos, creamos la entidad `Usuario`. 

<script src="https://gist.github.com/victorponz/b350128f6b5fc4b257d2007c5798ce5c.js"></script>
## Repositorio

Creamos un nuevo repositorio para la entidad `Usuario` en `repository/UsuarioRepository.php`.

En el constructor fijamos tanto la tabla como la entidad.

Y creamos un método `findByUserNameAndPassword` que devuelve el usuario que coincida con las credenciales. 

![image-20191122193021652](assets/image-20191122193021652.png)

## Formulario de login

Para empezar a probar, insertamos un usuario a mano mediante `phpmyadmin` y luego creamos el formulario:

![1543332398462](assets/1543332398462.png)

Lo único que tiene especial este formulario es el tratamiento de `returnToUrl`. Para no perder la redirección, siempre la hemos de pasar de una forma u otra tanto en los enlaces como en el formulario. En los enlaces, como en **¿Todavía no está registrad@?**, la única opción posible es añadirlo como un parámetro en el querystring, como veremos luego en la vista. Pero en el caso del formulario se puede hacer de dos formas:

1. En el querystring, es decir en el `action` del formulario y formará parte del array `$_GET`).
2. Como un campo `hidden` del formulario en cuyo caso formará parte del array `$_POST`

En el formulario de login (`/login.php`), vamos a hacerlo mediante la segunda opción.

En este formulario vamos a necesitar un nuevo campo de tipo password que todavía no hemos implementado. Es tan sencillo como crear la clase en `Forms/PasswordElement.php`

![image-20191122190553411](assets/image-20191122190553411.png)

Y ya podemos implementar el formulario de login.

![image-20191122190620145](assets/image-20191122190620145.png)

Y ahora hacemos las validaciones:

![image-20191122190651796](assets/image-20191122190651796.png)

Y modificamos la vista para que nos aparezca un mensaje cuando ya está logeado y el formulario cuando no lo está:

![1543345761178](assets/1543345761178.png)

De hecho, como el formulario no se ha de mostrar cuando el usuario ya está logeado, vamos a incluir el código para generar el formulario dentro de un if:

```php
if (!isset($_SESSION['username'])) {
    //Código para generar el formulario
}
include("./views/login.view.php");   
```

## Formulario de registro

Este formulario (`/register.php`) nos permite grabar un nuevo usuario en la base de datos.

En este caso, fijaos que `returnToUrl` lo paso en el `action` del formulario.

<script src="https://gist.github.com/victorponz/bb580c4db31000a8f1eddaf8aac9b8b6.js"></script>
Y la parte de validación:

![1543345831604](assets/1543345831604.png)

Y modificamos la vista (`register.view.php`), que es muy parecida a `login.view.php`

```php
<?php
  include __DIR__ . "/partials/inicio-doc.part.php";
  include __DIR__ . "/partials/nav.part.php";
  ?>
<div id="register">
    <div class="container">
        <div class="col-xs-12 col-sm-8 col-sm-push-2">
            <h1>REGISTRO</h1>
            <hr>
            <?php if (isset($_SESSION['username'])) :?>
                Ya está logeado como <?=$_SESSION['username']?>
            <?php else: ?>
                <?php
                    include __DIR__ . "/partials/show-messages.part.php";
                ?>
                <?=$form->render();?>
                <a href='/login.php<?=(!empty($hrefReturnToUrl) ? '?returnToUrl=' . $hrefReturnToUrl : '')?>'>
                    ¿Ya eres miembro? Acceso a usuari@s
                </a>
            <?php endif?>
        </div>
    </div>

</div>

<?php
  include __DIR__ . "/partials/fin-doc.part.php";
?>
```

### Restricciones en la base de datos

Tanto el campo `username` como `email` tienen un índice único. Por tanto al intentar grabar un nuevo usuario con alguno de estos campos duplicados, aparece el siguiente error.

![image-20191122191828298](assets/image-20191122191828298.png)

Pero este mensaje no es **User Friendly**, así que vamos a mostrar un mensaje adecuado dependiendo del mensaje de error que haya devuelto la excepción.

Los errores de `Duplicate entry` tienen el código de error **1062**. Para solucionarlo de una manera casera (la solución real es más elaborada que la mostrada a continuación) vamos a *parsear* el mensaje que nos devuelve la excepción.

Por ejemplo, 

![1543345887523](assets/1543345887523.png)

Y ahora el mensaje ya informa correctamente al usuario:

![1543335850809](assets/1543335850809.png)



## Logout

Simplemente hay que cerrar la sesión y redirigir a otra página.

```php
<?php
  session_start();
  session_unset();
  session_destroy();
  if (isset($_GET['returnToUrl'])) {
    header('location: ' . $_GET['returnToUrl']);
  } else {
    header('location: /');
  }
```

## Navegación

Vamos a modificar la navegación:

* Si el usuario no está registrado, pondremos un enlace para login y otro para registro. Además las opciones Galería y Asociados no aparecerán
  ![1543336656587](assets/1543336656587.png)
* En caso de que sí que lo esté, aparecerán las opciones Galería y Asociados y un enlace para cerrar la sesión.
  ![1543336686388](assets/1543336686388.png)

Sólo hay que comprobar si el usuario está registrado en la sesión. Así que sustituimos los enlaces a Asociados y Galería por el siguiente código:

<script src="https://gist.github.com/victorponz/9250de4815fbf50ef697363f9acfc25b.js"></script>
> **IMPORTANTE**
> No os olvidéis de hacer `session_start()` al principio de todos los controladores.

Falta impedir que usuarios no registrados entren en `Galería` y `Asociados`. Es tan sencillo como:

```php
<?php
     session_start();
     if (!isset($_SESSION['username'])) {
       header('location: /login.php?returnToUrl=/galeria.php');
     }
```

en `galeria.php` y 

```php
<?php
     session_start();
     if (!isset($_SESSION['username'])) {
       header('location: /login.php?returnToUrl=/asociados.php');
     }
   
```

en `asociados.php`

## Encriptación

Hasta ahora hemos almacenado la contraseña en texto plano, **algo terminantemente prohibido**. Vamos a implementar la seguridad en la contraseña, de tal forma que podamos cambiar el algoritmo de encriptación dependiendo de las necesidades. Cada algoritmo de encriptación necesita de consumo de CPU: a mayor complejidad, mayor consumo; pero también es más difícil un ataque de fuerza bruta.

Para ello vamos a usar, otra vez, el patrón de diseño Inyección de Dependencias. Al constructor de `UsuarioRepositorio` le pasaremos una instancia de nuestro encriptador de contraseñas.

Para ello, empezamos diseñando una interfaz que deben cumplir todos los encriptadores.

En la carpeta `/security` creamos el interface `IPasswordGenerator.php`

![1543346028700](assets/1543346028700.png)

Y ahora creamos una nueva clase que implemente este interfaz. Esta clase va a ser el encriptador de texto plano que, realmente, no encripta :). Pero es por empezar por algo sencillo:

Por tanto, creamos la clase `PlainPasswordGenerator`:

![1543346043016](assets/1543346043016.png)

Ahora, modificamos el constructor de `UsuarioRepositorio`:

```php
/**
 * Generador de password
 *
 * @var IPasswordGenerator
 */
private $passwordGenerator;

public function __construct(IPasswordGenerator $passwordGenerator){
    $this->passwordGenerator = $passwordGenerator;
    parent::__construct('users', 'Usuario');
}
```

Y modificamos `findByUserNameAndPassword` para que antes de lanzar la consulta, encripte la contraseña:

```php
$parameters = ['username' => $username, 
               'password' => $this->passwordGenerator::encrypt($password)];
```

Y, por último, modificamos `login.php`  y `register.php` para pasar el encriptador de texto plano al constructor de `UsuarioRepositorio`.

```php
require_once "./security/PlainPasswordGenerator.php";
//...
$repositorio = new UsuarioRepository(new PlainPasswordGenerator());
```

Y ya funciona!!

## Algoritmos de encriptación

Vamos a encriptar la contraseña usando `password_hash()`.  Básicamente, encripta según el algoritmo que le pasemos como parámetro. Por ejemplo, 

```php
echo password_hash('123456', PASSWORD_DEFAULT);
```

Produciría el siguiente hash:

```
$2y$10$9fMjJx8i.dLPU75Sx05/x.pwrvw2rQXhOd7mfyBcTSB/iJn4lb1Lm
```

Pero este hash, no siempre es el mismo porque el propio algoritmo le aplica un salt distinto cada vez. Por tanto la siguiente vez, nos puede devolver:

```
$2y$10$BHLFwS/bJk0CWpFStcuaM.dnY/c3ck8oXF5wf4DrWcAqEmSgJTxfa
```

Ahora mismo, `PASSWORD_DEFAULT` se corresponde con `PASSWORD_BCRYPT`, pero puede que en un futuro éste cambie. Así que no se recomienda usar `PASSWORD_DEFAULT`.

Vamos a hacer un nuevo `IPasswordGenerator` para `bcrypt`.

![1543346100720](assets/1543346100720.png)

Además, como el hash no siempre es el mismo, lo que hemos de hacer para saber si la contraseña encriptada es la misma es llamar a `password_verify()`. Así que vamos a modificar el interfaz `IPasswordGenerator` para añadirle un nuevo método llamado `passwordVerify()`.

![1543346121303](assets/1543346121303.png)

Y ahora modificamos la clase `PlainPasswordGenerator`:

![1543346135371](assets/1543346135371.png)

Y la clase `BCryptPasswordGenerator`:

![1543346147396](assets/1543346147396.png)

Pero antes de continuar, hemos de modificar el método `save()` de `UsuarioRepositorio` para que encripte la contraseña. Para ello, copiamos el método `save()` de `QueryBuilder` y lo modificamos, añadiendo la línea:

```php
 $parameters['password'] = $this->passwordGenerator::encrypt($parameters['password']);
```

Así que el método `save()` quedaría como sigue;

![image-20191122195707169](assets/image-20191122195707169.png)

Y modificamos `findByUserNameAndPassword` para que use `passwordVerify`.

![image-20191122194927485](assets/image-20191122194927485.png)

Ahora para usar un algoritmo de encriptación, simplemente se lo inyectamos en el constructor:

> **Nota**. Antes de cambiar el algoritmo de encriptación, debemos borrar todos los usuarios de la base de datos. De otra forma los antiguos no se podrán logear. En producción es evidente que no se puede proceder de esta forma. Os dejo un artículo de [stack overflow](https://stackoverflow.com/questions/5249350/changing-encryption-algorithm) sobre el tema.

Por ejemplo, en `login.php` y `register.php`

```php
require_once "./security/BCryptPasswordGenerator.php";
//...
$repositorio = new UsuarioRepository(new BCryptPasswordGenerator());
```

Ahora es muy sencillo tener diferentes algoritmos de encriptación. Por ejemplo vamos a encriptar usando el algoritmo `PASSWORD_ARGON2I`.

Sólo hemos de crear una nueva clase que implemente `IPasswordGenerator`.  Por ejemplo, creamos la clase `Argon2PasswordGenerator`.

```php
<?php
require_once __DIR__ . "/IPasswordGenerator.php";

class Argon2PasswordGenerator implements IPasswordGenerator
{
    public static function encrypt(string $plainPassword): string {
        return password_hash($plainPassword, PASSWORD_ARGON2I);
    }
    
    public static function passwordVerify($password, $hash): bool {
        return (password_verify($password, $hash));
    }
}
```

> NOTA. Este algoritmo de encriptación sólo está disponible a partir de PHP 7.2.0

E inyectar esta clase en el constructor de `UsuarioRepositorio`.



Más información sobre encriptación en PHP:

https://deliciousbrains.com/php-encryption-methods/

http://php.net/manual/es/function.password-hash.php

http://php.net/manual/es/function.password-verify.php


## Credits.

Víctor Ponz victorponz@gmail.com

Este material está licenciado bajo una licencia [Creative Commons, Attribution-NonCommercial-ShareAlike](https://creativecommons.org/licenses/by-nc-sa/3.0/)

![](https://licensebuttons.net/l/by-nc-sa/3.0/88x31.png)





