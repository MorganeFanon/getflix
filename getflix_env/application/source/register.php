<?php
// On va pouvoir connecter la session
session_start();
if (isset($_SESSION['user'])) {
    header('Location: ./index.php');
    exit();
}
// Placer la partie logique autant que possible séparée de l'html
$email = '';
$password = '';
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = strip_tags($data);
    return $data;
}

// vérifier si le form a été envoye
if (!empty($_POST)) {
    // à partir d'ici je sais que le formulaire a été envoyé
    // Mnt on vérifie que tous les champs requis (ici tous) sont remplis
    if (
        isset($_POST['email'], $_POST['password']) and
        !empty($_POST['email']) and
        !empty($_POST['password'])
    ) {
        // messaga à l'utilisateur
        $_SESSION['error'] = [];
        // le formulaire est complété
        // On vérifie que le mail a le bon format
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'][] = 'This email is invalid.';
        }
        if ($_SESSION['error'] === []) {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = test_input($_POST['password']);
            // la connexion à la base de données
            include_once './connect.php';
            $sql = 'SELECT * FROM register WHERE `email` = :email';
            $query = $conn->prepare($sql);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->execute();
            $user = $query->fetch();

            if (!$user) {
                $_SESSION['error'] = ['incorrect user or password'];
            }

            // Ici, on a donc un user existant. On peut vérifier son mdp
            if (!password_verify($password, $user['password'])) {
                $_SESSION['error'] = ['incorrect user or password'];
            }

            if ($_SESSION['error'] === []) {
                // L'utilisateur et le mdp sont corrects

                // On stocke dans cette session les infos de l'utilisateur
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'email' => $user['email'],
                    'user_type' => $user['user_type'],
                ];

                // On peut rediriger l'utilisateur
                header('Location: ./index.php');
            }
        }
    } else {
        $_SESSION['error'] = ['Please, fill-in the form correctly.'];
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="logo_icon" href="./img/cercle.svg">
    <!-- Bootstrap styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Create account</title>
    <!-- Font Rajdhani -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font awesome -->
    <script src="https://kit.fontawesome.com/8e9298d105.js" crossorigin="anonymous"></script>
    <!-- styles -->
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <!-- Flèches typo -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope&display=swap" rel="stylesheet">
</head>

<body class="bg-dark text-white">
    <?php include_once './header.php'; ?>
    <!-- Titre et logo -->
    <div class="container" id="logo_et_titre">

        <div class="row mb-4 mt-4">

            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mx-auto justify-content-center mt-5">

                <h5 class="text-center">Welcome back!</h5>
            </div>
        </div>
    </div>

    <!-- Form sign in -->
    <div class="container" id="sign_in">
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-6 col-lg-4 mx-auto justify-content-center">
                <!-- S'identifier // form -->
                <?php if (isset($_SESSION['error'])) {
                    foreach ($_SESSION['error'] as $message) { ?>
                        <p style='color:red'><?php echo $message; ?></p>
                <?php }
                    unset($_SESSION['error']);
                } ?>
                <form method="post" action="" id="form">
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="email address" autofocus required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="password" maxlength="13" minlength="8" required>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button name="submit" type="submit" class="btn btn-outline-light">Sign in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Mot de passe oublié -->
    <!-- S'inscrire -->
    <div class="container mt-4" id="create_account">
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-6 col-lg-4 mx-auto justify-content-center">
                <div class="border-bottom border-danger border-bottom-2 pb-4">
                    <a href="./forgot_password.php" class="text-light">Mot de passe oublié?</a>
                </div>
                <div class="pt-4">
                    <a href="./create_account.php" class="text-light link-light">Not a member?<strong class="text-danger"> Sign up now</strong> </a>
                </div>
            </div>
        </div>
    </div>
    <?php include_once './footer.php'; ?>
    <!-- ////////////////////////////////////////////////////////////////////////////////////////// -->
    <!--  Popper and Bootstrap JS jquery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
</body>

</html>