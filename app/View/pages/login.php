<?php include_once __DIR__ . '/../layout/header.php'; ?>

    <main class="main pt-4">
        <div class="container">
            <div class="mb-4">
                <h1>Войти</h1>
            </div>

            <?php include_once __DIR__ . '/../parts/errors.php'; ?>

            <form action="/auth" method="post" class="form">
                <?php foreach ($fields as $k => $field): ?>
                    <div class="mb-3">
                        <label for="<?php echo $k; ?>" class="form-label"><?php echo $field['label']; ?></label>
                        <input type="<?php echo $field['type']; ?>" class="form-control" name="<?php echo $k; ?>" id="<?php echo $k; ?>"
                               placeholder="<?php echo $field['label']; ?>" required>
                    </div>
                <?php endforeach; ?>
                <div class="mb-3">
                    <a href="/" class="btn btn-light">Отмена</a>
                    <button type="submit" class="btn btn-success">Войти</button>
                </div>
            </form>
        </div>
    </main>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>