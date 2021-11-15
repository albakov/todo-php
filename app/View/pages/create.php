<?php include_once __DIR__ . '/../layout/header.php'; ?>

<main class="main pt-4">
    <div class="container">
        <h1 class="mb-4">Добавление задачи</h1>

        <?php include_once __DIR__ . '/../parts/errors.php'; ?>

        <form action="/store" class="form" method="post">
            <div class="form-group">
                <?php foreach($fields as $key => $field): ?>
                <div class="mb-3">
                    <label for="<?php echo $key; ?>" class="form-label"><?php echo $field['label']; ?></label>
                    <?php if($field['type'] === 'textarea'): ?>
                        <textarea class="form-control" name="<?php echo $key; ?>" id="<?php echo $key; ?>" rows="3"
                                  placeholder="<?php echo $field['label']; ?>" required></textarea>
                    <?php else: ?>
                        <input type="<?php echo $field['type']; ?>" class="form-control" name="<?php echo $key; ?>" id="<?php echo $key; ?>"
                               placeholder="<?php echo $field['label']; ?>" required>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                <div class="mb-3">
                    <a href="/" class="btn btn-light">Отмена</a>
                    <button type="submit" class="btn btn-success">Добавить</button>
                </div>
            </div>
        </form>
    </div>
</main>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>