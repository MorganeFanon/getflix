<?php
$mot = "horror";
if (isset($_GET["search"])) {
    $mot = $_GET["search"];
}

if (isset($_GET["search2"])) {
    $mot = $_GET["search2"];
}

$key = "api_key=<<api_key>>";
//$genres = "&with_genres=27";

$curl = curl_init("https://api.themoviedb.org/3/search/movie?" . $key . "&language=en-US&query=" . $mot . "&include_adult=false");
// ici il s'agit de donner le certificat mais ça ne marche pas!!
//curl_setopt($curl, CURLOPT_CAINFO, __DIR__ . DIRECTORY_SEPARATOR . 'cert.cer');
// du coup, déconseillé:
curl_setopt_array($curl, [
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 1
]);
$data = curl_exec($curl);
//var_dump($data);
if ($data === false) {
    var_dump(curl_error($curl));
} else {
    if (curl_getinfo($curl, CURLINFO_HTTP_CODE) === 200) {
        $data = json_decode($data, true);
        // echo "<pre>";
        // var_dump($data);
        // echo "</pre>";
    } else {
        //echo "Erreur";
        echo (curl_getinfo($curl, CURLINFO_HTTP_CODE));
    }
}
curl_close($curl);

$posters = $data["results"];

//var_dump($posters);

?>


<div class="container_banner" id="container_banner">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mx-auto justify-content-center" id="films_container_container">
            <div id="films_container">
                <!-- On injecte ici tous les films (img) -->
                <?php if (isset($_GET["search"]) || isset($_GET["search2"])) {
                    foreach ($posters as $poster) {
                        if ($poster['poster_path'] != "") {
                            $genre_ids = $poster['genre_ids'];
                            foreach ($genre_ids as $genre_id) {
                                if ($genre_id == 27) { ?>
                                    <form action="" method="GET" class="form_movie" name="movie" value="<?= $poster['id'] ?>">
                                        <a class="lien" style="max-width: 185px;" href="./movie_page.php?id=<?= $poster['id'] ?>">
                                            <img style="max-width: 154px;" id=" <?= $poster['id'] ?>" src="<?= "https://image.tmdb.org/t/p/w154/" . $poster['poster_path'] ?>" class="img_poster" alt="<?= $poster['title'] ?>">
                                        </a>
                                    </form> <?php
                                        }
                                    }
                                }
                            }
                        } ?>
            </div>
        </div>
    </div>
</div>