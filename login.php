<?php
//Controllo se l'utente è già loggato ed è partita la sessione
include 'auth.php';
if(isAuth()){
    header('Location: home.php');
    exit;
}

if(!empty($_POST["username"]) && !empty($_POST["password"])){
    
$conn=mysqli_connect($dbconfig['host'],$dbconfig["user"],$dbconfig["password"],$dbconfig["name"])or die(mysqli_error($conn));
$username=mysqli_real_escape_string($conn,$_POST["username"]);
$query= "SELECT * FROM users WHERE username = '".$username."'";
$exe=mysqli_query($conn,$query) or die(mysqli_error($conn));


if(mysqli_num_rows($exe)>0){
    $entry= mysqli_fetch_assoc($exe);
    
    if(password_verify($_POST["password"],$entry['password'])){
        //Se la password è verificata,setto una sessione
        $_SESSION["site_username"]=$entry["username"];
        $_SESSION["site_user_id"]=$entry["id"];
        header("Location: home.php");
        mysqli_free_result($exe);
        mysqli_close($conn);
        exit;
    }
}

$err="Credenziali errate";


}

else if(isset($_POST["username"]) || isset($_POST["password"])){
    $err="Si prega di inserire username e password";
}

?>

<html>
    <head>
        <link rel='stylesheet' href='login.css'>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Accesso</title>
    </head>
    <body>
    <div id="title">STREAMZONE</div>
    <main>
    <section class='section'>
        
        <h3>Inserisci le tue credenziali per accedere</h3>
        <?php
            // Verifica la presenza di errori
            if(isset($err))
            {
                echo "<p class='error'>$err</p>";
              
            }
        ?>
    
            <form id="form_login"  name='form' method='POST'>
                <div class='user'>
                     <label>Username</label>
                    <input type='text' name='username' placeholder="Username" <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>>
                </div>
                   
                <div class='password'>
                    <label>Password</label>
                    <input type='password' name='password' placeholder="password..." <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
               </div>
              <div class='submit' > 
                    <input  type='submit' value="PROSEGUI" > 
             </div>
  <div><h1>Non hai un profilo?</h1></div>
  <div class='signup_button'><a class='signup_btn' href="subscribe.php">REGISTRATI QUI </a>
  </div>
  </form>
</section>
  </main>
    </body>
</html>


