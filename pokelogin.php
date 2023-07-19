<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <link rel="stylesheet" href="css\loginandregistration.css">
</head>

<body>
    
    <div class="container">
        
        <div class="container">
            <?php
            //verificamos si el formulario de inicio de sesión ha sido enviado, comprobando si el botón de envío (login) ha sido presionado

            if (isset($_POST["login"])) {    

            //El código toma los datos ingresados ​​por el usuario en el formulario y los almacena en una variable
                $email = $_POST["email"];
                $password = $_POST["password"];

            /*Conectamos la base de datos con "require_once" para incluir el archivo "bd_conexion.php" que contiene la configuración de la conexión */
                require_once "bd_conexion.php";

            //Se realiza una solicitud a la base de datos para obtener filas de usuarios que coincidan con el correo electrónico ingresado
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

            //El código comprueba si se ha encontrado en la base de datos un usuario con el correo electrónico introducido
                if ($user) {
                    if (password_verify($password, $user["password"])) { //Si las credenciales son correctas, inicia la sesión y redirige al usuario a "index.html" (Donde está el listado de los Pokemon)
                        session_start();
                        $_SESSION["user"] = "yes";
                        header("Location: index.html");
                        die();
                    } else {
                    // Si la contraseña es erronea, muestra un mensaje de error
                        echo "<div class='alert alert-danger'>La contraseña es incorrecta, intenta nuevamente...</div>";
                    }
                } else {
                // Si no se encuentra el usuario con la dirección de correo electrónico ingresada, se muestra un mensaje de error
                    echo "<div class='alert alert-danger'>El email no coincide, prueba nuevamente...</div>";
                }
            }

            /*Aquí ya se realiza el formulario del LOGIN */ 
            ?>
            <h1 class="loginTitulo">¡LOGUEATE!</h1>

            <form action="pokelogin.php" method="post">

                <div class="form-group2">
                    <input type="email" placeholder="Ingresa tu Email:" name="email" class="form-control">
                </div><br>
                <div class="form-group2">
                    <input type="password" placeholder="Ingresa tu contraseña:" name="password" class="form-control">
                </div><br><br><br><br><br><br>
                <div class="form-btn2">
                    <input type="submit" value="Login" name="login" class="btn btn-primary">
                </div>
            </form>
        </div>

</body>

</html>