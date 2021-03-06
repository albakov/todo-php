<?php include_once __DIR__ . '/../layout/header.php'; ?>

    <main class="main pt-4">
        <div class="container">
            <h1 class="mb-4">Редактирование задачи</h1>

            <?php include_once __DIR__ . '/../parts/errors.php'; ?>
            <?php include_once __DIR__ . '/../parts/task-updated-message.php'; ?>

            <form action="/update?id=<?php echo $id; ?>" class="form" method="post">
                <div class="form-group">
                    <?php foreach ($fields as $key => $field): ?>
                        <div class="mb-3">
                            <label for="<?php echo $key; ?>" class="form-label"><?php echo $field['label']; ?></label>
                            <?php if ($field['type'] === 'textarea'): ?>
                                <textarea class="form-control" name="<?php echo $key; ?>" id="<?php echo $key; ?>" rows="3"
                                          placeholder="<?php echo $field['label']; ?>" required><?php echo $item[$key]; ?></textarea>
                            <?php else: ?>
                                <input type="<?php echo $field['type']; ?>" class="form-control" name="<?php echo $key; ?>" id="<?php echo $key; ?>"
                                       placeholder="<?php echo $field['label']; ?>" required value="<?php echo $item[$key]; ?>">
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    <div class="mb-3">
                        <label for="status" class="form-label">Статус</label>
                        <select name="status" class="form-select" id="status">
                            <?php foreach (['Выполнено', 'Не выполнено'] as $k => $v): ?>
                                <option value="<?php echo $k; ?>" <?php echo $k === (int)$item['status'] ? 'selected' : ''; ?>>
                                    <?php echo $v; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <a href="/" class="btn btn-light">Отмена</a>
                        <button type="submit" class="btn btn-success">Обновить</button>
                    </div>
                </div>
            </form>
        </div>
    </main>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>