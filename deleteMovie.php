<?php

//Aggiungo al database il film selezionato

require_once 'dbconfig.php';

header('Content-type: application/json');

global $id;

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

$id=mysqli_real_escape_string($conn,$id);
$movie_id=mysqli_real_escape_string($conn,$_POST['id']);
$title=mysqli_real_escape_string($conn,$_POST['title']);
$poster=mysqli_real_escape_string($conn,$_POST['poster']);

//Controllo se il film scelto è presente nella watchlist

$query="SELECT * FROM watchlist WHERE user_id='$id' AND id='$movie_id'";

$res=mysqli_query($conn,$query) or die(mysqli_error(($conn)));

if(mysqli_num_rows($res)== 0){
    echo json_encode(array('ok' => false));
    exit;
}
//Elimino il film dalla tabella

$query="DELETE FROM  watchlist WHERE user_id='$id' AND id='$movie_id'";
if(mysqli_query($conn,$query) or die (mysqli_error($conn))){
    echo json_encode((array('ok' => true)));
    exit;
}

mysqli_close($conn);
echo json_encode(array('ok' => false));
?>