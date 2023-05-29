function Onresponse(response){
    console.log(response);
    if(!response){
        console.log("Errore");
    }
    return response.json();
}

function onJson(json){
    console.log(json);
    //Svuoto la libreria
    const box=document.getElementById("contents");
    box.innerHTML="";
 
//Elaboro i risultati e li visualizzo a schermo
 for(let elem in json.results){
 const movie=document.createElement("div");
 movie.classList.add("movie");

 const poster=document.createElement("div");
 poster.classList.add("poster");
 movie.appendChild(poster);

 const image=document.createElement("img");
 image.src="https://image.tmdb.org/t/p/original"+json.results[elem].poster_path;
 poster.appendChild(image);

 const title=document.createElement("div");
 title.classList.add("movie_title");
 poster.appendChild(title);

 const info=document.createElement("h3");
 info.innerHTML=json.results[elem].title;
 title.appendChild(info);

 const date=document.createElement("h4");
 date.innerHTML="Data di uscita: "+json.results[elem].release_date;
 title.appendChild(date);

 box.appendChild(movie);

}

}

const api_url='https://api.themoviedb.org/3/movie/upcoming?language=en-US&page=1';
const options = {
    method: 'GET',
    headers: {
      accept: 'application/json',
      Authorization: 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJiNGEwZTVmMzVkMWFiZjIyOTU5NWZjYjZlYmVmMDIzNCIsInN1YiI6IjY0NzRjODhjOWFlNjEzMDEyNTdjZTdiNyIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.kgSe55V2MT0Uw1Miw5EOS6LuGET7Fs4bc6AQvoKhLwI'
    }
  };


fetch(api_url,options).then(Onresponse).then(onJson);