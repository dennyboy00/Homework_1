<?php
include_once 'auth.php';

if(isAuth()){

    header('Location:home.php');
    exit;
}

//Controlla che sia stato compilato il form

if(!empty($_POST["name"]) && !empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["conf_password"])){

$conn=mysqli_connect($dbconfig['host'],$dbconfig['user'],$dbconfig['password'],$dbconfig['name']) or die (mysqli_error($conn));
$err=array();

//Controllo se i vari campi rispettano il pattern specificato

//USERNAME

$usernamePattern = "/^[a-zA-Z0-9_-]+$/";

if(preg_match($usernamePattern,$_POST['username'])){
    $user=mysqli_escape_string($conn,$_POST['username']);
    $us_query = "SELECT username FROM users WHERE username ='$user'";
    $res=mysqli_query($conn,$us_query);
    $count= mysqli_fetch_row($res);
    echo "<span>if Error</span>";
    if($count>0){
        $err[]="Username già utilizzato";
        print($err);


    }

   
} else{
        $err[]="Inserire un user valido";
        echo "<span>Error</span>";

    }



//INDIRIZZO MAIL

$mailPattern="/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/";

if(preg_match($mailPattern,$_POST['email'])){
    $mail=mysqli_real_escape_string($conn,$_POST['email']);
    $mail_query="SELECT mail FROM users WHERE mail='.$mail' ";
    $res=mysqli_query($conn,$mail_query);
    $count2=mysqli_fetch_row($res);
    if($count2>0){
        $err[]="Mail già utilizzata";
      
    }

    
}else{
        $err[]="Inserire una mail valida";
       
    }

//PASSWORD

$passwordPattern = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";


if(!preg_match($passwordPattern,$_POST['password'])&& strlen($_POST['password'])<8){
    $err[]="Inserire una password valida";
  

}

if(strcmp($_POST["password"],$_POST["conf_password"])!=0){
    print_r($_POST["password"]);
    print_r($_POST["conf_password"]);
    $err[]="Le password non coincidono";
  
}


//INSERIMENTO DEI DATI NEL DATABASE

if(count($err)==0){

$name=mysqli_escape_string($conn,$_POST['name']);
$password=mysqli_real_escape_string($conn,$_POST["password"]);
$password=password_hash($password,PASSWORD_BCRYPT);

$query="INSERT INTO users (name,username,mail,password) VALUES ('$name','$user','$mail','$password')";

if(mysqli_query($conn,$query)){

    $_SESSION["my_session_user"]=$_POST["username"];
    $_SESSION["my_session_id"]=mysqli_insert_id($conn);
    header("Location:home.php");
    mysqli_close($conn);
    exit;
}else{
$err[]="Impossibile stabilire una connessione con il database";
}
}
mysqli_close($conn);
}else if(isset($_POST["username"])){
    $err[]="Compila tutti i campi obbligatori per proseguire!";
    
}

?>

<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="subscribe.css">
    <script src="subscribe.js" defer></script>
    <title>Iscriviti a NomeSito</title>
</head>
<body>
<div id="title">Iscriviti su STREAMZONE</div>
<section>
<h1>Compila il form per iscriverti gratuitamente a StreamZone</h1>
<form name='sub' method="POST" autocomplete="off" enctype="multipart/form-data">

<div id='name'>
<label for="name">Nome</label>
<input type="text" name="name" placeholder="Inserire nome"<?php if(isset($_POST["name"])){ echo "value=".$_POST["name"];} ?>>
<span></span>
</div>

<div id='user'>
<label for="username">Username</label>
<input type="text" name="username" placeholder="Inserire username" <?php if(isset($_POST["username"])){ echo "value=".$_POST["username"];} ?>>
<span></span>
</div>

<div id='email'>
<label for="email">Indirizzo mail</label>
<input type="text" name="email" placeholder="Inserire indirizzo mail" <?php if(isset($_POST["email"])){ echo "value=".$_POST["email"];} ?>>
<span></span>
</div>

<div id='password'>
<label for="password">Password</label>
<input type="text" name="password" placeholder="Password" <?php if(isset($_POST["password"])){ echo "value=".$_POST["password"];} ?>> <br>
<p>La password deve contenere almeno 8 caratteri,di cui almeno una lettera maiuscola,una cifra e un elemento speciale</p>
<span></span>
</div>

<div id='conf_password'>
<label for="conf_password">Conferma Password</label>
<input type="text" name="conf_password" placeholder="Conferma password" <?php if(isset($_POST["conf_password"])){ echo "value=".$_POST["conf_password"];} ?>>
<span></span>
</div>

<?php
if(isset($err)){
    foreach($err as $error_msg){
        echo "<span> ".$error_msg." </span>";
    }
}

?>

<div class="submit">
    <input type="submit" value="Iscriviti ora!" id="submit_btn">
</div>

</form>

<span class="sub">Sei già registrato?<a href="login.php">LOGIN</a> </span>

</section>
</body>
</html>