<?php

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
    <link rel="stylesheet" href="/public/vendor/bootstrap-5.0.0-beta3-dist/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="/public/vendor/bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css">
    <title><?= $data['title']; ?></title>
</head>
<body>
<header id="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <ul class="navbar-nav justify-content-between">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/create/">Create task</a>
                </li>
                <?php if ($data['isAuthorize']): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/logout/">Logout</a>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="/login/">Login</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>
<div class="header-toasts position-relative">
    <div class="toast-container position-absolute top-0 end-0 p-3">
        <?php if (!empty($data['notify'])): ?>
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body"><?= $data['notify'] ?></div>
            </div>
        <?php endif; ?>
    </div>
</div>
<main id="main">