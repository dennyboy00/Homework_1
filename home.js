const form=document.querySelector("#src");
form.addEventListener("submit",search);
const overlay=document.getElementById("click_area");
overlay.addEventListener("click",closeModal);

function closeModal(event){
   console.log("Chiusura modale");
    const elem=event.currentTarget;
    elem.classList.add("hidden");
    const mov=document.querySelector(".clicked");
    mov.classList.remove("clicked");
    mov.classList.remove("no_select");
    const mod=mov.querySelector(".modal");
    mod.classList.remove("show");
    const icon=mov.querySelector(".add");
    icon.classList.remove("hidden");
}

function openModal(event){

    console.log("Apertura modale");
    const mod=event.currentTarget;
    if(!mod.classList.contains("clicked")){
    overlay.classList.remove("hidden");
    mod.classList.remove("no_select");
    mod.classList.add("clicked");
    mod.querySelector(".modal").classList.add("show");
   
    const icon=mod.querySelector(".add");
    icon.classList.add("hidden");
    
    }else{
       console.log("Modale attualmente aperta");
    }
  }



function onResponse(response){
    console.log(response);
    return response.json();
}


function onJsonMovie(json){
    console.log(json);
    //Svuoto la libreria
    const box=document.getElementById("contents");
    box.innerHTML="";
    if(!json.result.length){
        console.log("Nessun risultato trovato");
        exit;
    }

   const head = document.querySelector("header");
   const res=document.createElement("h3");
   res.classList.add("res");
   res.innerHTML=json.result.length + " risultati trovati:";
   head.appendChild(res);

   //Elaboro i risultati e li visualizzo a schermo

    for(let elem in json.result){
    const movie=document.createElement("div");
    movie.classList.add("movie");

    movie.dataset.id=json.result[elem].imdbId;

    const poster=document.createElement("div");
    poster.classList.add("poster");
    movie.appendChild(poster);

    const image=document.createElement("img");
    image.src=json.result[elem].posterURLs['500'];
    poster.appendChild(image);

    const title=document.createElement("div");
    title.classList.add("movie_title");
    poster.appendChild(title);

    const info=document.createElement("h3");
    info.classList.add("titolo");
    info.innerHTML=json.result[elem].title;
    title.appendChild(info);

    //Aggiungo i dati alla modale


   const modal=document.createElement("div");
   modal.classList.add("modal");
   const year=document.createElement("span");
   year.innerHTML="Data di uscita: " + json.result[elem].year;
   modal.appendChild(year);
   const rating=document.createElement("span");
   rating.innerHTML="Voto IMDB: "+ json.result[elem].imdbRating;
   modal.appendChild(rating);
   const time=document.createElement("span");
   time.innerHTML="Durata: " + json.result[elem].runtime + "min";
   modal.appendChild(time);
   movie.appendChild(modal);

   //Creo il tag di aggiunta alla watchlist

   const add=document.createElement("div");
   add.classList.add("add");
   movie.appendChild(add);
   const icon=document.createElement("div");
   icon.value="";
   icon.classList.add("add_icon");
   icon.title="Aggiungi alla watchlist";
   
   add.appendChild(icon);
   add.addEventListener("click",addWatchlist);


   movie.classList.add("no_select");
   movie.addEventListener("click",openModal);
   box.appendChild(movie);

}
    
}

function search(event){
    //Acquisisco l'elemento da cercare e lo invio,tramite fetch,alla pagina PHP
    const form_data = new FormData(document.querySelector("#src"));
    fetch("searchMovie.php?q="+encodeURIComponent(form_data.get('search'))).then(onResponse).then(onJsonMovie);
    event.preventDefault();
}


function addWatchlist(event){
     //Acquisisco i dati dell'elemento selezionato e li aggiungo al database
    console.log("Acquisizione dati...");
    const elem=event.currentTarget.parentNode;
    const movieForm=new FormData();
    const title= elem.querySelector(".movie_title h3").innerHTML;
    const post=elem.querySelector(".poster img").src;
    const id_movie=elem.dataset.id;
    movieForm.append('title',title);
    movieForm.append('poster',post);
    movieForm.append('id',id_movie);
    fetch("addWatchlist.php",{method:'POST',body:movieForm}).then(onDBResponse).then(onDBjson);
    event.stopPropagation();
}


function onDBResponse(response){

if(!response){
    return console.log("Errore nella risposta");
}
    console.log(response);
    return response.json();
}

function onDBjson(json){

    if(!json.ok){
        return console.log("Elemento già presente nel database");
    }else{
      console.log("Elemento inserito correttamente");

    }

}


