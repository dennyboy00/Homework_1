<?php

require_once "dbconfig.php";

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);


$query="SELECT * FROM watchlist  ORDER BY id";

$res=mysqli_query($conn,$query) or die(mysqli_error($conn));

$movieList=array();

while($elem=mysqli_fetch_assoc($res)){
    $movieList[]=$elem;
}

mysqli_close($conn);

echo json_encode($movieList);

?>