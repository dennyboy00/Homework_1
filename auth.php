<?php
require_once 'dbconfig.php';
session_start();

function isAuth(){

    if(isset($_SESSION['site_username'])){
        return $_SESSION['site_username'];

    }else 
    return 0;
}

?>