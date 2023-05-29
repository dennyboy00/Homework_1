<?php
include 'dbconfig.php';

//Quando l'utente esce,distruggo la sessione 

session_start();
session_destroy();

header("Location:login.php");

?>