<?php

header("HTTP/1.1 404 Not Found");

/**
 * @var array $data
 */

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/pages/layout/style.css">
    <link rel="stylesheet" href="/public/pages/error/style.css">
    <link rel="stylesheet" href="/public/vendor/bootstrap-5.0.0-beta3-dist/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="/public/vendor/bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css">
    <title><?= $data['title']; ?></title>
</head>
<body>
    <main class="error-container d-flex m-auto flex-column">
        <h1 class="error-code display-1 text-center">404</h1>
        <p class="error-title lead">Страница не найдена</p>
        <a href="/" class="btn btn-lg btn-outline-secondary">На главную</a>
    </main>
</body>
</html>