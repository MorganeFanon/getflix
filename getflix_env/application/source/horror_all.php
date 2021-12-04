<?php
$key = "api_key=<<api_key>>";
$genres = "&with_genres=27";

$curl = curl_init("https://api.themoviedb.org/3/discover/movie?" . $key . $genres);
// ici il s'agit de donner le certificat mais ça ne marche pas!!
//curl_setopt($curl, CURLOPT_CAINFO, __DIR__ . DIRECTORY_SEPARATOR . 'cert.cer');
// du coup, déconseillé:
curl_setopt_array($curl, [
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 1
]);
$data = curl_exec($curl);
if ($data === false) {
    var_dump(curl_error($curl));
} else {
    if (curl_getinfo($curl, CURLINFO_HTTP_CODE) === 200) {
        $data = json_decode($data, true);
        // echo "<pre>";
        // var_dump($data);
        // echo "</pre>";
    } else {
        echo "Erreur";
    }
}
curl_close($curl);

$posters = $data["results"];

?>

<!-- HORROR ALL ////////////////////////////////////////////////////////// -->

<!-- Les visuels des films -->
<div class="container_banner" id="container_banner">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mx-auto justify-content-center" id="films_container_container">
            <div id="films_container">
                <!-- On injecte ici tous les films (img) -->
                <?php foreach ($posters as $poster) {
                    if ($poster['poster_path'] != "") { ?>
                        <form action="" method="GET" class="form_movie" name="movie" value="<?= $poster['id'] ?>">
                            <a class="lien" style="max-width: 185px;" href="./movie_page.php?id=<?= $poster['id'] ?>">
                                <img style="max-width: 154px;" id=" <?= $poster['id'] ?>" src="<?= "https://image.tmdb.org/t/p/w154/" . $poster['poster_path'] ?>" class="img_poster" alt="<?= $poster['title'] ?>">
                            </a>
                        </form> <?php }
                        } ?>
            </div>
        </div>
    </div>
</div>