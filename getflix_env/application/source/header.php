<nav class="navbar navbar-expand-lg navbar-dark bg-black py-2">
    <div class="container-fluid">
        <a class="navbar-brand px-4" href="./index.php">
            <img src="./img/logo_room237.svg"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav me-auto mb-lg-0">
                <li class="nav-item mx-4 my-auto">
                    <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
                </li>
                <?php if (isset($_SESSION['user'])) : ?>
                    <li class="nav-item mx-4 my-auto">
                        <a class="nav-link" href="./profil.php">
                            <img src="./img/person.svg" alt="user"> My profile
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (!isset($_SESSION['user'])) : ?>
                    <li class="nav-item mx-4 my-auto">
                        <a class="nav-link" href="./create_account.php">Subscribe</a>
                    </li>
                    <li class="nav-item mx-4 my-auto">
                        <button class="m-1 btn btn-danger px-3"><a class="nav-link  m-0 p-0" href="./register.php">Login</a></button>
                    </li>
                <?php else : ?>
                    <li class="nav-item mx-4 my-auto">
                        <button class="m-1 btn btn-dark boder border-1 border-danger px-3" type="submit"><a class="nav-link m-0 p-0" href="./deconnect.php">Logout</a></button>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['user']['user_type']) == 'admin') { ?>
                    <li class="nav-item mx-4 my-auto">
                        <a class="nav-link" href="./admin.php">Admin</a>
                    </li>
                <?php } ?>
            </ul>
            <form action="./main.php" method="get" class="d-flex mx-4">
                <input name="search2" value="" class="m-1 form-control bg-light border border-1 border-danger rounded-pill bg-opacity-10 text-light ps-3 ps-2" type="search" placeholder="Search" aria-label="Search">
                <button class="m-1 btn btn-danger px-3" type="submit"><img src="./img/search.svg" alt="search"></button>
            </form>
        </div>
    </div>
</nav>