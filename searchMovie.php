<?php

//RITORNA UN JSON CON LE INFORMAZIONI DELL'ELEMENTO CERCATO

/*require_once 'auth.php';

if(!isAuth()){
    echo "Sessione scaduta";
exit;
}
*/

header('Content-Type:application/json');

getMovie();

function getMovie(){

   $curl = curl_init();
   $query=urlencode($_GET["q"]);
   
    
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://streaming-availability.p.rapidapi.com/v2/search/title?title=".$query."&country=us",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Host: streaming-availability.p.rapidapi.com",
            "X-RapidAPI-Key: a658a07c6amsh4392743ea81dfe3p1bb445jsnc2875fc0fd50"
        ],
    ]);
    
    $response = curl_exec($curl);
    curl_close($curl);
    echo $response;
    
}
?>