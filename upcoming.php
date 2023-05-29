<?php
require_once 'auth.php';
    if (!$username = isAuth()) {
        header("Location: login.php");
        exit;
    }
?>


<!DOCTYPE html>
<html lang="it">
<?php 
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        $username = mysqli_real_escape_string($conn, $username);
        $query = "SELECT * FROM users WHERE username = '$username' ";
        $res= mysqli_query($conn, $query);
        $userinfo = mysqli_fetch_assoc($res);   
    ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stream-Zone</title>
    <link rel="stylesheet" href="upcoming.css">
    <script src="upcoming.js" defer></script>
</head>
<body>
<nav>
<div class="links">
<img id="logo" src="play.logo.jpg">
<a id="title">STREAMZONE</a>
<a href="home.php">HOME</a>
<a>ABOUT</a>
<a>SHARE</a>
<a>CONTACTS</a>
<a href="account.php">IL TUO PROFILO</a>
<a href="logout.php"id="esc">ESCI</a>
</div>
<div id="menu">
    <div></div>
    <div></div>
    <div></div>
</div>
</nav>
<header>
<h1>Hey <?php echo $userinfo['username']?>! Dai un'occhiata ai film in uscita nei prossimi mesi</h1>
<section class="box">
<div id="contents">
</div>
</section>
</header>
<footer>
    <span>DENNIS BORDONARO N° 1000001850</span>
    <div class="footer_container">
    <p>Chi siamo</p>
    <p>Link utili</p>
    <p>Valuta la tua esperienza</p>
    <p>Gli show del momento</p>
    </div>
    <span id="site_name"> ™ Stream-Zone: 2023 All right reserved</span>
</footer>
</body>
</html>