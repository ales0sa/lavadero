<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
session_start();

if(empty($_SESSION['login_user']))
{
header('Location: index.php');
}

function fechaCastellano ($fecha) {
  $fecha = substr($fecha, 0, 10);
  $numeroDia = date('d', strtotime($fecha));
  $dia = date('l', strtotime($fecha));
  $mes = date('F', strtotime($fecha));
  $anio = date('Y', strtotime($fecha));
  $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
  $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
  $nombredia = str_replace($dias_EN, $dias_ES, $dia);
$meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
  $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
  return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
}

?>

<!DOCTYPE html>

<html lang="es" >
<head>
  <meta charset="UTF-8">
  <title>LAVADERO | Turnos On-Line</title>
  <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="css/style.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">

  <script src="js/jquery-3.4.1.min.js"></script>




<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="HandheldFriendly" content="true">


</head>
<body>


<div class="container">
  <div class="left-section">
    <div class="header">

      <h1 class="animation a1">PATENTE: <?php echo $_SESSION['login_user']; ?></h1>
      <p class="animation a5"><a href="sys/logout.php">Salir</a></p>





      <h4 class="animation a2">Selecciona el dia que traeras tu vehiculo.</h4>
    </div>



    <form class="form">

      <?php



      $hoy = date('d-m-Y H:i:s');

      //echo $hoy;






      ?>



  <select id="fecha" name="fecha">


    <?php

    for ($n=0; $n<10; $n++) {

      $newday = date("Y-m-d", strtotime("+".$n." day"));

      echo '<option value="'.$newday.'"> '. fechaCastellano($newday) .' </option>'; //. fechaCastellano($hoy) . '</option>';

    }

    ?>

  </select>
    <div class="header">

      <h4 class="animation a2">Selecciona el horario.</h4>
    </div>
  <select name="horario" id="horario">
    

    <option selected>Mañana</option>
    <option>Tarde</option>
  </select>

  	  <button type="submit" class="animation a6" id="agendarturno"> Agendar turno </button>
    </form>
      <p id="error" class="animation a5"></p>
  </div>

  <div class="right-section2">
    
    <?php

    $patente = $_SESSION['login_user'];

    $hoy2 = date('Y-m-d');

    include('sys/db.php');

$result=mysqli_query($db,"SELECT * FROM turnos WHERE idcliente = '$patente' AND fecha > $hoy2");
$count=mysqli_num_rows($result);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

if($count>=1)
{

echo "<h4><strong>YA TIENES UN TURNO PROGRAMADO!</strong></h4>";

echo "<br>";
echo "<strong>Fecha: </strong>";

echo fechaCastellano($row['fecha']);

echo "<br>";
echo "<strong>Horario: </strong>";
echo $row['horario'];

} else {


?>


<?php


}

    ?>

  </div>



</div>
  

<script>
$(document).ready(function()
{


$('#agendarturno').click(function()
{

console.log('Agendando...');

var fecha=$("#fecha").val();
var horario=$("#horario").val();
//var dni=$("#dni").val();
var dataString = 'fecha='+fecha+'&horario='+horario;

console.log(dataString);

if(fecha.length>0)
{

$.ajax({
type: "POST",
url: "sys/agregarTurno.php",
data: dataString,
cache: false,
beforeSend: function(){ $("#agendarturno").html('Agregando...');},
success: function(data){
if(data='Turno agendado.')
{
//$("body").load("sturno.php").hide().fadeIn(1500).delay(6000);
//or
//window.location.href = "sturno.php";
console.log(data);

$("#fecha").prop("disabled", true);
$("#horario").prop("disabled", true);

$("#agendarturno").hide();


$("#error").html("<br><span style='color:green'>Turno agregado!</span> Te esperamos. ");


}
else
{
//Shake animation effect.

//$("#login").html('Ingresar')
$("#error").html("<span style='color:#cc0000'>Error:</span> No se puede asignar turno. ");
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