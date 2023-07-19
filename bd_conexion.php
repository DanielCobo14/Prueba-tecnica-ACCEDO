<?php 
//Conexión a la base de datos
$hostname = "localhost"; //nombre del Host
$dbUser="root"; //usuario de la BD
$dbPassword=""; //Sin contraseña establecida
$dbName="formularios-login-registro";
$conn = mysqli_connect($hostname, $dbUser , $dbPassword ,$dbName);
if (!$conn){
    die("Connection went wrong;");
}
?>
