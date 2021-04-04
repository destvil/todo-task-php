<?php

/**
 * @var array $data
 */

use destvil\Core\Application;

include $_SERVER['DOCUMENT_ROOT'] . '/public/pages/layout/header.php';
?>
<div class="container">
    <div class="row">
        <main class="col-lg-6 py-md-5 bd-content mx-auto">
            <h1 class="bd-title" id="content">Authorization</h1>
            <form method="post">
                <div class="mb-3">
                    <label for="loginInput">Login</label>
                    <input type="text" class="form-control" id="loginInput" name="login" placeholder="Enter login" required>
                </div>

                <div class="mb-3">
                    <label for="passwordInput">Password</label>
                    <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Password" required>
                </div>

                <?php if (!empty($data['error'])): ?>
                    <p class="fw-normal text-danger"><?= htmlspecialchars($data['error']) ?></p>
                <?php endif; ?>

                <button type="submit" class="btn btn-primary btn-secondary">Authorize</button>
                <input type="hidden" name="token" value="<?= $data['token'] ?>">
                <input type="hidden" name="auth">
            </form>
        </main>
    </div>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/public/pages/layout/footer.php';