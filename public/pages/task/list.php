<?php

/**
 * @var array $data
 */

use destvil\Core\Application;

include Application::getInstance()->getDocumentRoot() . '/public/pages/layout/header.php';
?>
<div class="container pt-5 task-list">
    <div class="row">
        <div class="col-6 mx-auto">
        <div class="card">
            <div class="card-header">
            <h1 class="bd-title" id="content">Список задач</h1>
            <?php if (!empty($data['sortFields']) && !empty($data['tasks'])): ?>
                <!-- region sort -->
                <div class="task-list-sort">
                    <div class="list-group list-group-horizontal">
                        <?php foreach ($data['sortFields'] as $orderField => $fieldCaption): ?>
                            <?php if ($data['orderField'] === $orderField): ?>
                                <a
                                        href=""
                                        class="list-group-item list-group-item-action flex-fill<?= $data['orderField'] === $orderField ? ' active' : '' ?>"
                                        data-field="<?= $orderField ?>"
                                        data-order="<?= $data['orderValue'] ?>"
                                >
                                    <?= $fieldCaption ?>
                                </a>
                            <?php else: ?>
                                <a href="" class="list-group-item list-group-item-action flex-fill" data-field="<?= $orderField ?>">
                                    <?= $fieldCaption ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
                <!-- regionend sort -->
            <?php endif; ?>
            <div class="card-body px-0 pt-0">
                <?php if (!empty($data['tasks'])): ?>

                    <?php foreach ($data['tasks'] as $task): ?>
                        <div class="card my-3">
                            <h5 class="card-header"><?= htmlspecialchars($task['email']) ?></h5>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($task['userName']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($task['description']) ?></p>
                                <?php if ($data['isAuthorize']): ?>
                                    <?php if (!isset($task['statuses']['success'])): ?>
                                        <a href="/task/success/?id=<?= $task['id'] ?>" class="btn btn-success">Выполнено</a>
                                    <?php endif; ?>
                                    <a href="/edit/?id=<?= $task['id'] ?>" class="btn btn-primary">Изменить</a>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($task['statuses'])): ?>
                                <div class="card-footer">
                                <?php foreach ($task['statuses'] as $status): ?>
                                    <?php if ($status['name'] === 'success'): ?>
                                        <span class="badge bg-success"><?= htmlspecialchars($status['value']) ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><?= htmlspecialchars($status['value']) ?></span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>

                <?php else: ?>
                    <h5>Элементы не найдены</h5>
                <?php endif; ?>

                    <?php if ($data['lastPageNum'] > 1): ?>
                        <!-- region pagination -->
                        <nav>
                            <ul class="pagination justify-content-center task-list-pagination">
                                <li class="page-item<?= $data['currPageNum'] == 1 ? ' disabled' : '';?>">
                                    <a class="page-link" href="#" data-page="1">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php
                                $firstPageNav = ($data['currPage'] - 1) < 1 ? 1 : ($data['currPage'] - 1);
                                ?>
                                <?php for($currNavPage = $firstPageNav; $currNavPage <= $data['lastPageNum']; $currNavPage++): ?>
                                    <li class="page-item<?= $data['currPageNum'] == $currNavPage ? ' disabled' : '';?>">
                                        <a class="page-link" href="#" data-page="<?= $currNavPage ?>">
                                            <?= $currNavPage ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item<?= $data['currPageNum'] == $data['lastPageNum'] ? ' disabled' : '';?>">
                                    <a class="page-link" href="#" data-page="<?=$data['lastPageNum'] ?>">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <!-- regionend pagination -->
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="module" src="/public/pages/task/taskList.js"></script>
<script type="module" src="/public/pages/task/script.js"></script>

<?php
include Application::getInstance()->getDocumentRoot() . '/public/pages/layout/footer.php';