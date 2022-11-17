<?php
/** @var string $contentHTML */
/** @var \App\Core\IAuthenticator $auth */
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <title><?= \App\Config\Configuration::APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="public/css/styl.css">
    <script src="public/js/script.js"></script>

    <link rel="stylesheet" href="../../public/css/clanky.css">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- aby fungoval responzivny bootstrap -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="?c=home">NezavisleNoviny.sk</a>
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <li class="nav-item"><a class="nav-link" href="#">Domov</a></li>
                <li class="nav-item"><a class="nav-link" href="#">O nás</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Kontakt</a></li>
            </li>
        </ul>
        <?php if ($auth->isLogged()) { ?>
            <span class="navbar-text">Prihlásený používateľ: <b><?= $auth->getLoggedUserName() ?></b></span>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="?c=auth&a=logout">Odhlásenie</a>
                </li>
            </ul>
        <?php } else { ?>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= \App\Config\Configuration::LOGIN_URL ?>">Prihlásenie</a>
                </li>
            </ul>
        <?php } ?>
    </div>
</nav>

<div class="container-fluid mt-3">
    <div class="web-content">
        <?= $contentHTML ?>
    </div>
</div>


<!-- pagination + footer -->
<nav aria-label="Pagination">
    <hr class="my-0" />
    <ul class="pagination justify-content-center my-4">
        <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Newer</a></li>
        <li class="page-item active" aria-current="page"><a class="page-link" href="#!">1</a></li>
        <li class="page-item"><a class="page-link" href="#!">2</a></li>
        <li class="page-item"><a class="page-link" href="#!">3</a></li>
        <li class="page-item disabled"><a class="page-link" href="#!">...</a></li>
        <li class="page-item"><a class="page-link" href="#!">15</a></li>
        <li class="page-item"><a class="page-link" href="#!">Older</a></li>
    </ul>
</nav>
<footer class="py-5 bg-dark">
    <div class="container"><p class="m-0 text-center text-white">Nezávislé Noviny Copyright © 2022</p></div>
</footer>

</body>
</html>