


<!DOCTYPE html>

<html lang="es" >
<head>
  <meta charset="UTF-8">
  <title>LAVADERO | Turnos On-Line</title>
  <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">


<script src="js/jquery-3.4.1.min.js"></script>

<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="HandheldFriendly" content="true">

<style>
* {
  box-sizing: border-box;
}

/* Create two equal columns that floats next to each other */
.column {
  float: left;
  width: 50%;
  padding: 10px;
  height: 300px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
</style>

</head>
<body>


<div class="row">
  <div class="column" style="background-color:#bbb;">

    <div class="header">

      <h1 class="">VISOR DE TURNOS</h1>
      <h4 class="">Proximos turnos:</h4>
    </div>




<hr>

<?php
include('sys/db.php');

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$ahora = date('Y-m-d');

$sql = "SELECT *,DATE_FORMAT(fecha,'%d/%m') AS newfecha FROM turnos WHERE fecha > $ahora LIMIT 10";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

    	$newfecha = $row["newfecha"];


        echo "N°: " . $row["idturno"]. " - Patente: " . $row["idcliente"]. " - Fecha: " .$newfecha." - Horario: " . $row["horario"]. "<br>";
    }
} else {
    echo "0 results";
}

?>


  </div>
  <div class="column">
  	
<div class="header">

      <h1 class="">CLIENTES</h1>
      <h4 class="">Clientes agendados.</h4>
    </div>


<form>
	Patente:
	<input type="text" name="patente" id="patente">
	Dni:
	<input type="text" name="dni" id="dni">

	<input type="submit" value="Agregar" id="agregarpat">	
</form>

<hr>
<?php

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$sql = "SELECT * FROM clientes";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Patente: " . $row["patente"]. " - DNI: " . $row["dni"]. "<br>";
    }
} else {
    echo "0 results";
}

$db->close();

?>

  </div>


</div>
  

<script>
$(document).ready(function()
{

$("input[type=text]").keyup(function(){
  $(this).val( $(this).val().toUpperCase() );
});

$('#agregarpat').click(function()
{

console.log('Agregando cliente...');

var patente=$("#patente").val();
var dni=$("#dni").val();
var dataString = 'patente='+patente+'&dni='+dni;

console.log(dataString);

if($.trim(patente).length>0 && $.trim(dni).length>0)
{
$.ajax({
type: "POST",
url: "sys/agregarPatente.php",
data: dataString,
cache: false,
beforeSend: function(){ $("#agregarpat").val('Cargando...');},
success: function(data){
if(data)
{
$("body").load("admin.php").hide().fadeIn(1500).delay(6000);
//or
//window.location.href = "sturno.php";
console.log(data);
}
else
{
//Shake animation effect.


$("#error").html("<span style='color:#cc0000'>Error:</span> Patente o DNI incorrectos. ");
}
}
});

}
return false;
});

});
</script>



</body>
</html>
