<?php

/**
 * @var array $data
 */

include $_SERVER['DOCUMENT_ROOT'] . '/public/pages/layout/header.php';
?>
<div class="container">
    <div class="row">
        <main class="col-lg-6 py-md-5 bd-content mx-auto">
            <h1 class="bd-title" id="content"><?= htmlspecialchars($data['title']) ?></h1>
            <form method="post">
                <div class="mb-3">
                    <label for="userNameInput">Name</label>
                    <input
                        type="text"
                        class="form-control"
                        id="userNameInput" name="userName"
                        placeholder="Enter your name"
                        value="<?= htmlspecialchars($data['userName']) ?>"
                        required
                    >
                </div>
                <div class="mb-3">
                    <label for="emailInput">Email</label>
                    <input
                        type="email"
                        class="form-control"
                        id="emailInput"
                        name="email"
                        placeholder="foo@bar.com"
                        value="<?= htmlspecialchars($data['email']) ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="descriptionArea" class="form-label">Description</label>
                    <textarea
                            class="form-control"
                            id="descriptionArea"
                            rows="3" name="description"
                            placeholder="Task description"
                            required
                    ><?= htmlspecialchars($data['description']) ?></textarea>
                </div>
                <?php if (!empty($data['error'])): ?>
                    <p class="fw-normal text-danger"><?= htmlspecialchars($data['error']) ?></p>
                <?php endif; ?>

                <?php if (!empty($data['id'])): ?>
                    <button type="submit" class="btn btn-primary btn-secondary">Task edit</button>
                    <input type="hidden" name="edit">
                    <input type="hidden" name="token" value="<?= $data['token'] ?>">
                <?php else: ?>
                    <button type="submit" class="btn btn-primary btn-secondary">Task create</button>
                    <input type="hidden" name="create">
                <?php endif; ?>
            </form>
        </main>
    </div>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/public/pages/layout/footer.php';