<?php
/**
 * @var string $title
 * @var string $view
 * @var array $vars
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>

<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Framework</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link <?= $title === 'Home' ? 'active' : '' ?>" aria-current="page" href="/">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= $title === 'Users' ? 'active' : '' ?>" aria-current="page" href="/users">Users</a>
                </li>

                <?php
                if (!isset($loggedUser)):
                    ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $title === 'Login' ? 'active' : '' ?>" href="/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $title === 'Register' ? 'active' : '' ?>" href="/register">Register</a>
                    </li>
                <?php
                endif;
                ?>
            </ul>

            <?php
            if (isset($loggedUser)):
                ?>
                <div>
                    <div class="d-inline-block me-3">
                        <?=$loggedUser->name?>
                    </div>
                    <form class="d-inline-block form-inline my-2 my-lg-0" action="/logout" method="POST">
                        <button type="submit" class="btn btn-outline-success my-2 my-sm-0">Logout</button>
                    </form>
                </div>
            <?php
            endif;
            ?>
        </div>
    </div>
</nav>

<main class="container mt-4">
    <?php
    includeView($view, $vars);
    ?>
</main>

<script src="/js/bundle.js"></script>
</body>
</html>