function onJsonMovie(json){
//Svuoto la libreria
const box=document.getElementById("contents");
box.innerHTML="";
console.log(json);

   if(!json.length){
    const empty=document.createElement("div");
    empty.classList.add("empty");
    const par=document.createElement("p");
    par.innerHTML="Nessun elemento aggiunto alla watchlist!";
    empty.appendChild(par);
    box.appendChild(empty)
   }


for(const elem of json){
    //Creo i box che conterranno gli elementi della watchlist
    const movie=document.createElement("div");
    movie.classList.add("movie");

    movie.dataset.id=JSON.parse(elem.content).movie_id;

    const poster=document.createElement("div");
    poster.classList.add("poster");
    movie.appendChild(poster);

    const image=document.createElement("img");
    image.src=JSON.parse(elem.content).poster;
    poster.appendChild(image);

    const title=document.createElement("div");
    title.classList.add("movie_title");
    poster.appendChild(title);

    const info=document.createElement("h3");
    info.innerHTML=JSON.parse(elem.content).title;
    title.appendChild(info);

    //Aggiungo il tag per eliminare un elemento dalla watchlist

    const del=document.createElement("div");
    del.classList.add("delete");
    movie.appendChild(del);
    const icon=document.createElement("div");
    icon.classList.add("delete_icon");
    icon.title="Rimuovi dalla watchlist";
    del.appendChild(icon);

    del.addEventListener("click",deleteMovie);

    box.appendChild(movie);

}
}

function onResponse(response){
    if(!response) return console.log("Errore in fase di acquisizione dati");
    console.log(response);
    return response.json();
}


function deleteMovie(event){
    console.log("Elimazione dalla lista...");
    const elem=event.currentTarget.parentNode;
    const movieForm=new FormData();
    const title= elem.querySelector(".movie_title h3").innerHTML;
    const post=elem.querySelector(".poster img").src;
    const id_movie=elem.dataset.id;
    movieForm.append('title',title);
    movieForm.append('poster',post);
    movieForm.append('id',id_movie);
    fetch("deleteMovie.php",{method:'POST',body:movieForm}).then(onResponse).then(onDBjson);
    elem.remove();
    event.stopPropagation();


}


function onDBjson(json){

    if(!json.ok){
        return console.log("Elemento non presente nel database");
    }else{
        console.log("Elemento eliminato correttamente");

    }

}



fetch("fetchMovies.php").then(onResponse).then(onJsonMovie);