<?php
include("db.php");
session_start();

if(isset($_SESSION['login_user']) && isset($_POST['fecha']))
{

$patente = $_SESSION['login_user'];
$fecha = $_POST['fecha'];
$horario = $_POST['horario'];


$query = "INSERT INTO turnos (idcliente, fecha, horario) VALUES ('$patente', '$fecha', '$horario')";


if(mysqli_query($db, $query)){

    echo "Turno agendado.";

} else{

    echo "ERROR: Could not able to execute $query. " . mysqli_error($db);

}

}

?>