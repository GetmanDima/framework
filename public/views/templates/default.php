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
    <title><?=$title?></title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>

<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Framework</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?=$title === 'Home' ? 'active' : ''?>" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?=$title === 'Login' ? 'active' : ''?>" href="/login">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?=$title === 'Sign Up' ? 'active' : ''?>" href="/register">Sign Up</a>
                </li>
            </ul>
            <form class="my-2 my-lg-0 mx-lg-2 mx-md-0" action="/logout" method="POST">
                <button type="submit" class="nav-link link-secondary px-0">Logout</button>
            </form>
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