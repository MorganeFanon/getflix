<?php
// On connecte l'usager, cela doit se faite en début du code de préférence
session_start();

// Placer la partie logique autant que possible séparée de l'html
$first_name = "";
$last_name = "";
$email = "";
$password = "";
$message_erreur = "";

// vérifier si le form a été envoye 
if (!empty($_POST)) {
    // à partir d'ici je sais que le formulaire a été envoyé
    // Mnt on vérifie que tous les champs requis (ici tous) sont remplis
    if (isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password']) and !empty($_POST['first_name']) and !empty($_POST['last_name']) and !empty($_POST['email']) and !empty($_POST['password'])) {
        // le formulaire est complété
        // On protège les données
        // On enregistre en base de données
        require_once "./connect.php";


        $first_name = htmlentities($_POST['first_name']);
        $last_name = htmlentities($_POST['last_name']);

        // je vérifie que le mail donné a bien une structure email 
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $message_erreur = "Your email address info is not correct";
            die("Your email address info is not correct");
        }
        $email = htmlentities($_POST['email']);
        // Vérifie que le mail n'est pas déjà dans la base de données
        $sql2 = "SELECT * FROM register WHERE email=:email";
        $query = $conn->prepare($sql2);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $cnt = 1;
        if ($query->rowCount() > 0) {
            $message_erreur = "The email already exists.";
            die("The email already exists.");
        }


        // vérifier que le password check est bon
        if (htmlentities($_POST['password']) != htmlentities($_POST['password2'])) {
            $message_erreur = "The password has to be the same in both entries";
            die();
        }

        // On va hacher le mot de passe
        $password = password_hash($_POST['password'], PASSWORD_ARGON2ID);

        // Ici on peut ajouter tous les contrôles supplémentaires qu'on souhaite (nom?prenom?)

        $sql = ("INSERT INTO `register`(`first_name`, `last_name`, `email`, `password`) VALUES (:first_name, :last_name, :email, :password)");
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        // Insérer le dernier id placé dans le table 
        $id = $conn->lastInsertId();

        // On stocke dans cette session les infos de l'utilisateur
        $_SESSION["user"] = [
            "id" => $id,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "email" => $email
        ];

        // On peut rediriger l'utilisateur
        //header("profile: index.php");
    } else {
        $message_erreur = "Please, fill-in the form correctly.";
        die();
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- icone onglet à placer plus tard 
    <link rel="icon" type="image/png" href="">
    -->
    <!-- Bootstrap styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Create account</title>
    <!-- Font Rajdhani -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>

<body class="bg-dark text-white">
    <!-- Titre et logo -->
    <div class="container" id="logo_et_titre">
        <div class="row mb-4 mt-4">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mx-auto justify-content-center">
                <div class="text-center" id="logo_container">
                    <img src="./img/netflix_petit.png" alt="logo" id="logo">
                </div>
                <h5 class="text-center">Create your account and join Getflix</h5>
            </div>
        </div>
    </div>

    <!-- Form new account -->
    <div class="container" id="sign_in">
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-6 col-lg-4 mx-auto justify-content-center">
                <!-- S'identifier // form -->
                <form method="post" action="" id="form">
                    <div class="mb-3">
                        <input type="text" name="first_name" class="form-control form-control-lg" id="first_name" placeholder="first name" minlength="1" maxlength="40" autofocus required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="last_name" class="form-control form-control-lg" id="last_name" minlength="1" maxlength="40" placeholder="last name" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control form-control-lg" id="email" aria-describedby="emailHelp" placeholder="email address" minlength="5" maxlength="40" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control form-control-lg" id="password" placeholder="password" maxlength="12" minlength="8" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password2" class="form-control form-control-lg" id="password2" placeholder="repeat password" maxlength="12" minlength="8" required>
                        <div class="form-text text-light">Password between 8 and 12 characters.</div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button name="submit" type="submit" class="btn btn-outline-light">Create account</button>
                    </div>
                </form>
                <div id="alert_message">
                    <p><?= $message_erreur ?></p>
                </div>
            </div>
        </div>
    </div>


    <!-- ////////////////////////////////////////////////////////////////////////////////////////// -->
    <!--  Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="./create_account.js"></script>
</body>

</html>