<?php
include("db.php");
session_start();

if(isset($_POST['dni']) && isset($_POST['patente']))
{

// username and password sent from Form
$dni=mysqli_real_escape_string($db,$_POST['dni']);
$dni=strtoupper($dni);
$patente=mysqli_real_escape_string($db,$_POST['patente']);

//Here converting passsword into MD5 encryption. 
//$password=md5(mysqli_real_escape_string($db,$_POST['password']));

$result=mysqli_query($db,"SELECT * FROM clientes WHERE patente='$patente' and dni='$dni'");
$count=mysqli_num_rows($result);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
// If result matched $username and $password, table row  must be 1 row
if($count==1)
{
$_SESSION['login_user']=$row['patente']; //Storing user session value.

echo $row['patente'];
}

}
?>