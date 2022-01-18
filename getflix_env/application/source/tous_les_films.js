//const API_KEY = "api_key=<<api_key>>";
var HORROR = "https://api.themoviedb.org/3/discover/movie?" + API_KEY + "&with_genres=27";

// How to fetch general data from a movie



// tous les genres
const liste_genres = [
    {
      "id": 28,
      "name": "Action"
    },
    {
      "id": 12,
      "name": "Adventure"
    },
    {
      "id": 16,
      "name": "Animation"
    },
    {
      "id": 35,
      "name": "Comedy"
    },
    {
      "id": 80,
      "name": "Crime"
    },
    {
      "id": 99,
      "name": "Documentary"
    },
    {
      "id": 18,
      "name": "Drama"
    },
    {
      "id": 10751,
      "name": "Family"
    },
    {
      "id": 14,
      "name": "Fantasy"
    },
    {
      "id": 36,
      "name": "History"
    },
    {
      "id": 27,
      "name": "Horror"
    },
    {
      "id": 10402,
      "name": "Music"
    },
    {
      "id": 9648,
      "name": "Mystery"
    },
    {
      "id": 10749,
      "name": "Romance"
    },
    {
      "id": 878,
      "name": "Science Fiction"
    },
    {
      "id": 10770,
      "name": "TV Movie"
    },
    {
      "id": 53,
      "name": "Thriller"
    },
    {
      "id": 10752,
      "name": "War"
    },
    {
      "id": 37,
      "name": "Western"
    }
  ]

const filter_container = document.getElementById("films_filters");

var lastUrl = '';
const sixties_seventies = "&primary_release_date.gte=1960&primary_release_date.lte=1979";
const documentary = ",99";
const thriller = ",53";
const drama = ",18";
const fantasy = ",14";
const science_fiction = ",878";
const mistery = ",9648";

// buttons 
var b_sixties_seventies = document.getElementById("old_movies");
var b_documentary = document.getElementById("documentary");
var b_thriller = document.getElementById("thriller");
var b_drama = document.getElementById("drama");
var b_fantasy = document.getElementById("fantasy");
var b_science_fiction = document.getElementById("science_fiction");
var b_mistery = document.getElementById("mistery");

// enlever ou rajouter dans une variable les filtres
var select_HORROR = HORROR;

setGenre(b_sixties_seventies, sixties_seventies);
setGenre(b_documentary, documentary);
setGenre(b_thriller, thriller);
setGenre(b_drama, drama);
setGenre(b_fantasy, fantasy);
setGenre(b_science_fiction, science_fiction);
setGenre(b_mistery, mistery);

// function pour filtrer
function setGenre(button, text) {
    button.addEventListener("click", () => {
        if(button == b_sixties_seventies) {
            if(button.ariaPressed == "true") {
                select_HORROR += text;
                getMovies(select_HORROR);
                console.log(select_HORROR);
            } else {
                select_HORROR = select_HORROR.replace(text, "");
                getMovies(select_HORROR);
                console.log(select_HORROR);
            }
        } else if(select_HORROR.indexOf(sixties_seventies)  > -1) {
            if(button.ariaPressed == "true") {
                select_HORROR = select_HORROR.replace(sixties_seventies, "");
                select_HORROR += (text + sixties_seventies);
                getMovies(select_HORROR);
                console.log(select_HORROR);
            } else {
                select_HORROR= select_HORROR.replace(text, "");
                getMovies(select_HORROR);
                console.log(select_HORROR);
        }} else {
            if(button.ariaPressed == "true") {
                select_HORROR += text;
                getMovies(select_HORROR);
                console.log(select_HORROR);
            } else {
                select_HORROR= select_HORROR.replace(text, "");
                getMovies(select_HORROR);
                console.log(select_HORROR);
            }  
        }
        
    })
}


// On va dans:

// dans results


// Afficher tous les films d'horreur
getMovies(HORROR);

function getMovies(url) {
  lastUrl = url;
    fetch(url).then(res => res.json()).then(data => {
        //console.log(data.results);
        showMovies(data.results);       
    })

}


// const films_container= document.getElementById("films_container");

function showMovies(data) {
    films_container.innerHTML = '';

    data.forEach(function (cur, index){
        if(cur.poster_path != null) {
            if (window.matchMedia("(max-width: 500px)").matches) {
                films_container.insertAdjacentHTML(
                    "beforeend",
                    `<form action="" method="GET" class="form_movie">
                    <a type="submit" name="movie" class="lien" href="./movie_page.php?id=${cur.id}">
                    <img value="${cur.id} id="${cur.id}" class="img-${index} img_movie" src="https://image.tmdb.org/t/p/w92/${cur.poster_path}" /> </a>
                    </form>`
                )
              } else {
                films_container.insertAdjacentHTML(
                  "beforeend",
                    `<form action="" method="GET" class="form_movie">
                    <a type="submit" name="movie" class="lien" href="./movie_page.php?id=${cur.id}">
                    <img value="${cur.id} id="${cur.id}" class="img-${index} img_movie" src="https://image.tmdb.org/t/p/w185/${cur.poster_path}" /> </a>
                    </form>`
                )
              }

        }

    })
}

