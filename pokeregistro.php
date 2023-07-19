<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
     
    <link rel="stylesheet" href="css\loginandregistration.css">
</head>

<body>

    <div class="container">
        <?php

        /*comprobamos si el formulario se ha enviado comprobando si se ha hecho clic en el botón Enviar */
        if (isset($_POST["submit"])) { 

            /*Toma los datos introducidos por el usuario en el formulario y los almacena en variables:*/
            $fullName = $_POST["fullname"]; 
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];

           /*Para cifrar la contraseña*/
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            
            /*Para almacenar posibles errores en un arreglo*/
            $errors = array();

          
            if (empty($fullName) or empty($email) or empty($password) or empty($passwordRepeat)) {
                array_push($errors, "Todos los campos son obligatorios");
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email incorrecto");
            }
            
            if (strlen($password) < 5) {
                array_push($errors, "La contraseña debe tener minimo 5 caracteres");
            }
            
            if ($password !== $passwordRepeat) {
                array_push($errors, "Contraseña no son iguales");
            }

            /* Conectamos la base de datos con "require_once" para incluir el archivo "databasepd.php" que contiene la configuración de conexión */
            require_once "bd_conexion.php";

            //Consulta la base de datos para verificar si el correo electrónico ingresado está registrado en la tabla de "users":
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount > 0) {
                array_push($errors, "Email ya esta en uso");

            }

            /*Se mostrara una pag de errores si las validaciones salen erroneas*/
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            } else {
                require_once "bd_conexion.php";
                
            
                $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ? ,? )";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $passwordHash);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-succes'>El registro fue exitoso.</div>";
                } else {
                    die("Algo estuvo mal :( ");
                }
            }
        }


        /*Aquí ya se realiza la estructura incial del formulario*/ 
        ?>
        <form action="pokeregistro.php" method="post">
            <div class="form-groupTITULO">
                <h1>POKÉDEX</h1>
            </div>


            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Ingresa tu nombre completo">
            </div><br>

            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Ingresa tu email">
            </div><br>

            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Ingresa tu contraseña">
            </div><br>

            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repite tu contraseña">
            </div><br><br>


            
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="¡Registrate ahora!" name="submit">
            </div>

            <div class="form-btn2">
                <a href="pokelogin.php">Has click aquí si ya tienes usuario</a>
            </div>

        </form>
    </div>
</body>

</html>