<?php
session_start();

if(!empty($_SESSION['login_user']))
{
header('Location: sturno.php');
}

?>

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


</head>
<body>


<div class="container">
  <div class="left-section">
    <div class="header">

      <h1 class="animation a1">Bienvenido!</h1>
      <h4 class="animation a2">Ingresa aquí para sacar tu turno.</h4>
    </div>

    <form class="form">
      <input type="text" id="patente" name="patente"  class="form-field animation a3" placeholder="PATENTE">
      <input type="number" id="dni" name="dni" class="form-field animation a4" placeholder="D.N.I.">
      <p class="animation a5"><a href="tel:123456">Llama por telefono</a></p>
      <p id="error" class="animation a5"></p>
  	  <button type="submit" class="animation a6" id="login"> Ingresar </button>
    </form>

  </div>
  <div class="right-section"></div>
</div>
  

<script>
$(document).ready(function()
{

$("input[type=text]").keyup(function(){
  $(this).val( $(this).val().toUpperCase() );
});

$('#login').click(function()
{

console.log('Logueando...');

var patente=$("#patente").val();
var dni=$("#dni").val();
var dataString = 'patente='+patente+'&dni='+dni;

console.log(dataString);

if($.trim(patente).length>0 && $.trim(dni).length>0)
{
$.ajax({
type: "POST",
url: "sys/ajaxLogin.php",
data: dataString,
cache: false,
beforeSend: function(){ $("#login").html('Ingresando...');},
success: function(data){
if(data)
{
$("body").load("sturno.php").hide().fadeIn(1500).delay(6000);
//or
//window.location.href = "sturno.php";
console.log(data);
}
else
{
//Shake animation effect.

$("#login").html('Ingresar')
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