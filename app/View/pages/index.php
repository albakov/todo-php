<?php include_once __DIR__ . '/../layout/header.php'; ?>

    <main class="main pt-4">
        <div class="container">
            <div class="d-flex w-100 mb-4 align-items-baseline justify-content-between">
                <h1>Список задач</h1>

                <div class="btn-group">
                    <a href="/create" class="btn btn-success">Добавить</a>
                    <?php if ($isAdmin): ?>
                        <a href="/logout" class="btn btn-info text-white">Выйти</a>
                    <?php else: ?>
                        <a href="/login" class="btn btn-info text-white">Войти</a>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (count($items) > 0): ?>
                <form action="/" method="get" class="mb-3">
                    <div class="input-group w-auto ms-auto">
                        <select name="sort" class="form-select">
                            <option value="">Сортировка</option>
                            <?php foreach ($sortFields as $k => $sortField): ?>
                                <option value="<?php echo $k; ?>" <?php echo $requestedSort === $k ? 'selected' : ''; ?>>
                                    <?php echo $sortField; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-info text-white">Применить</button>
                    </div>
                </form>

                <div class="list-group">
                    <?php foreach ($items as $item): ?>
                        <div class="list-group-item list-group-item-action <?php echo (int)$item['status'] === 0 ? 'text-decoration-line-through' : ''; ?>">
                            <h6 class="mb-1"><?php echo $item['user_name']; ?> (<?php echo $item['user_email']; ?>)</h6>
                            <p class="mb-1"><?php echo $item['task_text']; ?></p>
                            <?php if ((int)$item['edit'] === 1): ?>
                                <div class="mb-1">
                                    <i class="small">[Отредактировано]</i>
                                </div>
                            <?php endif; ?>
                            <?php if ($isAdmin): ?>
                                <a href="/edit?id=<?php echo $item['id']; ?>" class="btn btn-info text-white btn-sm">Редактировать</a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php include_once __DIR__ . '/../parts/pagination.php'; ?>
            <?php else: ?>
                Задач нет.
            <?php endif; ?>
        </div>
    </main>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>