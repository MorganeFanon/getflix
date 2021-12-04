//const API_KEY = "api_key=<<api_key>>";
const HORROR_LATEST = "https://api.themoviedb.org/3/movie/upcoming?" + API_KEY + "&with_genres=27&language=en-US&page=1";

//https://api.themoviedb.org/3/movie/upcoming?api_key=<<api_key>>&language=en-US&page=1

showMovieData();

function sliderScrollLeft() {
    sliders.scrollTo({
        top: 0,
        left: (scrollAmount -= scrollPerClick),
        behavior: "smooth"
    });

    if (scrollAmount < 0) {
        scrollAmount = 0;
    }
}

function sliderScrollRight() {
    if(scrollAmount <= sliders.scrollWidth - sliders.clientWidth) {
        sliders.scrollTo({
            top: 0,
            left: (scrollAmount += scrollPerClick),
            behavior: "smooth"
        })
    }
}

async function showMovieData() {

    var result = await axios.get (
        HORROR_LATEST
    );

    //console.log(result.data.results)
    result = result.data.results;

    result.map(function (cur, index){
        if (cur.poster_path != null) {
        sliders.insertAdjacentHTML(
            "beforeend",
            `<form action="" method="GET" class="form_movie img-${index}" name="movie" value="${cur.id}">
                <a class="lien" style="max-width: 185px;" href="./movie_page.php?id=${cur.id}">
                    <img style="max-width: 154px;" id="${cur.id}" src="https://image.tmdb.org/t/p/w154/${cur.poster_path}" class="img_poster" alt="${cur.id}">
                </a>
            </form>`
        ) }
    })

    //scrollPerClick = document.querySelector(".img-1").clientWidth + imagePadding;
    scrollPerClick = 400;
    
}






