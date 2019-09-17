<?php
session_start();

if(empty($_SESSION['login_user']))
{
header('Location: index.php');
}

?>

<!DOCTYPE html>

<html lang="es" >
<head>
  <meta charset="UTF-8">
  <title>LAVADERO | Turnos On-Line</title>
  <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="style.css">

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
      <h4 class="animation a2">Selecciona cuando queres traer tu coche.</h4>
    </div>



    <form class="form">


    
      <p class="animation a5"><a href="tel:123456">Llama por telefono</a></p>
  	  <button type="submit" class="animation a6" id="agendarturno"> Agendar turno </button>
    </form>

  </div>
  <div class="right-section"></div>
</div>
  

<script>
$(document).ready(function()
{


$('#agendarturno').click(function()
{

console.log('Agendando...');

var fecha=$("#fecha").val();
//var dni=$("#dni").val();
var dataString = 'fecha='+fecha;

console.log(dataString);

if($(fecha).length>0)
{
$.ajax({
type: "POST",
url: "sys/newTurno.php",
data: dataString,
cache: false,
beforeSend: function(){ $("#login").html('Ingresando...');},
success: function(data){
if(data)
{
//$("body").load("sturno.php").hide().fadeIn(1500).delay(6000);
//or
//window.location.href = "sturno.php";
console.log(data);
}
else
{
//Shake animation effect.

//$("#login").html('Ingresar')
$("#error").html("<span style='color:#cc0000'>Error:</span> Problema con la fecha. ");
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