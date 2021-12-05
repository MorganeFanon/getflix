// API key has to be updated if you want the code to work! 
const API_KEY = "api_key=<<api_key>>";
const BASE_URL = "https://api.themoviedb.org/3";

const IMG_URL = "https://image.tmdb.org/t/p/w200/";
const the_main = document.getElementById("main");
const GENRES = "https://api.themoviedb.org/3/genre/movie/list?"+API_KEY+"&language=en-US";
const HORROR_THRILLER = "https://api.themoviedb.org/3/discover/movie?" + API_KEY + "&with_genres=27,53";
const DATE_60 = "&primary_release_date.gte=1960&primary_release_date.lte=169";
const HORROR_SIXTIES = "https://api.themoviedb.org/3/discover/movie?" + API_KEY + "&with_genres=27" + DATE_60;

// chemins parie bannière img placement et url
const banner_img1 = document.getElementById("banner_img1");
const banner_img2 = document.getElementById("banner_img2");
const banner_img3 = document.getElementById("banner_img3");
var scrollAmount = 0;

const SHINING = "https://api.themoviedb.org/3/movie/694?" + API_KEY + "&language=en-US";
const ORANGE_MECANIQUE = "https://api.themoviedb.org/3/movie/185?" + API_KEY + "&language=en-US";
const SILENCE_AGNEAUX = "https://api.themoviedb.org/3/movie/274?" + API_KEY + "&language=en-US";

const SHINING_BG = "https://image.tmdb.org/t/p/original/AdKA2F1SzYPhSZdEbjH1Zh75UVQ.jpg";
const OR_MEC_BG = "https://image.tmdb.org/t/p/original/3w2v0iNPPNeIKOV5wu1NU1DDHHy.jpg";
const SIL_AG_BG = "https://image.tmdb.org/t/p/original//mfwq2nMBzArzQ7Y9RKE8SKeeTkg.jpg";

// partie caroussel

const sliders = document.querySelector(".carousselbox");
//const the_main = document.getElementById("main");
var scrollPerClick;
var imagePadding = 20;

// partie tous films
const films_container= document.getElementById("films_container");
var imagePadding = 20;
