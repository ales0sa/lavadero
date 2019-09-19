<?php
include("db.php");
session_start();

if(isset($_POST['patente']) && isset($_POST['dni']))
{

$patente = $_POST['patente'];
$dni = $_POST['dni'];


$query = "INSERT INTO clientes (patente, dni) VALUES ('$patente', '$dni')";


if(mysqli_query($db, $query)){

    echo "Patente agregada.";

} else{

    echo "ERROR: Could not able to execute $query. " . mysqli_error($db);

}

}

?>