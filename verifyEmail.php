<?php

require_once 'dbconfig.php';

if($_GET["q"]==null){
    echo "Errore di accesso";
}
//CONTROLLO CHE LA MAIL SIA UNICA

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
header('Content-Type: application/json');
$email=mysqli_real_escape_string($conn,$_GET["q"]);
$query="SELECT mail FROM users WHERE mail= '$email' ";
$res=mysqli_query($conn,$query) or die(mysqli_error($conn));
$val;
if(mysqli_num_rows($res)>0){
    $val=true;
}else{
    $val=false;
}
$userJson=array(
    "exists" => $val
);
echo json_encode($userJson);

mysqli_close($conn);

?>